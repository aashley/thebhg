<?php

class History {
	var $database;
	var $connection;
	var $admin_id;
	var $admin;
	
	function History($admin_id = '') {
		$this->database = 'thebhg_holonet';
		$this->connection = mysql_connect("localhost", "thebhg_holonet", "w0rdy");
		mysql_select_db($this->database,$this->connection);
		
		$this->admin_id = $admin_id;
		$this->admin = ($admin_id === "BHGhist85" ? TRUE : FALSE);
	}
	
	function CreateCategory($name,$parent) {
		if ($this->admin) {
			$sql = "INSERT INTO `hc_categories` (name,parent) VALUES ('$name','$parent')";
			$query = mysql_query($sql,$this->connection);
			
			return ($query ? TRUE : FALSE);
		} else {
			return FALSE;
		}
	}
	
	function CreateEvent($date,$cat_id,$event) {
		if ($this->admin) {
			$cat_array[] = $cat_id;
			$category = $this->GetCategory($cat_id);
			while ($category->IsSubcategory()) {
				$category = $category->GetParent();
				$cat_array[] = $category->GetID();
			}
			$categories = implode(",",$cat_array);
			
			$sql = "INSERT INTO `hc_events` (date,category,event) VALUES ('$date','$categories','$event')";
			$query = mysql_query($sql,$this->connection);
			
			return ($query ? TRUE : FALSE);
		} else {
			return FALSE;
		}
	}
	
	function GetCategory($id) {
		return new Category($id,$this->admin_id);
	}
	
	function GetCategories($parent = 1) {
		$where = ($parent ? "WHERE parent=0" : "");
		$sql = "SELECT * FROM `hc_categories` {$where} ORDER BY name ASC";
		$query = mysql_query($sql,$this->connection);
		
		while ($array = mysql_fetch_array($query)) {
			$return[] = new Category($array['id'],$this->admin_id);
		}
		
		return $return;
	}
	
	function GetEvent($id) {
		return new Event($id,$this->admin_id);
	}
	
	function GetEvents($cat_id = '') {
		$sql = "SELECT * FROM `hc_events` ORDER BY date ASC";
		$query = mysql_query($sql,$this->connection);
		
		while ($array = mysql_fetch_array($query)) {
			$events[] = new Event($array['id'],$this->admin_id);
		}
		
		if ($cat_id) {
			foreach ($events as $event) {
				$id_array = explode(",",$event->category);
				if (in_array($cat_id,$id_array)) {
					$return[] = $event;
				}
			}
			
			return $return;
		} else {
			return $events;
		}
	}
}

?>