<?php

class Course extends Podracer {
	
	var $id;
	var $name;
	var $description;
	var $traction;
	var $turning;
	var $acceleration;
	var $top_speed;
	var $air_brake;
	var $cooling;
	var $repair;
	var $random_damage;
	var $date_deleted;
	
	function Course($id) {
		Podracer::Podracer();
		
		$sql = "SELECT * FROM `podracer_courses` WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		if ($result = @mysql_fetch_array($query)) {
            foreach ($result as $key => $value) {
                $this->$key = stripslashes($value);
            }
        }
	}		
	
	function Update($call, $value) {
		$sql = "UPDATE `podracer_courses` SET `$call` = '$value' WHERE `id` = '".$this->id."'";
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
	
	function GetDescription() {
		return nl2br(stripslashes($this->description));
	}
	
	function WriteDescription() {
		return stripslashes($this->description);
	}
	
	function SetDescription($id) {
		return $this->Update('description', addslashes($id));
	}
	
	function GetTraction() {
		return $this->traction;
	}
	
	function SetTraction($id) {
		return $this->Update('traction', $id);
	}
	
	function GetTurning() {
		return $this->turning;
	}
	
	function SetTurning($id) {
		return $this->Update('turning', $id);
	}
	
	function GetAcceleration() {
		return $this->acceleration;
	}
	
	function SetAcceleration($id) {
		return $this->Update('acceleration', $id);
	}		
	
	function GetTopSpeed() {
		return $this->top_speed;
	}
	
	function SetTopSpeed($id) {
		return $this->Update('top_speed', $id);
	}
	
	function GetAirBrake() {
		return $this->air_brake;
	}
	
	function SetAirBrake($id) {
		return $this->Update('air_brake', $id);
	}
	
	function GetCooling() {
		return $this->cooling;
	}
	
	function SetCooling($id) {
		return $this->Update('cooling', $id);
	}
	
	function GetRepair() {
		return $this->repair;
	}
	
	function SetRepair($id) {
		return $this->Update('repair', $id);
	}
	
	function GetRandomDamage() {
		return unserialize(stripslashes($this->random_damage));
	}
	
	function GetASL() {
		$total = 0;
		$total += abs($this->GetTraction());
		$total += abs($this->GetTurning());
		$total += abs($this->GetAcceleration());
		$total += abs($this->GetTopSpeed());
		$total += abs($this->GetAirBrake());
		$total += abs($this->GetCooling());
		$total += abs($this->GetRepair());
		return $total;
	}
	
	function AddRandomDamage($id) {
		$rand = $this->GetRandomDamage();
    	$rand[] = $id;
		return $this->Update('random_damage', addslashes(serialize($rand)));
	}

	function RemoveRandomDamage($id) {
		$rand = $this->GetRandomDamage();
		$go = array_splice ($rand, ($id+1), 1);
		return $this->Update('random_damage', addslashes(serialize($go)));
	}

	function GetDeleted() {
		return $this->date_deleted;
	}
	
	function Delete() {
		return $this->Update('date_deleted', time());
	}
}
?>