<?php

	/***************************************
	* Course Class
	* This class is for creating, deleting
	* and editing a single course.
	***************************************/
	
	class Course
	{
		var $id;
		var $name;
		var $description;
		var $traction;
		var $turning;
		var $acceleration;
		var $top_speed;
		var $air_brake;
		var $cooling;
		var $repair;
    var $random_damage;
		
		function Course ($course_id)
		{
			global $db_obj;
			$select_sql = "SELECT * FROM podracer_courses WHERE id = $course_id";
			$select_result = $db_obj->query($select_sql);
			$select_row = mysql_fetch_array ($select_result);
			$this->id = $select_row["id"];
			$this->name = $select_row["name"];
			$this->description = $select_row["description"];
			$this->traction = $select_row["traction"];
			$this->turning = $select_row["turning"];
			$this->acceleration = $select_row["acceleration"];
			$this->top_speed = $select_row["top_speed"];
			$this->air_brake = $select_row["air_brake"];
			$this->cooling = $select_row["cooling"];
			$this->repair = $select_row["repair"];
			$this->random_damage = unserialize(stripslashes($select_row["random_damage"]));
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
			$update_sql = "UPDATE podracer_courses set name = '$name_str' WHERE id = $this->id";
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
			$update_sql = "UPDATE podracer_courses set description = '$description_str' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->description = $description_str;
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
			$update_sql = "UPDATE podracer_courses set traction = $traction_num WHERE id = $this->id";
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
			$update_sql = "UPDATE podracer_courses set turning = $turning_num WHERE id = $this->id";
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
		
		function setAcceleration ($acceleration_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_courses set acceleration = $acceleration_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->acceleration = $acceleration_num;
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
			$update_sql = "UPDATE podracer_courses set top_speed = $top_speed_num WHERE id = $this->id";
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
			$update_sql = "UPDATE podracer_courses set air_brake = $air_brake_num WHERE id = $this->id";
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
			$update_sql = "UPDATE podracer_courses set cooling = $cooling_num WHERE id = $this->id";
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
			$update_sql = "UPDATE podracer_courses set repair = $repair_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->repair = $repair_num;
				return 1;
			}
			else
				return 0;
		}
    
		function getRandom_damage()
		{
			return $this->random_damage;
		}
		
		function addRandom_damage ($damage)
		{
			global $db_obj;
      if (strlen($this->random_damage [0]) <= 0)
        $index = 0;
      else
        $index = sizeof($this->random_damage);
      $this->random_damage [$index] = $damage;
			$update_sql = "UPDATE podracer_courses set random_damage = '".addslashes(serialize($this->random_damage))."' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
				return 1;
			else
				return 0;
		}
    
		function removeRandom_damage ($damage)
		{
			global $db_obj;
      $this->random_damage = array_splice ($this->random_damage, ($damage+1), 1);
			$update_sql = "UPDATE podracer_courses set random_damage = '".addslashes(serialize($this->random_damage))."' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
				return 1;
			else
				return 0;
		}
		
		function delete ()
		{
			global $db_obj;
			$update_sql = "DELETE FROM podracer_courses WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
				return 1;
			else
				return 0;
		}
	}
?>