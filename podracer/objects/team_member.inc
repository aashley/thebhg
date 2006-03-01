<?php

class TeamMember extends Podracer {

	var $id;
	var $bhg_id;
	var $team;
	var $donations;
	var $recieved;
	var $date_deleted;
	
	function TeamMember($id) {
		Podracer::Podracer();
		
		$sql = "SELECT * FROM `podracer_team_members` WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		if ($result = @mysql_fetch_array($query)) {
            foreach ($result as $key => $value) {
                $this->$key = stripslashes($value);
            }
        }
	}		
	
	function Update($call, $value) {
		$sql = "UPDATE `podracer_team_members` SET `$call` = '$value' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function GetID() {
		return $this->id;
	}
	
	function GetBHGID() {
		return new Person($this->bhg_id);
	}
	
	function SetBHGID($id) {
		return $this->Update('bhg_id', $id);
	}
			
	function GetTeam() {
		return new Team($this->team);
	}
	
	function SetTeam($id) {
		return $this->Update('team', $id);
	}
	
	function GetDonations() {
		return $this->donations;
	}
	
	function GetContrib(){
		$team = $this->GetTeam();
		$total = $team->GetCredits();
		if ($team->GetCredits()){
			return 100*round(($this->donations / $team->GetValue()), 2).'%';
		} 
		
		return '0%';
	}
	
	function AddDonations($id) {
		$creds = $this->GetDonations()+$id;
		return $this->Update('donations', $creds);
	}
							
	function GetRecieved() {
		return $this->recieved;
	}
	
	function GetReturn(){
		if ($this->recieved){
			return 100*round(($this->recieved / $this->donations), 5).'%';
		}
		
		return '0%';
	}
	
	function AddRecieved($id) {
		$creds = $this->GetRecieved()+$id;
		return $this->Update('recieved', $creds);
	}
								
	function IsLeader() {
		$sql = "SELECT * FROM `podracer_teams` WHERE `leader` = '".$this->bhg_id."' AND `id` = '".$this->team."' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		
		return mysql_num_rows($query);
	}
	
	function GetDeleted() {
		return $this->date_deleted;
	}
	
	function Delete() {
		return $this->Update('date_deleted', time());
	}
}
?>