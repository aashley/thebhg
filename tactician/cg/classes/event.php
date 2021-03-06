<?php
class CGEvent {
	var $id;
	var $cg;
	var $name;
	var $type;
	var $content;
	var $start;
	var $team;
	var $end;
	var $db;

	function CGEvent($id, $db) {
		$this->id = $id;
		$this->db = $db;
		$this->UpdateCache();
	}

	function UpdateCache() {
		$result = mysql_query('SELECT cg, name, start, end, type, content, team FROM cg_events WHERE id=' . $this->id, $this->db);
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
		$sql = "SELECT `id` FROM `cg_signups` WHERE `state` > 0 AND `event` = ".$this->id." LIMIT 1";
		return (mysql_num_rows(mysql_query($sql, $this->db)) == 1);
	}
	
	function GetCG() {
		return new CG($this->cg, $this->db);
	}

	function GetName() {
		return $this->name;
	}

	function GetTypes(){
		return new CGType($this->type, $this->db);
	}
	
	function IsTeam(){
		return ($this->team == 1);
	}
	
	function IsTimed(){
		return ($this->type > 0);
	}
	
	function GetStart() {
		return $this->start;
	}

	function GetEnd() {
		return $this->end;
	}
	
	function GetContent(){
	    return unserialize(base64_decode($this->content));
    }
    
    function SetContent($content) {
		if (mysql_query('UPDATE cg_events SET content="' . $content . '" WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	function GetSignups() {
		$result = mysql_query('SELECT id, IF(state IN (1, 4), 1, 0) AS main FROM cg_signups WHERE cg=' . $this->cg . ' AND event=' . $this->id . ' ORDER BY points DESC, main DESC', $this->db);
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

	function SetName($name) {
		if (mysql_query('UPDATE cg_events SET name="' . addslashes($name) . '" WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}
	
	function SetTeam($name) {
		if (mysql_query('UPDATE cg_events SET team="' . addslashes($name) . '" WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	function SetTime($start, $end) {
		if (mysql_query('UPDATE cg_events SET start=' . ((int) $start) . ', end=' . ((int) $end) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	function DeleteEvent() {
		$state = true;
		if (mysql_query('DELETE FROM cg_events WHERE id=' . $this->id, $this->db)) {
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
		$cadre =& $person->GetCadre();
		if (mysql_query('INSERT INTO cg_signups (person, cg, event, cadre) VALUES (' . $person->GetID() . ', ' . $this->cg . ', ' . $this->id . ', ' . $cadre->GetID() . ')', $this->db)) {
			return new CGSignup(mysql_insert_id($this->db), $this->db);
		}
		else {
			return false;
		}
	}
}
?>
