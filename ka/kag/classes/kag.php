<?php
/**
 * A class representing a KAG.
 *
 * @access public
 * @author Adam Harvey <jernai@iinet.net.au>
 * @package KAG
 * @version 1.0.0
 */
class KAG {
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
	 * Constructs a new KAG object. Generally speaking, a KAG object
	 * wouldn't be constructed directly by client code.
	 *
	 * @access public
	 * @param int $id The KAG ID to create.
	 * @param resource $db The database connection to use.
	 * @see KAGBase::GetKAG()
	 */
	function KAG($id, $db) {
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
		$result = mysql_query('SELECT signup_start, signup_end, start, end, maximum, minimum, dnp, noeffort, penalty FROM kags WHERE id=' . $this->id, $this->db);
		if ($result && mysql_num_rows($result)) {
			$row = mysql_fetch_array($result);
			foreach ($row as $field=>$val) {
				$this->$field = $val;
			}
		}
	}

	/**
	 * Updates the points for all signups in the KAG.
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
	 * Returns the KAG ID.
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
	 * Returns the events in the KAG.
	 * The events will be ordered by start time, then end time, then name.
	 *
	 * @access public
	 * @return mixed An array of {@link KAGEvent KAGEvent objects}, or
	 *               false if there are no events in the KAG.
	 */
	function GetEvents() {
		$result = mysql_query('SELECT id FROM kag_events WHERE kag=' . $this->id . ' ORDER BY start ASC, end ASC, name ASC', $this->db);
		if ($result && mysql_num_rows($result)) {
			$events = array();
			while ($row = mysql_fetch_array($result)) {
				$events[$row['id']] =& new KAGEvent($row['id'], $this->db);
			}
			return $events;
		}
		else {
			return false;
		}
	}

	/**
	 * Returns the signups in the KAG.
	 * The signups aren't ordered in any specific way, mostly because I
	 * couldn't think of any sane way to order them.
	 *
	 * @access public
	 * @param int $state Only return signups that are in this state.
	 * @return mixed An array of {@link KAGSignup KAGSignup objects}, or
	 *               false if there are no signups in the KAG.
	 */
	function GetSignups($state = false) {
		$sql = 'SELECT id FROM kag_signups WHERE kag=' . $this->id;
		if ($state !== false) {
			$sql .= ' AND state=' . ((int) $state);
		}
		$result = mysql_query($sql, $this->db);
		if ($result && mysql_num_rows($result)) {
			$signups = array();
			while ($row = mysql_fetch_array($result)) {
				$signups[$row['id']] =& new KAGSignup($row['id'], $this->db);
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
	 * @return mixed An array of {@link KAGSignup KAGSignup objects}, or
	 *               false if the hunter doesn't have any signups in this
	 *               KAG.
	 */
	function GetHunterSignups($hunter) {
		if (is_a($hunter, 'person')) {
			$hunter = $hunter->GetID();
		}
		$result = mysql_query('SELECT id, event FROM kag_signups WHERE kag=' . $this->id . ' AND person=' . ((int) $hunter) . ' ORDER BY state ASC, points DESC', $this->db);
		if ($result && mysql_num_rows($result)) {
			$signups = array();
			while ($row = mysql_fetch_array($result)) {
				$signups[$row['event']] =& new KAGSignup($row['id'], $this->db);
			}
			return $signups;
		}
		else {
			return false;
		}
	}

	/**
	 * Returns all the hunters participating in this KAG.
	 *
	 * @access public
	 * @return mixed An array of {@link Person Person objects}, or false if
	 *               there are no signups in this KAG.
	 */
	function GetHunters() {
		$result = mysql_query('SELECT person FROM kag_signups WHERE kag=' . $this->id . ' GROUP BY person', $this->db);
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
	 * Returns all the hunters from a particular kabal who are taking part
	 * in this KAG.
	 *
	 * @access public
	 * @param object Kabal $kabal The kabal to search for.
	 * @return mixed An array of {@link Person Person objects}, or false if
	 *               the kabal has no signups.
	 */
	function GetKabalHunters($kabal) {
		if (is_a($kabal, 'division')) {
			$kabal = $kabal->GetID();
		}
		$result = mysql_query('SELECT person FROM kag_signups WHERE kag=' . $this->id . ' AND kabal=' . ((int) $kabal) . ' GROUP BY person', $this->db);
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
	 * Returns the total points a particular kabal has earned in this KAG.
	 *
	 * @access public
	 * @param object Kabal $kabal The kabal to look up.
	 * @return int
	 */
	function GetKabalTotal($kabal) {
		if (is_a($kabal, 'division')) {
			$kabal = $kabal->GetID();
		}
		$result = mysql_query('SELECT SUM(points) AS total FROM kag_signups WHERE kabal=' . ((int) $kabal) . ' AND kag=' . $this->id, $this->db);
		if ($result && mysql_num_rows($result)) {
			return mysql_result($result, 0, 'total');
		}
		else {
			return 0;
		}
	}

	/**
	 * Returns the total points for all kabals participating in this KAG.
	 * The resultant array is ordered from highest scoring kabal to lowest.
	 * An example of how to use this function is provided below.
	 * <br /><br />
	 * <code>
	 * <?php
	 * // For the purposes of this example, assume that the $kag and
	 * // $roster variables have already been set.
	 * $totals = $kag->GetKabalTotals();
	 * echo '<table>';
	 * foreach ($totals as $kid=>$total) {
	 * 	$kabal = $roster->GetKabal($kid);
	 * 	echo '<tr><td>' . $kabal->GetName() . '</td><td>' .
	 * 		number_format($total) . '</td></tr>';
	 * }
	 * echo '</table>';
	 * ?>
	 * </code>
	 *
	 * @access public
	 * @return array An associative array in which the keys are set to the
	 *               kabal IDs, and the values are set to the totals.
	 */
	function GetKabalTotals() {
		$result = mysql_query('SELECT SUM(points) AS total, kabal FROM kag_signups WHERE kag=' . $this->id . ' GROUP BY kabal ORDER BY total DESC', $this->db);
		if ($result && mysql_num_rows($result)) {
			$kabals = array();
			while ($row = mysql_fetch_array($result)) {
				$kabals[$row['kabal']] = $row['total'];
			}
			arsort($kabals);
			return $kabals;
		}
		else {
			return false;
		}
	}

	/**
	 * Returns the total points for all hunters participating in this KAG.
	 * The resultant array is ordered from the highest scoring hunter to
	 * the lowest. An example of how to use this function is provided
	 * below.
	 * <br /><br />
	 * <code>
	 * <?php
	 * // For the purposes of this example, assume that the $kag and
	 * // $roster variables have already been set.
	 * $totals = $kag->GetHunterTotals();
	 * echo '<table>';
	 * echo '<tr><th>Name</th><th>Kabal</th><th>Points</th></tr>';
	 * foreach ($totals as $array) {
	 * 	echo '<tr><td>' . $array['hunter']->GetName() . '</td>' .
	 * 		'<td>' . $array['kabal']->GetName() . '</td>' . 
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
		$result = mysql_query('SELECT SUM(points) AS total, person, kabal FROM kag_signups WHERE kag=' . $this->id . ' GROUP BY person, kabal ORDER BY total DESC' . ($limit > 0 ? ' LIMIT ' . $limit : ''), $this->db);
		if ($result && mysql_num_rows($result)) {
			$hunters = array();
			while ($row = mysql_fetch_array($result)) {
				$array = array('hunter'=>new Person($row['person']), 'total'=>$row['total'], 'kabal'=>new Kabal($row['kabal']));
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
		if (mysql_query('UPDATE kags SET signup_start=' . ((int) $start) . ', signup_end=' . ((int) $end) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Changes the dates that the KAG itself runs.
	 *
	 * @access public
	 * @param int $start A UNIX timestamp corresponding to the start date.
	 * @param int $end A UNIX timestamp corresponding to the end date.
	 * @return boolean True on success, false otherwise.
	 */
	function SetTime($start, $end) {
		if (mysql_query('UPDATE kags SET start=' . ((int) $start) . ', end=' . ((int) $end) . ' WHERE id=' . $this->id, $this->db)) {
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
		if (mysql_query('UPDATE kags SET maximum=' . ((int) $maximum) . ' WHERE id=' . $this->id, $this->db)) {
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
		if (mysql_query('UPDATE kags SET minimum=' . ((int) $minimum) . ' WHERE id=' . $this->id, $this->db)) {
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
		if (mysql_query('UPDATE kags SET dnp=' . ((int) $dnp) . ' WHERE id=' . $this->id, $this->db)) {
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
		if (mysql_query('UPDATE kags SET noeffort=' . ((int) $noeffort) . ' WHERE id=' . $this->id, $this->db)) {
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
		if (mysql_query('UPDATE kags SET penalty=' . ((int) $penalty) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			$this->UpdatePoints(4);
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Deletes the KAG from the database.
	 *
	 * @access public
	 * @return boolean True on success, false otherwise.
	 */
	function DeleteKAG() {
		$state = true;
		if (mysql_query('DELETE FROM kags WHERE id=' . $this->id, $this->db)) {
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
	 * Adds a new event to the KAG.
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
	function AddEvent($name, $start, $end, $marked = false, $content, $type) {
		if (mysql_query('INSERT INTO kag_events (kag, name, start, end, content, type) VALUES (' . $this->id . ', "' . addslashes($name) . '", ' . ((int) $start) . ', ' . ((int) $end) . ', "' . $content . '", ' . $type . ')', $this->db)) {
			return new KAGEvent(mysql_insert_id($this->db), $this->db);
		}
		else {
			echo mysql_error($this->db);
			return false;
		}
	}

	/**
	 * E-mails a hunter with their signups.
	 * Generally only needs to be called from the "Edit Signup" page in KAG
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
				if ($event->IsTimed()){
					$event = $event->GetTypes();
				}
				$events[] = $event->GetName();
			}
			$message = $hunter->GetName() . ', you have signed up for the following events in KAG ' . $this->id . ".\n\n";
			$message .= implode("\n", $events);
			$message .= "\n\nYou may alter your signups at any time until " . date('j F Y \a\t G:i:s T', $this->signup_end) . ".\n\nGood luck!\n\nKabal Authority";
		}
		else {
			$message = $hunter->GetName() . ', you are no longer signed up for any events in KAG ' . $this->id . ".\n\nKabal Authority";
		}
		mail($hunter->GetEmail() . ', Kabal Authority <kabalgames@thebhg.org>', '[KAG ' . $this->id . '] Change to Signed Up Events', $message, "From: Kabal Authority <kabalgames@thebhg.org>\r\nReply-To: Kabal Authority <kabalgames@thebhg.org>\r\nX-Mailer: PHP");
	}
}
?>
