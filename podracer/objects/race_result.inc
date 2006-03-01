<?php

class RaceResult extends Podracer {

	var $id;
	var $registration;
	var $place;
	var $winnings;
	var $date_deleted;
	
	function RaceResult($id) {
		Podracer::Podracer();
		
		$sql = "SELECT * FROM `podracer_race_results` WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		if ($result = @mysql_fetch_array($query)) {
            foreach ($result as $key => $value) {
                $this->$key = stripslashes($value);
            }
        }
	}		
	
	function Update($call, $value) {
		$sql = "UPDATE `podracer_race_results` SET `$call` = '$value' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function GetID() {
		return $this->id;
	}
	
	function GetRegistration() {
		return new RaceRegistration($this->registration);
	}
	
	function SetRegistration($id) {
		return $this->Update('registration', $id);
	}
			
	function GetPlace() {
		return $this->place;
	}
	
	function SetPlace($id) {
		return $this->Update('place', $id);
	}
	
	function GetPod() {
		$reg = $this->GetRegistration();
		return $reg->GetPod();
	}
	
	function SetPod($id) {
		$reg = $this->GetRegistration();
		return $reg->SetPod($id);
	}
	
	function GetRace() {
		$reg = $this->GetRegistration();
		return $reg->GetRace();
	}
	
	function SetRace($id) {
		$reg = $this->GetRegistration();
		return $reg->SetRace($id);
	}
	
	function GetWinnings() {
		return $this->winnings;
	}
	
	function SetWinnings($id) {
		return $this->Update('winnings', $id);
	}
				
	function GetDeleted() {
		return $this->date_deleted;
	}
	
	function Delete() {
		return $this->Update('date_deleted', time());
	}
}
?>