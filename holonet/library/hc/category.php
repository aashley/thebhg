<?php

class Category extends History {
	var $id;
	var $name;
	var $parent;
	
	function Category($id,$admin_id = '') {
		History::History($admin_id);
		
		$sql = "SELECT * FROM `hc_categories` WHERE id=$id";
		$query = mysql_query($sql,$this->connection);
		$info = mysql_fetch_array($query);
		
		$this->id = $info['id'];
		$this->name = $info['name'];
		$this->parent = $info['parent'];
	}
	
	function Delete() {
		if ($this->admin) {
			$sql = "DELETE FROM `hc_categories` WHERE id=$this->id";
			$query = mysql_query($sql,$this->connection);
			
			return ($query ? TRUE : FALSE);
		} else {
			return FALSE;
		}
	}
	
	function IsParent() {
		$sql = "SELECT * FROM `hc_categories` WHERE parent=$this->id ORDER BY name ASC";
		$query = mysql_query($sql,$this->connection);
		$check = mysql_fetch_array($query);
		
		return ($check ? TRUE : FALSE);
	}
	
	function IsSubcategory() {
		return ($this->parent ? TRUE : FALSE);
	}
	
	function GetEvents() {
		return History::GetEvents($this->id);
	}
	
	function GetID() {
		return $this->id;
	}
	
	function GetName() {
		return $this->name;
	}
	
	function GetParent() {
		return History::GetCategory($this->parent);
	}
	
	function GetSubcategories() {
		$sql = "SELECT * FROM `hc_categories` WHERE parent=$this->id ORDER BY name ASC";
		$query = mysql_query($sql,$this->connection);
		
		while ($array = mysql_fetch_array($query)) {
			$return[] = new Category($array['id'],$this->admin_id);
		}
		
		return $return;
	}
	
	function SetName($name) {
		if ($this->admin) {
			$sql = "UPDATE `hc_categories` SET name='$name' WHERE id=$this->id";
			$query = mysql_query($sql,$this->connection);
			
			return ($query ? TRUE : FALSE);
		} else {
			return FALSE;
		}
	}
	
	function SetParent($parent) {
		if ($this->admin) {
			$sql = "UPDATE `hc_categories` SET parent='$parent' WHERE id=$this->id";
			$query = mysql_query($sql,$this->connection);
			
			return ($query ? TRUE : FALSE);
		} else {
			return FALSE;
		}
	}
	
}

?>