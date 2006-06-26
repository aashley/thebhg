<?php
/**
 * A class representing a CG.
 *
 * @access public
 * @author Adam Harvey <jernai@iinet.net.au>
 * @paccge CG
 * @version 1.0.0
 */
class CG {
	/**#@+
	 * A variety of class members that shouldn't be accessed from the
	 * outside world.
	 *
	 * @access private
	 * @var int
	 */
	var $id;
	var $signup_start;
	var $signup_end;
	var $start;
	var $end;
	var $maximum;
	var $minimum;
	var $dnp;
	var $noeffort;
	var $penalty;
	var $db;
	/**#@-*/

	/**
	 * Constructs a new CG object. Generally speaking, a CG object
	 * wouldn't be constructed directly by client code.
	 *
	 * @access public
	 * @param int $id The CG ID to create.
	 * @param resource $db The database connection to use.
	 * @see CGBase::GetCG()
	 */
	function CG($id, $db) {
		$this->id = (int) $id;
		$this->db = $db;
		$this->UpdateCache();
	}

	/**
	 * Updates the object's internal cache.
	 *
	 * @access private
	 * @return void
	 */
	function UpdateCache() {
		$result = mysql_query('SELECT signup_start, signup_end, start, end, maximum, minimum, dnp, noeffort, penalty FROM cgs WHERE id=' . $this->id, $this->db);
		if ($result && mysql_num_rows($result)) {
			$row = mysql_fetch_array($result);
			foreach ($row as $field=>$val) {
				$this->$field = $val;
			}
		}
	}

	/**
	 * Updates the points for all signups in the CG.
	 *
	 * @access private
	 * @param int $state The type of state to update the points for.
	 * @return void
	 */
	function UpdatePoints($state) {
		$signups = $this->GetSignups($state);
		if ($signups) {
			foreach ($this->GetSignups($state) as $signup) {
				switch ($signup->GetState()) {
					case 1:
						$points = $this->maximum - ($signup->GetRank() - 1);
						if ($points < $this->minimum) {
							$points = $this->minimum;
						}
						$signup->SetPoints($points);
						break;
					case 2:
						$signup->SetPoints($this->dnp);
						break;
					case 3:
						$signup->SetPoints($this->noeffort);
						break;
					case 4:
						$points = $this->maximum - ($signup->GetRank() - 1) - $this->penalty;
						if ($points < $this->minimum) {
							$points = $this->minimum;
						}
						$signup->SetPoints($points);
						break;
				}
			}
		}
	}

	/**
	 * Returns the CG ID.
	 *
	 * @access public
	 * @return int
	 */
	function GetID() {
		return $this->id;
	}

	/**
	 * Returns the UNIX timestamp corresponding to the date and time that
	 * signups start.
	 *
	 * @access public
	 * @return int
	 */
	function GetSignupStart() {
		return $this->signup_start;
	}

	/**
	 * Returns the UNIX timestamp corresponding to the date and time that
	 * signups end.
	 *
	 * @access public
	 * @return int
	 */
	function GetSignupEnd() {
		return $this->signup_end;
	}

	/**
	 * Returns the UNIX timestamp corresponding to the date and time that
	 * events start.
	 *
	 * @access public
	 * @return int
	 */
	function GetStart() {
		return $this->start;
	}

	/**
	 * Returns the UNIX timestamp corresponding to the date and time that
	 * events end.
	 *
	 * @access public
	 * @return int
	 */
	function GetEnd() {
		return $this->end;
	}

	/**
	 * Returns the maximum number of points a hunter can earn for an event.
	 * In other words, this is the number of points first place will take.
	 *
	 * @access public
	 * @return int
	 */
	function GetMaximum() {
		return $this->maximum;
	}

	/**
	 * Returns the minimum number of points a hunter can earn for an event.
	 * This is usually zero or one, although any value is valid.
	 *
	 * @access public
	 * @return int
	 */
	function GetMinimum() {
		return $this->minimum;
	}

	/**
	 * Returns the number of points a DNP is worth.
	 * (Heh, heh.) Has been -15, -10, and -5 at various points in the past.
	 *
	 * @access public
	 * @return int
	 */
	function GetDNP() {
		return $this->dnp;
	}

	/**
	 * Returns the number of points a hunter can earn given a no effort
	 * submission or a disqualification.
	 *
	 * @access public
	 * @return int
	 */
	function GetNoEffort() {
		return $this->noeffort;
	}

	/**
	 * Returns the number of points a hunter will be penalised for breaking
	 * the rules of an event.
	 *
	 * @access public
	 * @return int
	 */
	function GetPenalty() {
		return $this->penalty;
	}

	/**
	 * Returns the events in the CG.
	 * The events will be ordered by start time, then end time, then name.
	 *
	 * @access public
	 * @return mixed An array of {@link CGEvent CGEvent objects}, or
	 *               false if there are no events in the CG.
	 */
	function GetEvents() {
		$result = mysql_query('SELECT id FROM cg_events WHERE cg=' . $this->id . ' ORDER BY start ASC, end ASC, name ASC', $this->db);
		if ($result && mysql_num_rows($result)) {
			$events = array();
			while ($row = mysql_fetch_array($result)) {
				$events[$row['id']] =& new CGEvent($row['id'], $this->db);
			}
			return $events;
		}
		else {
			return false;
		}
	}

	/**
	 * Returns the signups in the CG.
	 * The signups aren't ordered in any specific way, mostly because I
	 * couldn't think of any sane way to order them.
	 *
	 * @access public
	 * @param int $state Only return signups that are in this state.
	 * @return mixed An array of {@link CGSignup CGSignup objects}, or
	 *               false if there are no signups in the CG.
	 */
	function GetSignups($state = false) {
		$sql = 'SELECT id FROM cg_signups WHERE cg=' . $this->id;
		if ($state !== false) {
			$sql .= ' AND state=' . ((int) $state);
		}
		$result = mysql_query($sql, $this->db);
		if ($result && mysql_num_rows($result)) {
			$signups = array();
			while ($row = mysql_fetch_array($result)) {
				$signups[$row['id']] =& new CGSignup($row['id'], $this->db);
			}
			return $signups;
		}
		else {
			return false;
		}
	}

	/**
	 * Returns the signups belonging to a particular hunter.
	 *
	 * @access public
	 * @param object Person $hunter The hunter to search for.
	 * @return mixed An array of {@link CGSignup CGSignup objects}, or
	 *               false if the hunter doesn't have any signups in this
	 *               CG.
	 */
	function GetHunterSignups($hunter) {
		if (is_a($hunter, 'person')) {
			$hunter = $hunter->GetID();
		}
		$result = mysql_query('SELECT id, event FROM cg_signups WHERE cg=' . $this->id . ' AND person=' . ((int) $hunter) . ' ORDER BY state ASC, points DESC', $this->db);
		if ($result && mysql_num_rows($result)) {
			$signups = array();
			while ($row = mysql_fetch_array($result)) {
				$signups[$row['event']] =& new CGSignup($row['id'], $this->db);
			}
			return $signups;
		}
		else {
			return false;
		}
	}

	/**
	 * Returns the signups belonging to a particular cadre.
	 *
	 * @access public
	 * @param object Cadre $cadre The cadre to search for.
	 * @return mixed An array of {@link CGSignup CGSignup objects}, or
	 *               false if the cadre doesn't have any signups in this
	 *               CG.
	 */
	function GetCadreSignups($cadre) {
		if (is_a($cadre, 'cadre')) {
			$cadre = $cadre->GetID();
		}
		$result = mysql_query('SELECT id, event FROM cg_signups WHERE cg=' . $this->id . ' AND cadre=' . ((int) $cadre) . ' ORDER BY state ASC, points DESC', $this->db);
		if ($result && mysql_num_rows($result)) {
			$signups = array();
			while ($row = mysql_fetch_array($result)) {
				$signups[] =& new CGSignup($row['id'], $this->db);
			}
			return $signups;
		}
		else {
			return false;
		}
	}

	/**
	 * Returns all the hunters participating in this CG.
	 *
	 * @access public
	 * @return mixed An array of {@link Person Person objects}, or false if
	 *               there are no signups in this CG.
	 */
	function GetHunters() {
		$result = mysql_query('SELECT person FROM cg_signups WHERE cg=' . $this->id . ' GROUP BY person', $this->db);
		if ($result && mysql_num_rows($result)) {
			$hunters = array();
			while ($row = mysql_fetch_array($result)) {
				$hunter =& new Person($row['person']);
				$hunters[$hunter->GetName()] =& $hunter;
			}
			ksort($hunters);
			return $hunters;
		}
		else {
			return false;
		}
	}

	/**
	 * Returns all the hunters from a particular cadre who are taking part
	 * in this CG.
	 *
	 * @access public
	 * @param object Cadre $cadre The cadre to search for.
	 * @return mixed An array of {@link Person Person objects}, or false if
	 *               the cadre has no signups.
	 */
	function GetCadreHunters($cadre) {
		if (is_a($cadre, 'cadre')) {
			$cadre = $cadre->GetID();
		}
		$result = mysql_query('SELECT person FROM cg_signups WHERE cg=' . $this->id . ' AND cadre=' . ((int) $cadre) . ' GROUP BY person', $this->db);
		if ($result && mysql_num_rows($result)) {
			$hunters = array();
			while ($row = mysql_fetch_array($result)) {
				$hunter =& new Person($row['person']);
				$hunters[$hunter->GetName()] =& $hunter;
			}
			ksort($hunters);
			return $hunters;
		}
		else {
			return false;
		}
	}

	/**
	 * Returns the total points a particular cadre has earned in this CG.
	 *
	 * @access public
	 * @param object Cadre $cadre The cadre to look up.
	 * @return int
	 */
	function GetCadreTotal($cadre) {
		if (is_a($cadre, 'cadre')) {
			$cadre = $cadre->GetID();
		}
		$result = mysql_query('SELECT SUM(points) AS total FROM cg_signups WHERE cadre=' . ((int) $cadre) . ' AND cg=' . $this->id, $this->db);
		if ($result && mysql_num_rows($result)) {
			return mysql_result($result, 0, 'total');
		}
		else {
			return 0;
		}
	}

	/**
	 * Returns the total points for all cadres participating in this CG.
	 * The resultant array is ordered from highest scoring cadre to lowest.
	 * An example of how to use this function is provided below.
	 * <br /><br />
	 * <code>
	 * <?php
	 * // For the purposes of this example, assume that the $cg and
	 * // $roster variables have already been set.
	 * $totals = $cg->GetCadreTotals();
	 * echo '<table>';
	 * foreach ($totals as $kid=>$total) {
	 * 	$cadre = $roster->GetCadre($kid);
	 * 	echo '<tr><td>' . $cadre->GetName() . '</td><td>' .
	 * 		number_format($total) . '</td></tr>';
	 * }
	 * echo '</table>';
	 * ?>
	 * </code>
	 *
	 * @access public
	 * @return array An associative array in which the keys are set to the
	 *               cadre IDs, and the values are set to the totals.
	 */
	function GetCadreTotals() {
		$result = mysql_query('SELECT SUM(points) AS total, cadre FROM cg_signups WHERE cg=' . $this->id . ' GROUP BY cadre ORDER BY total DESC', $this->db);
		if ($result && mysql_num_rows($result)) {
			$cadres = array();
			while ($row = mysql_fetch_array($result)) {
				$cadres[$row['cadre']] = $row['total'];
			}
			arsort($cadres);
			return $cadres;
		}
		else {
			return false;
		}
	}

	/**
	 * Returns the total points for all hunters participating in this CG.
	 * The resultant array is ordered from the highest scoring hunter to
	 * the lowest. An example of how to use this function is provided
	 * below.
	 * <br /><br />
	 * <code>
	 * <?php
	 * // For the purposes of this example, assume that the $cg and
	 * // $roster variables have already been set.
	 * $totals = $cg->GetHunterTotals();
	 * echo '<table>';
	 * echo '<tr><th>Name</th><th>Cadre</th><th>Points</th></tr>';
	 * foreach ($totals as $array) {
	 * 	echo '<tr><td>' . $array['hunter']->GetName() . '</td>' .
	 * 		'<td>' . $array['cadre']->GetName() . '</td>' . 
	 * 		'<td>' . number_format($array['total']) . '</td></tr>';
	 * }
	 * echo '</table>';
	 * ?>
	 * </code>
	 *
	 * @access public
	 * @param int $limit The number of hunters to return, or zero to return
	 *                   all records.
	 * @return array An associative array of associative arrays. See the
	 *               example code for details.
	 */
	function GetHunterTotals($limit = 0) {
		$result = mysql_query('SELECT SUM(points) AS total, person, cadre FROM cg_signups WHERE cg=' . $this->id . ' GROUP BY person, cadre ORDER BY total DESC' . ($limit > 0 ? ' LIMIT ' . $limit : ''), $this->db);
		if ($result && mysql_num_rows($result)) {
			$hunters = array();
			while ($row = mysql_fetch_array($result)) {
				$array = array('hunter'=>new Person($row['person']), 'total'=>$row['total'], 'cadre'=>new Cadre($row['cadre']));
				$hunters[] = $array;
			}
			return $hunters;
		}
		else {
			return false;
		}
	}

	/**
	 * Changes the dates that hunters can signup in.
	 *
	 * @access public
	 * @param int $start A UNIX timestamp corresponding to the start date.
	 * @param int $end A UNIX timestamp corresponding to the end date.
	 * @return boolean True on success, false otherwise.
	 */
	function SetSignup($start, $end) {
		if (mysql_query('UPDATE cgs SET signup_start=' . ((int) $start) . ', signup_end=' . ((int) $end) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Changes the dates that the CG itself runs.
	 *
	 * @access public
	 * @param int $start A UNIX timestamp corresponding to the start date.
	 * @param int $end A UNIX timestamp corresponding to the end date.
	 * @return boolean True on success, false otherwise.
	 */
	function SetTime($start, $end) {
		if (mysql_query('UPDATE cgs SET start=' . ((int) $start) . ', end=' . ((int) $end) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Sets the maximum number of points that a hunter can earn for one
	 * event.
	 *
	 * @access public
	 * @param int $maximum The new number of points.
	 * @return boolean True on success, false otherwise.
	 */
	function SetMaximum($maximum) {
		if (mysql_query('UPDATE cgs SET maximum=' . ((int) $maximum) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			$this->UpdatePoints(1);
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Sets the minimum number of points that a hunter can earn for one
	 * event.
	 *
	 * @access public
	 * @param int $minimum The new number of points.
	 * @return boolean True on success, false otherwise.
	 */
	function SetMinimum($minimum) {
		if (mysql_query('UPDATE cgs SET minimum=' . ((int) $minimum) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			$this->UpdatePoints(1);
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Sets the number of points awarded for a DNP.
	 *
	 * @access public
	 * @param int $dnp The new number of points.
	 * @return boolean True on success, false otherwise.
	 */
	function SetDNP($dnp) {
		if (mysql_query('UPDATE cgs SET dnp=' . ((int) $dnp) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			$this->UpdatePoints(2);
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Sets the number of points awarded for a no effort submission or a
	 * disqualification.
	 *
	 * @access public
	 * @param int $noeffort The new number of points.
	 * @return boolean True on success, false otherwise.
	 */
	function SetNoEffort($noeffort) {
		if (mysql_query('UPDATE cgs SET noeffort=' . ((int) $noeffort) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			$this->UpdatePoints(3);
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Sets the number of points deducted when a penalty is applied.
	 *
	 * @access public
	 * @param int $penalty The new number of points.
	 * @return boolean True on success, false otherwise.
	 */
	function SetPenalty($penalty) {
		if (mysql_query('UPDATE cgs SET penalty=' . ((int) $penalty) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			$this->UpdatePoints(4);
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Deletes the CG from the database.
	 *
	 * @access public
	 * @return boolean True on success, false otherwise.
	 */
	function DeleteCG() {
		$state = true;
		if (mysql_query('DELETE FROM cgs WHERE id=' . $this->id, $this->db)) {
			foreach ($this->GetEvents() as $event) {
				if (!$event->DeleteEvent()) {
					$state = false;
				}
			}
			return $state;
		}
		else {
			return false;
		}
	}

	/**
	 * Adds a new event to the CG.
	 *
	 * @access public
	 * @param string $name The name of the event.
	 * @param int $start A UNIX timestamp corresponding to the start time
	 *                   of the event.
	 * @param int $end A UNIX timestamp corresponding to the end time of
	 *                 the event.
	 * @param boolean $marked True if the event has already been marked, or
	 *                        false if not.
	 * @return boolean True on success, false otherwise.
	 */
	function AddEvent($name, $start, $end, $marked = false, $content = '', $type = 0) {
		if($type != '0') {
			$tclass = new CGType($type,$this->db);
			$name = $tclass->GetName();
		}
		$sql = 'INSERT INTO cg_events (kag, name, start, end, content, type) VALUES (' . $this->id . ', "' . addslashes($name) . '", ' . ((int) $start) . ', ' . ((int) $end) . ', "' . $content . '", ' . $type . ')';
		if (mysql_query($sql, $this->db)) {
			return new CGEvent(mysql_insert_id($this->db), $this->db);
		}
		else {
			echo mysql_error($this->db);
			return false;
		}
	}

	/**
	 * E-mails a hunter with their signups.
	 * Generally only needs to be called from the "Edit Signup" page in CG
	 * administration.
	 *
	 * @access public
	 * @param object Person $hunter The hunter to mail.
	 * @return void
	 */
	function EmailSignups($hunter) {
		$signups =& $this->GetHunterSignups($hunter);
		if ($signups) {
			$events = array();
			foreach ($signups as $signup) {
				$event =& $signup->GetEvent();
				$events[] = $event->GetName();
			}
			$message = $hunter->GetName() . ', you have signed up for the following events in CG ' . $this->id . ".\n\n";
			$message .= implode("\n", $events);
			$message .= "\n\nYou may alter your signups at any time until " . date('j F Y \a\t G:i:s T', $this->signup_end) . ".\n\nGood luck!\n\nKabal Authority";
		}
		else {
			$message = $hunter->GetName() . ', you are no longer signed up for any events in CG ' . $this->id . ".\n\nKabal Authority";
		}
		mail($hunter->GetEmail() . ', Kabal Authority <cadregames@thebhg.org>', '[CG ' . $this->id . '] Change to Signed Up Events', $message, "From: Kabal Authority <cadregames@thebhg.org>\r\nReply-To: Kabal Authority <cadregames@thebhg.org>\r\nX-Mailer: PHP");
	}
}
?>
