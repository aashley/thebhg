<?php

	/***************************************
	* Part Class
	* This class is for creating, deleting
	* and editing a single part.
	***************************************/
	
	class Part
	{
		var $id;
		var $type;
		var $name;
		var $description;
		var $cost;
		var $limit;
		var $increase;
		
		function Part ($part_id)
		{
			global $db_obj;
			$select_sql = "SELECT * FROM podracer_parts WHERE id = $part_id";
			$select_result = $db_obj->query($select_sql);
			$select_row = mysql_fetch_array ($select_result);
			$this->id = $select_row["id"];
			$this->type = $select_row["type"];
			$this->name = $select_row["name"];
			$this->description = $select_row["description"];
			$this->cost = $select_row["cost"];
			$this->limit = $select_row["part_limit"];
			$this->increase = $select_row["increase"];
		}		
		
		function getID ()
		{
			return $this->id;
		}
		
		function getType()
		{
			return $this->type;
		}
		
		function setType ($type_str)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_parts set type = '$type_str' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->type = $type_str;
				return 1;
			}
			else
				return 0;
		}
				
		function getName()
		{
			return $this->name;
		}
		
		function setName ($name_str)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_parts set name = '$name_str' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->name = $name_str;
				return 1;
			}
			else
				return 0;
		}
		
		function getDescription()
		{
			return $this->description;
		}
		
		function setDescription ($description_str)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_parts set description = '$description_str' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->description = $description_str;
				return 1;
			}
			else
				return 0;
		}
						
		function getCost()
		{
			return $this->cost;
		}
		
		function setCost ($cost_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_parts set cost = $cost_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->cost = $cost_num;
				return 1;
			}
			else
				return 0;
		}
						
		function getLimit()
		{
			return $this->limit;
		}
		
		function setLimit ($limit_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_parts set part_limit = $limit_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->limit = $limit_num;
				return 1;
			}
			else
				return 0;
		}
						
		function getIncrease()
		{
			return $this->increase;
		}
		
		function setIncrease ($increase_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_parts set increase = $increase_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->increase = $increase_num;
				return 1;
			}
			else
				return 0;
		}		
	
		function delete ()
		{
			global $db_obj;
			$update_sql = "DELETE FROM podracer_parts WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
				return 1;
			else
				return 0;
		}
	}
?>