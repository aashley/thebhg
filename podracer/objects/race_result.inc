<?php

	/***************************************
	* Race_result Class
	* This class is for creating, deleting
	* and editing a single race result.
	***************************************/
	
	class Race_result
	{
		var $id;
		var $registration;
		var $place;
		var $winnings;
		
		function Race_result ($result_id)
		{
			global $db_obj;
			$select_sql = "SELECT * FROM podracer_race_results WHERE id = $result_id";
			$select_result = $db_obj->query($select_sql);
			$select_row = mysql_fetch_array ($select_result);
			$this->id = $select_row["id"];
			$this->registration = $select_row["registration"];
			$this->place = $select_row["place"];
			$this->winnings = $select_row["winnings"];
		}		
		
		function getID ()
		{
			return $this->id;
		}
				
		function getRegistration()
		{
			$reg_obj = new Race_registration ($this->registration);
			return $reg_obj;
		}
		
		function setRegistration ($registration)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_race_results set registration = $registration WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->registration = $registration;
				return 1;
			}
			else
				return 0;
		}			
		
		function getPlace()
		{
			return $this->place;
		}
		
		function setPlace ($place_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_race_results set place = $place_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->place = $place_num;
				return 1;
			}
			else
				return 0;
		}
					
		function getWinnings()
		{
			return $this->winnings;
		}
		
		function setWinnings ($winnings_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_race_results set winnings = $new WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->winnings = $winnings_num;
				return 1;
			}
			else
				return 0;
		}
				
		function delete ()
		{
			global $db_obj;
			$update_sql = "DELETE FROM podracer_race_results WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
				return 1;
			else
				return 0;
		}
	}
?>