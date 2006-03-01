<?php

class Bet extends Podracer {
	
	var $id;
	var $bhg_id;
	var $pod;
	var $race;
	var $voucher;
	var $amount;
	var $date_deleted;
	
	function Bet($id) {
		Podracer::Podracer();
	
		$sql = "SELECT * FROM `podracer_bets` WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		if ($result = @mysql_fetch_array($query)) {
            foreach ($result as $key => $value) {
                $this->$key = stripslashes($value);
            }
        }
	}		
	
	function GetID() {
		return $this->id;
	}
	
	function GetBHGID() {
		return new Person($this->bhg_id);
	}

	function Update($call, $value) {
		$sql = "UPDATE `podracer_bets` SET `$call` = '$value' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function SetBHGID($id) {
		return $this->Update('bhg_id', $id);
	}
	
	function GetPod() {
		return new OwnedPod($this->pod);
	}
	
	function SetPod($id) {
		return $this->Update('pod', $id);
	}
					
	function GetRace() {
		return new Race($this->race);
	}
	
	function SetRace($id) {
		return $this->Update('race', $id);
	}
	
	function GetAmount() {
		return $this->amount;
	}
	
	function SetAmount($id) {
		return $this->Update('amount', $id);
	}
	
	function GetVoucher() {
		return $this->voucher;
	}
	
	function SetVoucher($id) {
		return $this->Update('voucher', $id);
	}
	
	function GetTeam() {
		$pod = $this->GetPod();
		return $this->GetTeam();
	}
	
	function GetDeleted() {
		return $this->date_deleted;
	}
	
	function Delete() {
		return $this->Update('date_deleted', time());
	}
}
?>