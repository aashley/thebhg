<?php

	/***************************************
	* Pod Type Class
	* This class is for creating, deleting
	* and editing a single pod type.
	***************************************/
	
	class Pod
	{
		var $id;
		var $name;
		var $description;
		var $cost;
		var $image;
		var $traction;
		var $turning;
		var $acceleration;
		var $top_speed;
		var $air_brake;
		var $cooling;
		var $repair;
		
		function Pod ($pod_id)
		{
			global $db_obj;
			$select_sql = "SELECT * FROM podracer_pod_types WHERE id = $pod_id";
			$select_result = $db_obj->query($select_sql);
			$select_row = mysql_fetch_array ($select_result);
			$this->id = $select_row["id"];
			$this->name = $select_row["name"];
			$this->description = $select_row["description"];
			$this->cost = $select_row["cost"];
			$this->image = $select_row["image"];
			$this->traction = $select_row["traction"];
			$this->turning = $select_row["turning"];
			$this->acceleration = $select_row["acceleration"];
			$this->top_speed = $select_row["top_speed"];
			$this->air_brake = $select_row["air_brake"];
			$this->cooling = $select_row["cooling"];
			$this->repair = $select_row["repair"];
		}		
		
		function getID ()
		{
			return $this->id;
		}
		
		function getName()
		{
			return $this->name;
		}
		
		function setName ($name_str)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_pod_types set name = '$name_str' WHERE id = $this->id";
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
		
		function setDescription ($desc_str)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_pod_types set description = '$desc_str' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->description = $desc_str;
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
			$update_sql = "UPDATE podracer_pod_types set cost = $cost_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->cost = $cost_num;
				return 1;
			}
			else
				return 0;
		}
			
		function getImage()
		{
			return $this->image;
		}
		
		function setImage ($image_str)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_pod_types set image = '$image_str' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->image = $image_str;
				return 1;
			}
			else
				return 0;
		}
																	
		function getTraction()
		{
			return $this->traction;
		}
		
		function setTraction ($traction_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_pod_types set traction = $traction_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->traction = $traction_num;
				return 1;
			}
			else
				return 0;
		}
														
		function getTurning()
		{
			return $this->turning;
		}
		
		function setTurning ($turning_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_pod_types set turning = $turning_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->turning = $turning_num;
				return 1;
			}
			else
				return 0;
		}		
																
		function getAcceleration()
		{
			return $this->acceleration;
		}
		
		function setAcceleration ($accel_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_pod_types set acceleration = $accel_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->acceleration = $accel_num;
				return 1;
			}
			else
				return 0;
		}
																		
		function getTop_speed()
		{
			return $this->top_speed;
		}
		
		function setTop_speed ($top_speed_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_pod_types set top_speed = $top_speed_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->top_speed = $top_speed_num;
				return 1;
			}
			else
				return 0;
		}
																				
		function getAir_brake()
		{
			return $this->air_brake;
		}
		
		function setAir_brake ($air_brake_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_pod_types set air_brake = $air_brake_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->air_brake = $air_brake_num;
				return 1;
			}
			else
				return 0;
		}
																						
		function getCooling()
		{
			return $this->cooling;
		}
		
		function setCooling ($cooling_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_pod_types set cooling = $cooling_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->cooling = $cooling_num;
				return 1;
			}
			else
				return 0;
		}
																								
		function getRepair()
		{
			return $this->repair;
		}
		
		function setRepair ($repair_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_pod_types set repair = $repair_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->repair = $repair_num;
				return 1;
			}
			else
				return 0;
		}
			
		function delete ()
		{
			global $db_obj;
			$update_sql = "DELETE FROM podracer_pod_types WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
				return 1;
			else
				return 0;
		}
	}
?>