<?php
class KAGEvent {
	var $id;
	var $kag;
	var $name;
	var $start;
	var $end;
	var $db;

	function KAGEvent($id, $db) {
		$this->id = $id;
		$this->db = $db;
		$this->UpdateCache();
	}

	function UpdateCache() {
		$result = mysql_query('SELECT kag, name, start, end FROM kag_events WHERE id=' . $this->id, $this->db);
		if ($result && mysql_num_rows($result)) {
			$row = mysql_fetch_array($result);
			foreach ($row as $field=>$val) {
				if (is_numeric($val)) {
					$this->$field = $val;
				}
				else {
					$this->$field = stripslashes($val);
				}
			}
		}
	}

	function GetID() {
		return $this->id;
	}

	function GetKAG() {
		return new KAG($this->kag, $this->db);
	}

	function GetName() {
		return $this->name;
	}

	function GetStart() {
		return $this->start;
	}

	function GetEnd() {
		return $this->end;
	}

	function GetSignups() {
		$result = mysql_query('SELECT id, IF(state IN (1, 4), 1, 0) AS main FROM kag_signups WHERE kag=' . $this->kag . ' AND event=' . $this->id . ' ORDER BY points DESC, main DESC', $this->db);
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

	function SetName($name) {
		if (mysql_query('UPDATE kag_events SET name="' . addslashes($name) . '" WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	function SetTime($start, $end) {
		if (mysql_query('UPDATE kag_events SET start=' . ((int) $start) . ', end=' . ((int) $end) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	function DeleteEvent() {
		$state = true;
		if (mysql_query('DELETE FROM kag_events WHERE id=' . $this->id, $this->db)) {
			$signups =& $this->GetSignups();
			if ($signups) {
				foreach ($this->GetSignups() as $signup) {
					if (!$signup->DeleteSignup()) {
						$state = false;
					}
				}
				return $state;
			}
			return true;
		}
		else {
			return false;
		}
	}

	function AddSignup($person) {
		$kabal =& $person->GetDivision();
		if (mysql_query('INSERT INTO kag_signups (person, kag, event, kabal) VALUES (' . $person->GetID() . ', ' . $this->kag . ', ' . $this->id . ', ' . $kabal->GetID() . ')', $this->db)) {
			return new KAGSignup(mysql_insert_id($this->db), $this->db);
		}
		else {
			return false;
		}
	}
}
?>
