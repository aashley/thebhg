<?php
class KAGEvent {
	var $id;
	var $kag;
	var $name;
	var $start;
	var $wstart;
	var $wend;
	var $type;
	var $content;
	var $end;
	var $db;

	function KAGEvent($id, $db) {
		$this->id = $id;
		$this->db = $db;
		$this->UpdateCache();
	}

	function UpdateCache() {
		$result = mysql_query('SELECT kag, name, start, end, wstart, wend, type, content FROM kag_events WHERE id=' . $this->id, $this->db);
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
	
	function isGraded(){
		$sql = "SELECT `id` FROM `kag_signups` WHERE `rank` > 0 AND `event` = ".$this->id." LIMIT 1";
		return (mysql_num_rows(mysql_query($sql, $this->db)) == 1);
	}
	
	function GetTypes(){
		return new KAGType($this->type, $this->db);
	}
	
	function IsTimed(){
		return ($this->type > 0);
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
	
	function GetWindowStart() {
		return $this->wstart;
	}

	function GetWindowEnd() {
		return $this->wend;
	}

	function GetContent(){
	    return unserialize(base64_decode($this->content));
    }
	
	function GetSignups() {
		$result = mysql_query('SELECT id, IF(state IN (1, 4), 1, 0) AS main FROM kag_signups WHERE kag=' . $this->kag . ' AND event=' . $this->id . ' ORDER BY submitted ASC, points DESC, main DESC', $this->db);
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
	
	function GetRankSignups() {
		$result = mysql_query('SELECT id, rank, IF(state IN (1, 4), 1, 0) AS main FROM kag_signups WHERE kag=' . $this->kag . ' AND event=' . $this->id . ' ORDER BY submitted ASC, points DESC, main DESC', $this->db);
		if ($result && mysql_num_rows($result)) {
			$signups = array();
			while ($row = mysql_fetch_array($result)) {
				$signups[$row['rank']][] =& new KAGSignup($row['id'], $this->db);
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
	
	function SetContent($content) {
		if (mysql_query('UPDATE kag_events SET content="' . $content . '" WHERE id=' . $this->id, $this->db)) {
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

	function SetWindow($start, $end) {
		if (mysql_query('UPDATE kag_events SET wstart=' . ((int) $start) . ', wend=' . ((int) $end) . ' WHERE id=' . $this->id, $this->db)) {
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
