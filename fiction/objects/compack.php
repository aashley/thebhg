<?php

class CompPack extends Fiction {

	var $id;
	var $name;
	var $description;
	var $date_deleted;
	var $table;
	
	function CompPack($id){
		Fiction::Fiction();
		
		$this->table = 'competition_packages';
		
		$sql = "SELECT * FROM `".$this->table."` WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		while ($info = mysql_fetch_assoc($query)){
			foreach ($info as $name=>$value){
				$this->$name = stripslashes($value);
			}
		}
	}
	
	function GetID(){
		return $this->id;
	}
	
	function GetName(){
		return $this->name;
	}
	
	function GetDescription($format = true){
		return ($format ? nl2br($this->description) : $this->description);
	}
	
	function DateDeleted(){
		return $this->date_deleted;
	}
	
	function del($del){
		if (!($del === 0)){
			$del = time();
		}
		$sql = "UPDATE `".$this->table."` SET `date_deleted` = '".$del."' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		return ($query ? true : false);
	}
	
	function Edit($name, $description){		
		$sql = "UPDATE `".$this->table."` SET `name` = '".addslashes($name)."', `description` = '"
		.addslashes($description)."' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function AddToPack($guide, $pts){
		$sql = "INSERT INTO `package_contents` (`package`, `guide`, `points`) VALUES ('".$this->id."', '$guide', '$pts')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function RemoveFromPack($id){
		$sql = "UPDATE `package_contents` SET `date_deleted` = '".time()."' WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function UpdatePackPoints($id, $points){
		$sql = "UPDATE `package_contents` SET `points` = '$points' WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function PackContents(){
		$sql = "SELECT * FROM `package_contents` WHERE `package` = '".$this->id."' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_assoc($query)){
			$return[$info['id']] = 
				array('guide'=>$this->GetGuide($info['guide']), 'points'=>$info['points']);
		}
		
		return $return;
	}
	
	function PackPoints(){
		$points = 0;
		foreach ($this->PackContents() as $pack){
			$points += $pack['points'];
		}
		return $points;
	}
}

?>