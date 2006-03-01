<?php

class CompGuide extends Fiction {

	var $id;
	var $name;
	var $description;
	var $date_deleted;
	var $table;
	
	function CompGuide($id){
		Fiction::Fiction();
		
		$this->table = 'competition_guide';
		
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
}

?>