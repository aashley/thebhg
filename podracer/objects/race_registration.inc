<?php

class RaceRegistration extends Podracer {

	var $id;
	var $race;
	var $pod;
	var $dropout;
	var $total_points;
	var $comments;
	var $date_deleted;
	
	function RaceRegistration($id) {
		Podracer::Podracer();
		
		$sql = "SELECT * FROM `podracer_race_registrations` WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		if ($result = @mysql_fetch_array($query)) {
            foreach ($result as $key => $value) {
                $this->$key = stripslashes($value);
            }
        }
	}		
	
	function Update($call, $value) {
		$sql = "UPDATE `podracer_race_registrations` SET `$call` = '$value' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function UpdateCache(){
		$sql = "SELECT * FROM `podracer_race_registrations` WHERE `id` = '".$this->id."'";
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
	
	function GetRace() {
		return new Race($this->race);
	}
	
	function SetRace($id) {
		return $this->Update('race', $id);
	}
	
	function GetPod() {
		return new OwnedPod($this->pod);
	}
	
	function SetPod($id) {
		return $this->Update('pod', $id);
	}
			
	function GetTeam() {
		$pod = $this->GetPod();
		return $pod->GetTeam();
	}
	
	function GetDropout() {
		$this->updatecache();
		return $this->dropout;
	}
	
	function SetDropout($id) {
		$this->updatecache();
		return $this->Update('dropout', $id);
	}
	
	function GetTotalPoints() {
		return $this->total_points;
	}
	
	function AddTotalPoints($id) {
		$this->updatecache();
		$points = $this->GetTotalPoints();
		$points += $id;
		return $this->Update('total_points', $points);
	}
	
	function RemoveTotalPoints($id) {
		$this->updatecache();
		$points = $this->GetTotalPoints()-$id;
		return $this->Update('total_points', $points);
	}
	
	function SetTotalPoints($id) {
		$this->updatecache();
		return $this->Update('total_points', $id);
	}
	
	function GetComments() {
		return unserialize(stripslashes($this->comments));
	}
	
	function AddComment($id) {
		$sql = "SELECT `comments` FROM `podracer_race_registrations` WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_array($query);
		$comments = unserialize(stripslashes($info['comments']));
		$comments[] = addslashes($id);
		$sql = "UPDATE `podracer_race_registrations` SET `comments` = '".addslashes(serialize($comments))."' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		return $run;
	}
	
	function WriteRace($id){
		return $this->Update('comments', addslashes(serialize($id)));
	}
	
	function CleanComment() {
		$run = $this->Update('comments', addslashes(serialize(array())));
		return $run;
	}
	
	function GetHouseOdds($disp = 0) {
		$race = $this->GetRace();
		$pod = $this->GetPod();
		$course = $race->GetCourse();
		if ($course->GetASL() <= 0){
			$crs = (1/$race->GetLaps());
		} else {
			$crs = $course->GetASL();
		}
		$avg = ($crs * $race->GetLaps());
		$go = abs($pod->GetASL() - $race->GetSkillLevel());
		if ($go == 0){
			$go = 1;
		}
		$val = $avg/$go;
		if ($val < 1){
			$val += 1;
		}
		
		return round($val, 2);
	}
					
	function GetDeleted() {
		return $this->date_deleted;
	}
	
	function Delete() {
		return $this->Update('date_deleted', time());
	}
}
?>