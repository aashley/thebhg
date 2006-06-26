<?php
class CGBase {
	var $db;

	function CGBase($db) {
		$this->db = $db;
	}

	function GetCGs() {
		$result = mysql_query('SELECT id FROM cgs ORDER BY id', $this->db);
		if ($result && mysql_num_rows($result)) {
			$cgs = array();
			while ($row = mysql_fetch_array($result)) {
				$cgs[$row['id']] =& new CG($row['id'], $this->db);
			}
			return $cgs;
		}
		else {
			return false;
		}
	}

	function GetCG($id) {
		$result = mysql_query('SELECT id FROM cgs WHERE id=' . $id, $this->db);
		if ($result && mysql_num_rows($result)) {
			return new CG($id, $this->db);
		}
		else {
			return false;
		}
	}

	function GetEvent($id) {
		$result = mysql_query('SELECT id FROM cg_events WHERE id=' . $id, $this->db);
		if ($result && mysql_num_rows($result)) {
			return new CGEvent($id, $this->db);
		}
		else {
			return false;
		}
	}

	function GetTypes() {
		$sql = 'SELECT * FROM `cg_types` WHERE `date_deleted` = 0 ORDER BY `name`';
		$query = mysql_query($sql, $this->db);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$return[] = new KAGType($info['id'], $this->db);
		}
		
		return $return;
	}
	
	function NewEventType($name, $desc, $abbr, $picture, $questions, $answers){
		$sql = "INSERT INTO `kag_types` (`name`, `desc`, `abbr`, `picture`, `questions`, `answers`) VALUES "
				."('".addslashes($name)."', '".addslashes($desc)."', '".addslashes($abbr)."', '$picture', '$questions', '$answers')";
		$query = mysql_query($sql, $this->db);
		
		return ($query ? true : false);
	}
	
	function GetSignup($id) {
		$result = mysql_query('SELECT id FROM cg_signups WHERE id=' . $id, $this->db);
		if ($result && mysql_num_rows($result)) {
			return new CGSignup($id, $this->db);
		}
		else {
			return false;
		}
	}

	function GetHunterSignups($hunter, $cadre = false) {
		if (get_class($hunter) == 'Person') {
			$hunter = $hunter->GetID();
		}
		if (is_a($cadre, 'cadre')) {
			$cadre = $cadre->GetID();
		}
		$sql = 'SELECT id FROM cg_signups WHERE person=' . ((int) $hunter);
		if ($cadre !== false) {
			$sql .= ' AND cadre=' . ((int) $cadre);
		}
		$sql .= ' ORDER BY cg ASC';
		$result = mysql_query($sql, $this->db);
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

	function GetRankFee($rank) {
		if (get_class($rank) == 'rank') {
			$rank = $rank->GetID();
		}
		$result = mysql_query('SELECT id FROM cg_ranks WHERE id=' . ((int) $rank), $this->db);
		if ($result && mysql_num_rows($result)) {
			return new CGRank($rank, $this->db);
		}
		else {
			return false;
		}
	}

	function GetOpenCGs() {
		$result = mysql_query('SELECT id FROM cgs WHERE signup_start<=UNIX_TIMESTAMP() AND signup_end>=UNIX_TIMESTAMP() ORDER BY id ASC', $this->db);
		if ($result && mysql_num_rows($result)) {
			$cgs = array();
			while ($row = mysql_fetch_array($result)) {
				$cgs[$row['id']] =& new CG($row['id'], $this->db);
			}
			return $cgs;
		}
		else {
			return false;
		}
	}

	function AddCG($id, $signup_start, $signup_end, $start, $end, $maximum, $minimum, $dnp, $noeffort, $penalty) {
		if (mysql_query('INSERT INTO cgs (id, signup_start, signup_end, start, end, maximum, minimum, dnp, noeffort, penalty) VALUES ("' . ((int) $id) . '", "' . ((int) $signup_start) . '", "' . ((int) $signup_end) . '", "' . ((int) $start) . '", "' . ((int) $end) . '", "' . ((int) $maximum) . '", "' . ((int) $minimum) . '", "' . ((int) $dnp) . '", "' . ((int) $noeffort) . '", "' . ((int) $penalty) . '")', $this->db)) {
			return new CG($id, $this->db);
		}
		else {
			return false;
		}
	}

	function AddRankFee($id, $fee) {
		if (mysql_query('INSERT INTO cg_ranks (id, fee) VALUES ('. ((int) $id) . ', ' . ((int) $fee) . ')', $this->db)) {
			return new CGRank($id, $this->db);
		}
		else {
			return false;
		}
	}
	
	function ConditionContent($string){
	    return base64_encode(serialize($string));
    }
}
?>
