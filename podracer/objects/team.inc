<?php

	/**
	* This class is for creating, deleting
	* and editing a single team.
	*/
	
	class Team
	{
		var $id;
		var $name;
		var $leader;
		var $slogan;
		var $url;
		var $credits;
		var $image;
		var $image_type;
		
		function Team ($team_id)
		{
			global $db_obj;
			$select_result = $db_obj->query("SELECT * FROM podracer_teams WHERE id = $team_id");
			$select_row = mysql_fetch_array ($select_result);
			$this->id = $select_row["id"];
			$this->name = $select_row["name"];
			$this->leader = $select_row["leader"];
			$this->slogan = $select_row["slogan"];
			$this->url = $select_row["url"];
			$this->credits = $select_row["credits"];
			$this->image = $select_row["image"];
			$this->image_type = $select_row["image_type"];
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
			$update_sql = "UPDATE podracer_teams set name = '$name_str' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->name = $name_str;
				return 1;
			}
			else
				return 0;
		}		
				
		function getSlogan()
		{
			return $this->slogan;
		}
		
		function setSlogan ($slogan_str)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_teams set slogan = '$slogan_str' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->slogan = $slogan_str;
				return 1;
			}
			else
				return 0;
		}		
				
		function getUrl()
		{
			return $this->url;
		}
		
		function setUrl ($url_str)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_teams set url = '$url_str' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->url = $url_str;
				return 1;
			}
			else
				return 0;
		}		
							
		function getLeader()
		{
			$person_obj = new Person ($this->leader);
			return $person_obj;
		}
		
		function setLeader ($leader_id)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_teams set leader = $leader_id WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->leader = $leader_id;
				return 1;
			}
			else
				return 0;
		}
								
		function getCredits()
		{
			return $this->credits;
		}
		
		function addCredits ($credits_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_teams set credits = credits + $credits_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->credits += $credits_num;
				return 1;
			}
			else
				return 0;
		}
	
		function removeCredits ($credits_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_teams set credits = credits - $credits_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->credits -= $credits_num;
				return 1;
			}
			else
				return 0;
		}
		
		function setCredits ($credits_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_teams set credits = $credits_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->credits = $credits_num;
				return 1;
			}
			else
				return 0;
		}
		
		function getImage()
		{
			return $this->image;
		}
		
		function setImage ($image)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_teams set image = '$image' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->image = $image;
				return 1;
			}
			else
				return 0;
		}		

		function getImage_type()
		{
			return $this->image_type;
		}
		
		function setImage_type ($image_type)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_teams set image_type = '$image_type' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->image_type = $image_type;
				return 1;
			}
			else
				return 0;
		}		

		function listMembers ()
		{
			global $db_obj;
      $members_array = array ();
			$members_result = $db_obj->query ("SELECT id FROM podracer_team_members WHERE team = $this->id ORDER BY donations DESC");
			for ($i = 0; $members_row = mysql_fetch_array ($members_result); $i++)
			{
        $member_obj = new Team_member ($members_row ["id"]);        
				$members_array [$i] = $member_obj;
        $leader_array [$i] = $member_obj->isLeader();
        unset ($member_obj);
			}
      array_multisort ($leader_array, SORT_NUMERIC, SORT_DESC, $members_array);
			return $members_array;
		}
		
		function listMembersRoster ()
		{
			global $db_obj;
      $members_array = array ();
			$members_result = $db_obj->query ("SELECT bhg_id FROM podracer_team_members WHERE team = $this->id");
			for ($i = 0; $members_row = mysql_fetch_array ($members_result); $i++)
				$members_array [$i] = new Person ($members_row ["bhg_id"]);
			return $members_array;
		}
		
		function listPods ()
		{
			global $db_obj;
      $pods_array = array ();
			$pods_result = $db_obj->query ("SELECT id FROM podracer_owned_pods WHERE team = $this->id");
			for ($i = 0; $pods_row = mysql_fetch_array ($pods_result); $i++)
				$pods_array [$i] = new Owned_pod ($pods_row ["id"]);
			return $pods_array;
		}
		
		function listRace_registrations()
		{
			global $db_obj;
      $reg_array = array ();
			$pods_array = $this->listPods();
			$counter = 0;
			for ($i = 0; $i < sizeof ($pods_array); $i++)
			{
				$pod_obj = $pods_array [$i];
				$races_array = $pod_obj->listRace_registrations();
				for ($j = 0; $j < sizeof ($races_array); $j++)
				{
					$reg_array [$counter] = $races_array [$j];
					$counter++;
				}
			}
			return $reg_array;
		}
		
		function listRace_results()
		{
			global $db_obj;
      $result_array = array ();
			$pods_array = $this->listPods();
			$counter = 0;
			for ($i = 0; $i < sizeof ($pods_array); $i++)
			{
				$pod_obj = $pods_array [$i];
				$results_array = $pod_obj->listRace_results();
				for ($j = 0; $j < sizeof ($results_array); $j++)
				{
					$result_array [$counter] = $results_array [$j];
					$counter++;
				}
			}
			return $result_array;
		}
		
		function delete ()
		{
			global $db_obj;
			$update_result = $db_obj->query("DELETE FROM podracer_teams WHERE id = $this->id");
			if ($update_result)
			{
				$db_obj->query("DELETE FROM podracer_team_members WHERE team = $this->id");
				$db_obj->query("DELETE FROM podracer_owned_pods WHERE team = $this->id");
				//loop through pods, delete mods
				return 1;
			}
			else
				return 0;
		}
	}
?>