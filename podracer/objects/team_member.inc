<?php

	/**
	* This class is for creating, deleting
	* and editing a single team member.
	*/
	
	class Team_member
	{
		var $id;
		var $bhg_id;
		var $team;
		var $donations;
		var $recieved;
		
		function Team_member ($member_id)
		{
			global $db_obj;
			$select_result = $db_obj->query("SELECT * FROM podracer_team_members WHERE id = $member_id");
			$select_row = mysql_fetch_array ($select_result);
			$this->id = $select_row["id"];
			$this->bhg_id = $select_row["bhg_id"];
			$this->team = $select_row["team"];
			$this->donations = $select_row["donations"];
			$this->recieved = $select_row["recieved"];
		}		
		
		function getID ()
		{
			return $this->id;
		}
				
		function getBhg_id()
		{
			$person_obj = new Person ($this->bhg_id);
			return $person_obj;
		}
		
		function setBhg_id ($bhg_id)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_team_members set bhg_id = $bhg_id WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->bhg_id = $bhg_id;
				return 1;
			}
			else
				return 0;
		}
		
		function getTeam()
		{
			$team_obj = new Team ($this->team);
			return $team_obj;
		}
		
		function setTeam ($team_id)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_team_members set team = $team_id WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->team = $team_id;
				return 1;
			}
			else
				return 0;
		}
								
		function getDonations()
		{
			return $this->donations;
		}
		
		function addDonations ($donations_val)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_team_members set donations = donations + $donations_val WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->donations += $donations_val;
				return 1;
			}
			else
				return 0;
		}
									
		function getRecieved()
		{
			return $this->recieved;
		}
		
		function addRecieved ($recieved_val)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_team_members set recieved = recieved + $recieved_val WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->recieved += $recieved_val;
				return 1;
			}
			else
				return 0;
		}
		
		function isLeader ()
		{
			global $db_obj;
			$teams_result = $db_obj->query ("SELECT COUNT(*) AS num FROM podracer_teams WHERE leader = ".$this->bhg_id." AND id = ".$this->team);
			if (mysql_result ($teams_result, 0, "num") > 0)
			{
				return TRUE;
			}
			else
				return FALSE;
		}
		function delete ()
		{
			global $db_obj;
			$update_result = $db_obj->query("DELETE FROM podracer_team_members WHERE id = $this->id");
			if ($update_result)
			{
				return 1;
			}
			else
				return 0;
		}
	}
?>