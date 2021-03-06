<?php
class CGSignup {
	var $id;
	var $person;
	var $event;
	var $cg;
	var $cadre;
	var $state;
	var $rank;
	var $points;
	var $submitted;
	var $content;
	var $ip;
	var $db;
	
	function CGSignup($id, $db) {
		$this->id = $id;
		$this->db = $db;
		$this->UpdateCache();
	}

	function UpdateCache() {
		$result = mysql_query('SELECT person, event, cg, cadre, state, rank, points, ip, submitted, content FROM cg_signups WHERE id=' . $this->id, $this->db);
		if ($result && mysql_num_rows($result)) {
			$row = mysql_fetch_array($result);
			foreach ($row as $field=>$val) {
				$this->$field = $val;
			}
		}
	}

	function GetID() {
		return $this->id;
	}
	
	function GetIP(){
		return $this->ip;
	}
	
	function Edit($submitted, $content){
		$sql = "UPDATE `cg_signups` SET `submitted` = '$submitted', `content` = '$content' WHERE id = '".$this->id."'";
		$query = mysql_query($sql, $this->db);
		return ($query ? true : false);
	}

	function GetPerson() {
		return new Person($this->person);
	}

	function GetEvent() {
		return new CGEvent($this->event, $this->db);
	}

	function GetCG() {
		return new CG($this->cg, $this->db);
	}

	function GetCadre() {
		return new Cadre($this->cadre);
	}

	function GetState() {
		return $this->state;
	}

	function GetRank() {
		return $this->rank;
	}

	function GetPoints() {
		return $this->points;
	}

	function GetContent(){
	    return unserialize(base64_decode($this->content));
    }
    
    function GetSubmitted(){
	    return $this->submitted;
    }
	
	function GetCredits() {
		$hunter = $this->GetPerson();
		$rank = $hunter->GetRank();
		$fee = new CGRank($rank->GetID(), $this->db);
		switch ($this->state) {
			case 1: case 4:
				switch ($this->rank) {
					case 1:
						$credits = ($this->getEvent()->isTeam() ? 125000 : 200000);
						break;
					case 2:
						$credits = ($this->getEvent()->isTeam() ? 75000 : 150000);
						break;
					case 3:
						$credits = ($this->getEvent()->isTeam() ? 50000 : 100000);
						break;
					default:
						$credits = 50000;
				}
				break;
			case 2:
				$credits = $fee->GetFee() * -1;
				break;
			default:
				$credits = 0;
		}
		return $credits;
	}

	function SetCadre($cadre) {
		if (is_a($cadre, 'cadre')) {
			$cadre = $cadre->GetID();
		}
		if (mysql_query('UPDATE cg_signups SET cadre=' . ((int) $cadre) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}
	
	function Submit($ip, $answer) {
		if (mysql_query('UPDATE cg_signups SET content="' . $answer . '", submitted = '. time(). ', ip ="'. $ip .'" WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {			
			return false;
		}
	}

	function SetState($state) {
		$cg =& $this->GetCG();
		if ($state == 2) {
			$points = $cg->GetDNP();
		}
		elseif ($state == 3) {
			$points = $cg->GetNoEffort();
		}
		$sql = 'UPDATE cg_signups SET state=' . ((int) $state);
		if (isset($points)) {
			$sql .= ', points=' . $points;
		}
		$sql .= ' WHERE id=' . $this->id;
		
		if (mysql_query($sql, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	function SetRank($rank) {
		$cg =& $this->GetCG();
		$points = $cg->GetMaximum() - ($rank - 1);
		if ($this->GetState() == 4) {
			$points -= 5;
		}
		if ($points < $cg->GetMinimum()) {
			$points = $cg->GetMinimum();
		}
		
		if (mysql_query('UPDATE cg_signups SET rank=' . ((int) $rank) . ', points=' . $points . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}
	
	function dimRank($rank) {
		if (mysql_query('UPDATE cg_signups SET rank=' . ((int) $rank) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	function SetPoints($points) {
		if (mysql_query('UPDATE cg_signups SET points=' . ((int) $points) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	function DeleteSignup() {
		if (mysql_query('DELETE FROM cg_signups WHERE id=' . $this->id, $this->db)) {
			return true;
		}
		else {
			return false;
		}
	}
}
?>
