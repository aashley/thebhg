<?php

	/***************************************
	* Race Class
	* This class is for creating, deleting
	* and editing a single circuit.
	***************************************/
	
	class Race
	{
		var $id;
		var $course;
		var $name;
		var $date;
		var $reg_date;
		var $base_reward;
		var $pod_limit;
		var $skill_level;		
		var $laps;
		var $buyin;
		var $has_run;
		
		function Race ($race_id)
		{
			global $db_obj;
			$select_sql = "SELECT * FROM podracer_races WHERE id = $race_id";
			$select_result = $db_obj->query($select_sql);
			$select_row = mysql_fetch_array ($select_result);
			$this->id = $select_row["id"];
			$this->course = $select_row["course"];
			$this->name = $select_row["name"];
			$this->date = $select_row["date"];
			$this->reg_date = $select_row["reg_date"];
			$this->base_reward = $select_row["base_reward"];
			$this->pod_limit = $select_row["pod_limit"];
			$this->skill_level = $select_row["skill_level"];
			$this->laps = $select_row["laps"];
			$this->buyin = $select_row["buyin"];
			$this->has_run = $select_row["has_run"];
		}		
		
		function getID ()
		{
			return $this->id;
		}
				
		function getCourse()
		{
			$course_obj = new Course ($this->course);
			return $course_obj;
		}
		
		function setCourse ($course_id)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_races set course = $course_id WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->course = $course_id;
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
			$update_sql = "UPDATE podracer_races set name = '$name_str' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->name = $name_str;
				return 1;
			}
			else
				return 0;
		}
						
		function getDate()
		{
			return $this->date;
		}
		
		function setDate ($date_str)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_races set date = '$date_str' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->date = $date_str;
				return 1;
			}
			else
				return 0;
		}
			
		function getReg_date()
		{
			return $this->reg_date;
		}
		
		function setReg_date ($date_str)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_races set reg_date = '$date_str' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->reg_date = $date_str;
				return 1;
			}
			else
				return 0;
		}
						
		function getBase_reward()
		{
			return $this->base_reward;
		}
		
		function setBase_reward ($base_reward_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_races set base_reward = $base_reward_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->base_reward = $base_reward_num;
				return 1;
			}
			else
				return 0;
		}
						
		function getPod_limit()
		{
			return $this->pod_limit;
		}
		
		function setPod_limit ($pod_limit_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_races set pod_limit = $pod_limit_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->pod_limit = $pod_limit_num;
				return 1;
			}
			else
				return 0;
		}
					
		function getSkill_level()
		{
			return $this->skill_level;
		}
		
		function setSkill_level ($skill_level_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_races set skill_level = $skill_level_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->skill_level = $skill_level_num;
				return 1;
			}
			else
				return 0;
		}
						
		function getLaps()
		{
			return $this->laps;
		}
		
		function setLaps ($laps_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_races set laps = $laps_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->laps = $laps_num;
				return 1;
			}
			else
				return 0;
		}
						
		function getCost()
		{
			return $this->buyin;
		}
		
		function setCost ($cost_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_races set buyin = $cost_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->buyin = $cost_num;
				return 1;
			}
			else
				return 0;
		}
			
		function getHas_run()
		{
			return $this->has_run;
		}
		
		function setHas_run ($has_run)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_races set has_run = $has_run WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->has_run = $has_run;
				return 1;
			}
			else
				return 0;
		}
				
		function listPods ()
		{
			global $db_obj;
      $pods_array = array ();
			$pods_result = $db_obj->query ("SELECT pod FROM podracer_race_registrations WHERE race = $this->id ORDER BY pod ASC");
			for ($i = 0; $pods_row = mysql_fetch_array ($pods_result); $i++)
			{
				$pod_obj = new Owned_pod ($pods_row["pod"]);
				$team_obj = $pod_obj->getTeam();
				$pods_id_array [$i] = $pod_obj->getID();
				$pods_team_array [$i] = $team_obj->getName();
				unset ($team_obj);
				unset ($pod_obj);
			}
			for ($i = sizeof($pods_team_array); $i >= 1; $i--) { 
				for ($j = 1; $j <= $i; $j++) { 	
					if ($pods_team_array[$j-1] > $pods_team_array[$j]) { 
						$t = $pods_team_array[$j-1]; 
						$t2 = $pods_id_array[$j-1]; 
						$pods_team_array[$j-1] = $pods_team_array[$j]; 
						$pods_id_array[$j-1] = $pods_id_array[$j]; 
						$pods_team_array[$j] = $t; 
						$pods_id_array[$j] = $t2; 
					}
				}
			}			
			for ($i = 1; $i < sizeof ($pods_id_array); $i++)
				$pods_array [$i-1] = new Owned_pod ($pods_id_array [$i]);
			return $pods_array;
		}
				
		function listRace_registrations ($show_dropouts)
		{
			global $db_obj;
      $race_array = array ();
			if ($show_dropouts == 1)
				$race_result = $db_obj->query ("SELECT id FROM podracer_race_registrations WHERE race = $this->id ORDER BY total_points DESC");
			else
				$race_result = $db_obj->query ("SELECT id FROM podracer_race_registrations WHERE dropout = 0 AND race = $this->id ORDER BY total_points DESC");
			for ($i = 0; $race_row = mysql_fetch_array ($race_result); $i++)
				$race_array [$i] = new Race_registration ($race_row["id"]);
			return $race_array;
		}

				
		function listTeams ()
		{
			$pods_array = $this->listPods();
			$counter = 0;
			for ($i = 0; $i < sizeof ($pods_array); $i++)
			{
				$pod_obj = $pods_array [$i];
				$team_obj = $pod_obj->getTeam();
				if (!eregi($team_obj->getID(), $team_str))
				{
					$team_str .= $team_obj->getID().":";
				}
			}
			$team_str = substr ($team_str, 0, (strlen($team_str) - 1));
			$team_array = split (":", $team_str);
			for ($j = 0; $j < sizeof ($team_array); $j++)
			{
				$team_array [$j] = new Team ($team_array [$j]);
			}
			return $team_array;
		}
		
		function totalBets ($type)
		{
			global $db_obj;
			$bet_counter = 0;
			$value_counter = 0;
			$select_result = $db_obj->query ("SELECT id FROM podracer_bets WHERE race = $this->id");
			while ($select_row = mysql_fetch_array ($select_result))
			{
				$bet_obj = new Bet($select_row["id"]);
				$bet_counter++;
				$value_counter += $bet_obj->getAmount();
				unset ($bet_obj);
			}
			if ($type == 1)
				return $bet_counter;
			else
				return $value_counter;
		}
		
		function delete ()
		{
			global $db_obj;
			$update_sql = "DELETE FROM podracer_races WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
				return 1;
			else
				return 0;
		}
	}
?>