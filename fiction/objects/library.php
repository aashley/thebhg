<?php

class Library extends Fiction {

	var $id;
	var $name;
	var $key;
	var $description;
	var $full_access;
	var $date_deleted;
	var $table;
	
	function Library($id){
		Fiction::Fiction();
		
		$this->table = 'libraries';
		
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
	
	function GetKey(){
		return $this->key;
	}
	
	function GetDescription($format = true){
		return ($format ? nl2br($this->description) : $this->description);
	}
	
	function DateDeleted(){
		return $this->date_deleted;
	}
	
	function FullAccess(){
		return ($this->full_access == 1);
	}
	
	function del($del){
		if (!($del === 0)){
			$del = time();
		}
		$sql = "UPDATE `".$this->table."` SET `date_deleted` = '".$del."' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		return ($query ? true : false);
	}
	
	function Edit($name, $description, $full){		
		$sql = "UPDATE `".$this->table."` SET `name` = '".addslashes($name)."', `description` = '"
		.addslashes($description)."', `full_access` = '$full' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function SetKey($key){		
		$sql = "UPDATE `".$this->table."` SET `key` = '".addslashes(strtoupper(md5($key)))."' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function SetPack($id){
		$sql = "INSERT INTO `library_packs` (`library`, `package`) VALUES ('".$this->id."', '$id')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}	
}

?>