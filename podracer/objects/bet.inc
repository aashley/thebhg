<?php

	class Bet
	{
		var $id;
		var $bhg_id;
		var $pod;
		var $race;
		var $amount;
		
		function Bet ($part_id)
		{
			global $db_obj;
			$select_sql = "SELECT * FROM podracer_bets WHERE id = $part_id";
			$select_result = $db_obj->query($select_sql);
			$select_row = mysql_fetch_array ($select_result);
			$this->id = $select_row["id"];
			$this->bhg_id = $select_row["bhg_id"];
			$this->pod = $select_row["pod"];
			$this->race = $select_row["race"];
			$this->amount = $select_row["amount"];
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
			$update_sql = "UPDATE podracer_bets set bhg_id = $bhg_id WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->bhg_id = $bhg_id;
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
			$update_sql = "UPDATE podracer_bets set pod = $pod_id WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->pod = $pod_id;
				return 1;
			}
			else
				return 0;
		}
						
		function getRace()
		{
			$race_obj = new Race ($this->race);
			return $race_obj;
		}
		
		function setRace ($race_id)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_bets set race = $race_id WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->race = $race_id;
				return 1;
			}
			else
				return 0;
		}
									
		function getAmount()
		{
			return $this->amount;
		}
		
		function setAmount ($amount_num)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_bets set amount = $amount_num WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->amount = $amount_num;
				return 1;
			}
			else
				return 0;
		}
		
		function getTeam ()
		{
			$pod_obj = $this->getPod();
			$team_obj = $this->getTeam();
			return $team_obj;
		}
		
		function delete ()
		{
			global $db_obj;
			$update_sql = "DELETE FROM podracer_bets WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
				return 1;
			else
				return 0;
		}
	}
?>