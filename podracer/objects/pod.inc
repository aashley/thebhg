<?php

class Pod extends Podracer {
	
	var $id;
	var $name;
	var $description;
	var $cost;
	var $image;
	var $cat;
	var $forsale;
	var $num;
	var $traction;
	var $turning;
	var $acceleration;
	var $top_speed;
	var $air_brake;
	var $cooling;
	var $repair;
	var $date_deleted;
	
	function Pod($id){
		Podracer::Podracer();
		
		$sql = "SELECT * FROM `podracer_pod_types` WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		if ($result = @mysql_fetch_array($query)) {
            foreach ($result as $key => $value) {
                $this->$key = stripslashes($value);
            }
        }
	}		
	
	function Update($call, $value) {
		$sql = "UPDATE `podracer_pod_types` SET `$call` = '$value' WHERE `id` = '".$this->id."'";
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
	
	function GetCost() {
		return $this->cost;
	}
	
	function SetCost($id) {
		return $this->Update('cost', $id);
	}
	
	function GetNum() {
		return $this->num;
	}
	
	function SetNum($id) {
		return $this->Update('num', $id);
	}
	
	function GetSale() {
		return $this->forsale;
	}
	
	function SetSale($id) {
		return $this->Update('forsale', $id);
	}
	
	function GetCat() {
		return $this->cat;
	}
	
	function SetCat($id) {
		return $this->Update('cat', $id);
	}
	
	function GetImage() {
		return $this->image;
	}
	
	function SetImage($id) {
		return $this->Update('image', $id);
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
																							
	function GetDeleted() {
		return $this->date_deleted;
	}
	
	function Delete() {
		return $this->Update('date_deleted', time());
	}
}
?>