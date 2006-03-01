<?php

class Part extends Podracer {
	
	var $id;
	var $type;
	var $name;
	var $description;
	var $cost;
	var $limit;
	var $forsale;
	var $increase;
	var $date_deleted;
	
	function Part($id) {
		Podracer::Podracer();
		
		$sql = "SELECT * FROM `podracer_parts` WHERE `id` = '$id'";
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
	
	function getType() {
		return new PartType($this->type);
	}
	
	function Update($call, $value) {
		$sql = "UPDATE `podracer_parts` SET `$call` = '$value' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function SetType($id) {
		return $this->Update('type', $id);
	}
			
	function GetName() {
		return stripslashes($this->name);
	}
	
	function SetName($id) {
		return $this->Update('name', addslashes($id));
	}
	
	function GetSale() {
		return $this->forsale;
	}
	
	function SetSale($id) {
		return $this->Update('forsale', $id);
	}
	
	function GetDescription() {
		return nl2br(stripslashes($this->description));
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
	
	function GetLimit() {
		return $this->part_limit;
	}
	
	function SetLimit($id) {
		return $this->Update('part_limit', $id);
	}
	
	function GetIncrease($type) {
		$ar = unserialize(stripslashes($this->increase));
		if (is_array($ar)){
			return $ar[$type];
		} else {
			return 0;
		}
	}
	
	function WriteIncrease(){
		$ar = unserialize(stripslashes($this->increase));
		$return = array();
		foreach ($ar as $update=>$by){
			if ($by != 0){
				$return[] = str_replace("_", " ", ucwords($update)).' '.(($by > 0) ? '+' : '').$by;
			}
		}
		return '('.implode(', ', $return).')';
	}
	
	function WriteEffects(){
		$ar = unserialize(stripslashes($this->increase));
		$return = array();
		foreach ($ar as $update=>$by){
			if ($by > 0){
				$prd = 'Increases ';
			} elseif ($by < 0){
				$prd = 'Decreases ';
			}
			if ($by != 0){
				$return[] = $prd.str_replace("_", " ", ucwords($update)).' by '.str_replace("-", "", $by);
			}
		}
		sort($return);
		return implode('<br />', $return);
	}
	
	function SetIncrease($id) {
		return $this->Update('increase', addslashes(serialize($id)));
	}
	
	function GetDeleted() {
		return $this->date_deleted;
	}
	
	function Delete() {
		return $this->Update('date_deleted', time());
	}
}
?>