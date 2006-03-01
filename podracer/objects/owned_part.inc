<?php

class OwnedPart extends Podracer {

	var $id;
	var $part;
	var $pod;
	var $date_delted;
	
	function OwnedPart($id) {
		Podracer::Podracer();
		
		$sql = "SELECT * FROM `podracer_owned_parts` WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		if ($result = @mysql_fetch_array($query)) {
            foreach ($result as $key => $value) {
                $this->$key = stripslashes($value);
            }
        }
	}		
	
	function Update($call, $value) {
		$sql = "UPDATE `podracer_owned_parts` SET `$call` = '$value' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function GetID() {
		return $this->id;
	}
	
	function GetPart() {
		return new Part($this->part);
	}
	
	function SetPart($id) {
		return $this->Update('part', $id);
	}
			
	function GetPod() {
		return new OwnedPod($this->pod);
	}
	
	function SetPod($id) {
		return $this->Update('pod', $id);
	}
		
	function GetDeleted() {
		return $this->date_deleted;
	}
	
	function Delete() {
		return $this->Update('date_deleted', time());
	}
}
?>