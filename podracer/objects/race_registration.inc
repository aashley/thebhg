<?php

	/***************************************
	* Race Registration Class
	* This class is for creating, deleting
	* and editing a single race registration.
	***************************************/
	
	class Race_registration
	{
		var $id;
		var $race;
		var $pod;
		var $dropout;
		var $total_points;
		var $comments;
		
		function Race_registration ($race_id)
		{
			global $db_obj;
			$select_sql = "SELECT * FROM podracer_race_registrations WHERE id = $race_id";
			$select_result = $db_obj->query($select_sql);
			$select_row = mysql_fetch_array ($select_result);
			$this->id = $select_row["id"];
			$this->race = $select_row["race"];
			$this->pod = $select_row["pod"];
			$this->dropout = $select_row["dropout"];
			$this->total_points = $select_row["total_points"];
			$this->comments = unserialize(stripslashes($select_row["comments"]));
		}		
		
		function getID ()
		{
			return $this->id;
		}
				
		function getRace()
		{
			$race_obj = new Race ($this->race);
			return $race_obj;
		}
		
		function setRace ($race_id)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_race_registrations set race = $race_id WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->race = $race_id;
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
			$update_sql = "UPDATE podracer_race_registrations set pod = $pod_id WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->pod = $pod_id;
				return 1;
			}
			else
				return 0;
		}	
		
		function getTeam()
		{
			$pod_obj = $this->getPod();
			$team_obj = $pod_obj->getTeam();
			return $team_obj;
		}	
		
		function getDropout()
		{
			return $this->dropout;
		}
		
		function setDropout ($dropout)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_race_registrations set dropout = $dropout WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->dropout = $dropout;
				return 1;
			}
			else
				return 0;
		}
		
		function getTotal_points()
		{
			return $this->total_points;
		}
		
		function addTotal_points ($total_points)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_race_registrations set total_points = total_points + $total_points WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->total_points += $total_points;
				return 1;
			}
			else
				return 0;
		}
		
		function removeTotal_points ($total_points)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_race_registrations set total_points = total_points - $total_points WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->total_points -= $total_points;
				return 1;
			}
			else
				return 0;
		}
		
		function setTotal_points ($total_points)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_race_registrations set total_points = $total_points WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->total_points = $total_points;
				return 1;
			}
			else
				return 0;
		}
		
		function getComments()
		{
			return $this->comments;
		}
		
		function addComments ($comment)
		{
			global $db_obj;      
      if (strlen($this->comments [0]) <= 0)
        $index = 0;
      else
        $index = sizeof($this->comments);
      $this->comments [$index] = $comment;
			$update_sql = "UPDATE podracer_race_registrations set comments = '".addslashes(serialize($this->comments))."' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
				return 1;
			else
				return 0;
		}
		
		function getHouse_odds ()
		{
			$race_obj = $this->getRace();
			$pod_obj = $this->getPod();
			$difference = 1 + ($race_obj->getSkill_level() / $pod_obj->getASL());
			$difference = (int)(pow (4, $difference) / 2);
			return $difference;
		}
						
		function delete ()
		{
			global $db_obj;
			$update_sql = "DELETE FROM podracer_race_registrations WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
				return 1;
			else
				return 0;
		}
	}
?>