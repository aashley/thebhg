<?php

class PartType extends Podracer {
	
	var $id;
	var $name;
	var $updates;
	var $description;
	var $date_deleted;
	
	function PartType($id) {
		Podracer::Podracer();
		
		$sql = "SELECT * FROM `podracer_part_types` WHERE `id` = '$id'";
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
	
	function Update($call, $value) {
		$sql = "UPDATE `podracer_part_types` SET `$call` = '$value' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
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
	
	function SetDescription($id) {
		return $this->Update('description', addslashes($id));
	}
					
	function GetUpdates() {
		return stripslashes($this->updates);
	}
	
	function SetUpdates($id) {
		return $this->Update('updates', addslashes($id));
	}
	
	function GetDeleted() {
		return $this->date_deleted;
	}
	
	function Delete() {
		return $this->Update('date_deleted', time());
	}
}
?>