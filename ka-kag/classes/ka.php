<?php
class KAGBase {
	var $db;

	function KAGBase($db) {
		$this->db = $db;
	}

	function GetKAGs() {
		$result = mysql_query('SELECT id FROM kags ORDER BY id', $this->db);
		if ($result && mysql_num_rows($result)) {
			$kags = array();
			while ($row = mysql_fetch_array($result)) {
				$kags[$row['id']] =& new KAG($row['id'], $this->db);
			}
			return $kags;
		}
		else {
			return false;
		}
	}

	function GetKAG($id) {
		$result = mysql_query('SELECT id FROM kags WHERE id=' . $id, $this->db);
		if ($result && mysql_num_rows($result)) {
			return new KAG($id, $this->db);
		}
		else {
			return false;
		}
	}

	function GetEvent($id) {
		$result = mysql_query('SELECT id FROM kag_events WHERE id=' . $id, $this->db);
		if ($result && mysql_num_rows($result)) {
			return new KAGEvent($id, $this->db);
		}
		else {
			return false;
		}
	}

	function GetSignup($id) {
		$result = mysql_query('SELECT id FROM kag_signups WHERE id=' . $id, $this->db);
		if ($result && mysql_num_rows($result)) {
			return new KAGSignup($id, $this->db);
		}
		else {
			return false;
		}
	}

	function GetHunterSignups($hunter, $kabal = false) {
		if (get_class($hunter) == 'person') {
			$hunter = $hunter->GetID();
		}
		if (is_a($kabal, 'division')) {
			$kabal = $kabal->GetID();
		}
		$sql = 'SELECT id FROM kag_signups WHERE person=' . ((int) $hunter);
		if ($kabal !== false) {
			$sql .= ' AND kabal=' . ((int) $kabal);
		}
		$sql .= ' ORDER BY kag ASC';
		$result = mysql_query($sql, $this->db);
		if ($result && mysql_num_rows($result)) {
			$signups = array();
			while ($row = mysql_fetch_array($result)) {
				$signups[] =& new KAGSignup($row['id'], $this->db);
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
		$result = mysql_query('SELECT id FROM kag_ranks WHERE id=' . ((int) $rank), $this->db);
		if ($result && mysql_num_rows($result)) {
			return new KAGRank($rank, $this->db);
		}
		else {
			return false;
		}
	}

	function GetOpenKAGs() {
		$result = mysql_query('SELECT id FROM kags WHERE signup_start<=UNIX_TIMESTAMP() AND signup_end>=UNIX_TIMESTAMP() ORDER BY id ASC', $this->db);
		if ($result && mysql_num_rows($result)) {
			$kags = array();
			while ($row = mysql_fetch_array($result)) {
				$kags[$row['id']] =& new KAG($row['id'], $this->db);
			}
			return $kags;
		}
		else {
			return false;
		}
	}

	function AddKAG($id, $signup_start, $signup_end, $start, $end, $maximum, $minimum, $dnp, $noeffort, $penalty) {
		if (mysql_query('INSERT INTO kags (id, signup_start, signup_end, start, end, maximum, minimum, dnp, noeffort, penalty) VALUES ("' . ((int) $id) . '", "' . ((int) $signup_start) . '", "' . ((int) $signup_end) . '", "' . ((int) $start) . '", "' . ((int) $end) . '", "' . ((int) $maximum) . '", "' . ((int) $minimum) . '", "' . ((int) $dnp) . '", "' . ((int) $noeffort) . '", "' . ((int) $penalty) . '")', $this->db)) {
			return new KAG($id, $this->db);
		}
		else {
			return false;
		}
	}

	function AddRankFee($id, $fee) {
		if (mysql_query('INSERT INTO kag_ranks (id, fee) VALUES ('. ((int) $id) . ', ' . ((int) $fee) . ')', $this->db)) {
			return new KAGRank($id, $this->db);
		}
		else {
			return false;
		}
	}
}
?>
