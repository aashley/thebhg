<?php

class Race extends Podracer {

	var $id;
	var $course;
	var $name;
	var $date;
	var $reg_date;
	var $base_reward;
	var $pod_limit;
	var $skill_level;		
	var $laps;
	var $buyin;
	var $has_run;
	var $date_deleted;
	
	function Race($id) {
		Podracer::Podracer();
		
		$sql = "SELECT * FROM `podracer_races` WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		if ($result = @mysql_fetch_array($query)) {
            foreach ($result as $key => $value) {
                $this->$key = stripslashes($value);
            }
        }
	}		
	
	function Update($call, $value) {
		$sql = "UPDATE `podracer_races` SET `$call` = '$value' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function GetID() {
		return $this->id;
	}
	
	function GetName() {
		return stripslashes($this->name);
	}
	
	function SetName($id) {
		return $this->Update('name', addslashes($id));
	}
	
	function GetCourse() {
		return new Course($this->course);
	}
	
	function SetCourse($id) {
		return $this->Update('course', addslashes($id));
	}
			
	function GetDate() {
		return date('j F Y', $this->date);
	}
	
	function WriteDate() {
		return $this->date;
	}
	
	function SetDate($id) {
		return $this->Update('date', addslashes($id));
	}
	
	function GetRegDate() {
		return date('j F Y', $this->reg_date);
	}
	
	function WriteRegDate() {
		return $this->reg_date;
	}
	
	function SetRegDate($id) {
		return $this->Update('reg_date', addslashes($id));
	}		
	
	function GetBaseReward() {
		return $this->base_reward;
	}
	
	function SetBaseReward($id) {
		return $this->Update('base_reward', addslashes($id));
	}
	
	function GetPodLimit() {
		return $this->pod_limit;
	}
	
	function SetPodLimit($id) {
		return $this->Update('pod_limit', addslashes($id));
	}
					
	function GetSkillLevel() {
		return $this->skill_level;
	}
	
	function SetSkillLevel($id) {
		return $this->Update('skill_level', addslashes($id));
	}
				
	function GetLaps() {
		return $this->laps;
	}
	
	function SetLaps($id) {
		return $this->Update('laps', addslashes($id));
	}
		
	function GetCost() {
		return $this->buyin;
	}
	
	function SetCost($id) {
		return $this->Update('buyin', addslashes($id));
	}
			
	function GetHasRun() {
		return $this->has_run;
	}			
	
	function SetHasRun($id) {
		return $this->Update('has_run', addslashes($id));
	}
	
	function ListPods() {		
  		$sql = "SELECT `pod` FROM `podracer_race_registrations` WHERE `date_deleted` = 0 AND `race` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		$pods = array();
		$teams = array();
		
		while ($info = mysql_fetch_array($query)) {
			$pod = new OwnedPod($info['pod']);
			if (!$pod->GetDeleted()){
				$return[] = $pod;
			} 
		}
		
		return $return;
	}
	
	function ListRaceRegistrations($show = 0) {		
  		$sql = "SELECT `id` FROM `podracer_race_registrations` WHERE `date_deleted` = 0 ".($show ? 'AND `dropout` = 0' : '')." AND `race` = '".$this->id."'";
  		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$reg = new RaceRegistration($info['id']);
			$pod = $reg->GetPod();
			if (!$pod->GetDeleted()){
				$return[] = $reg;
			}
		}
		
		return $return;
	}
	
	function ListRaceResults() {		
  		$sql = "SELECT `id` FROM `podracer_race_registrations` WHERE `date_deleted` = 0 AND `race` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$sql = "SELECT `id` FROM `podracer_race_results` WHERE registration = '".$info['id']."'";
			$result = mysql_query($sql, $this->connect);
			while ($put = mysql_fetch_array($result)){
				$return[] = new RaceResult($put['id']);
			}
		}
		
		return $return;
	}

	function ListTeams() {		
  		$pods = $this->ListPods();
  		$return = array();
  		$output = array();
  		
  		foreach ($pods as $pod){
	  		$team = $pod->GetTeam();
	  		$return[] = $team->GetID();
  		}
  		
  		$return = array_unique($return);
  		
  		foreach ($return as $team){
	  		$output[] = new Team($team);
  		}
  		
  		return $output;
	}
	
	function TotalBets($type) {
		$sql = "SELECT SUM(`amount`) as `total` FROM `podracer_bets` WHERE `date_deleted` = 0 AND `race` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_array($query);
		
		return $info['total'];
	}
	
	function GetDeleted() {
		return $this->date_deleted;
	}
	
	function Delete() {
		return $this->Update('date_deleted', time());
	}
}
?>