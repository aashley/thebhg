<?php

	/***************************************
	* Owned Part Class
	* This class is for creating, deleting
	* and editing a single circuit.
	***************************************/
	
	class Owned_Part
	{
		var $id;
		var $part;
		var $pod;
		
		function Owned_Part ($part_id)
		{
			global $db_obj;
			$select_sql = "SELECT * FROM podracer_owned_parts WHERE id = $part_id";
			$select_result = $db_obj->query($select_sql);
			$select_row = mysql_fetch_array ($select_result);
			$this->id = $select_row["id"];
			$this->part = $select_row["part"];
			$this->pod = $select_row["pod"];
		}		
		
		function getID ()
		{
			return $this->id;
		}
				
		function getPart()
		{
			$part_obj = new Part ($this->part);
			return $part_obj;
		}
		
		function setPart ($part_id)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_parts set part = $part_id WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->part = $part_id;
				return 1;
			}
			else
				return 0;
		}
						
		function getPod()
		{
			$pod_obj = new Owned_pod ($this->pod);
			return $pod_obj;
		}
		
		function setPod ($pod_id)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_parts set pod = $pod_id WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->pod = $pod_id;
				return 1;
			}
			else
				return 0;
		}
			
		function delete ()
		{
			global $db_obj;
			$update_sql = "DELETE FROM podracer_owned_parts WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
				return 1;
			else
				return 0;
		}
	}
?>