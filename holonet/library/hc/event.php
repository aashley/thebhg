<?php

class Event extends History {
	var $id;
	var $date;
	var $category;
	var $event;
	
	function Event($id,$admin_id = '') {
		History::History($admin_id);
		
		$sql = "SELECT * FROM `hc_events` WHERE id=$id";
		$query = mysql_query($sql,$this->connection);
		$info = mysql_fetch_array($query);
		
		$this->id = $info['id'];
		$this->date = $info['date'];
		$this->category = $info['category'];
		$this->event = $info['event'];
	}
	
	function Delete() {
		if ($this->admin) {
			$sql = "DELETE FROM `hc_events` WHERE id=$this->id";
			$query = mysql_query($sql,$this->connection);
			
			return ($query ? TRUE : FALSE);
		} else {
			return FALSE;
		}
	}
	
	function GetCategories() {
		$categories = explode(",",$this->category);
		
		foreach ($categories as $id) {
			$return[] = History::GetCategory($id,$this->admin_id);
		}
		
		return $return;
	}
	
	function GetEventDate() {
		return $this->date;
	}
	
	function GetEventInfo() {
		return $this->event;
	}
	
	function GetID() {
		return $this->id;
	}
	
	function SetDate($date) {
		if ($this->admin) {
			$sql = "UPDATE `hc_events` SET date='$date' WHERE id=$this->id";
			$query = mysql_query($sql,$this->connection);
			
			return ($query ? TRUE : FALSE);
		} else {
			return FALSE;
		}
	}
	
	function SetCategory($cat_id) {
		if ($this->admin) {
			$cat_array[] = $cat_id;
			$category = History::GetCategory($cat_id);
			while ($category->IsSubcategory()) {
				$category = $category->GetParent();
				$cat_array[] = $category->GetID();
			}
			$categories = implode(",",$cat_array);
			
			$sql = "UPDATE `hc_events` SET category='$categories' WHERE id=$this->id";
			$query = mysql_query($sql,$this->connection);
			
			return ($query ? TRUE : FALSE);
		} else {
			return FALSE;
		}
	}
	
	function SetEventInfo($event) {
		if ($this->admin) {
			$sql = "UPDATE `hc_events` SET event='$event' WHERE id=$this->id";
			$query = mysql_query($sql,$this->connection);
			
			return ($query ? TRUE : FALSE);
		} else {
			return FALSE;
		}
	}
	
}

?>