<?php

	/***************************************
	* Owned_pod Class
	* This class is for creating, deleting
	* and editing a single pod.
	***************************************/
	
	class Owned_pod
	{
		var $id;
		var $type;
		var $team;
		var $name;
    var $wings;
    var $grav_boosters;
    var $fuel_mix;
    var $fuel_intake;
    var $vent;
    var $fast_fuel;
    var $purifier;
    var $turbo_boost;
    var $suspension;
    var $weight;
    var $brake_balance;
    var $hover_height;
    var $rewire;
    var $traction_control;
    var $bypass_safeties;
    var $snow_hovers;
    var $anti_obstacle;
    var $exhaust_pipes;
    var $aero_wings;
    var $repair_bots;
    var $brake_thrusters;
    var $grip_gravitons;
    var $weaponry;
    var $power_steering;
		
		function Owned_pod ($pod_id)
		{
			global $db_obj;
			$select_sql = "SELECT * FROM podracer_owned_pods WHERE id = $pod_id";
			$select_result = $db_obj->query($select_sql);
			$select_row = mysql_fetch_array ($select_result);
			$this->id = $select_row["id"];
			$this->type = $select_row["type"];
			$this->team = $select_row["team"];
			$this->name = $select_row["name"];
			$this->wings = $select_row["wings"];
			$this->grav_boosters = $select_row["grav_boosters"];
			$this->fuel_mix = $select_row["fuel_mix"];
			$this->fuel_intake = $select_row["fuel_intake"];
			$this->vent = $select_row["vent"];
			$this->fast_fuel = $select_row["fast_fuel"];
			$this->purifier = $select_row["purifier"];
			$this->turbo_boost = $select_row["turbo_boost"];
			$this->suspension = $select_row["suspension"];
			$this->weight = $select_row["weight"];
			$this->brake_balance = $select_row["brake_balance"];
			$this->hover_height = $select_row["hover_height"];
			$this->rewire = $select_row["rewire"];
			$this->traction_control = $select_row["traction_control"];
			$this->bypass_safeties = $select_row["bypass_safeties"];
			$this->snow_hovers = $select_row["snow_hovers"];
			$this->anti_obstacle = $select_row["anti_obstacle"];
			$this->exhaust_pipes = $select_row["exhaust_pipes"];
			$this->aero_wings = $select_row["aero_wings"];
			$this->repair_bots = $select_row["repair_bots"];
			$this->brake_thrusters = $select_row["brake_thrusters"];
			$this->grip_gravitons = $select_row["grip_gravitons"];
			$this->weaponry = $select_row["weaponry"];
			$this->power_steering = $select_row["power_steering"];
		}		
		
		function getID ()
		{
			return $this->id;
		}
		
		function getType()
		{
			$pod_obj = new Pod ($this->type);
			return $pod_obj;
		}
		
		function setType ($type_str)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set type = $type_str WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->type = $type_str;
				return 1;
			}
			else
				return 0;
		}
		
		function getTeam()
		{
			$team_obj = new Team ($this->team);
			return $team_obj ;
		}
		
		function setTeam ($team_id)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set team = $team_id WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->team = $team_id;
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
			$update_sql = "UPDATE podracer_owned_pods set name = '$name_str' WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->name = $name_str;
				return 1;
			}
			else
				return 0;
		}
		
    function getWings()
		{
			return $this->wings;
		}
		
		function setWings ($wings)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set wings = $wings WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->wings = $wings;
				return 1;
			}
			else
				return 0;
		}
		
    function getGrav_boosters()
		{
			return $this->grav_boosters;
		}
		
		function setGrav_boosters ($grav_boosters)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set grav_boosters = $grav_boosters WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->grav_boosters = $grav_boosters;
				return 1;
			}
			else
				return 0;
		}
		
    function getFuel_mix()
		{
			return $this->fuel_mix;
		}
		
		function setFuel_mix ($fuel_mix)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set fuel_mix = $fuel_mix WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->fuel_mix = $fuel_mix;
				return 1;
			}
			else
				return 0;
		}
		
    function getFuel_intake()
		{
			return $this->fuel_intake;
		}
		
		function setFuel_intake ($fuel_intake)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set fuel_intake = $fuel_intake WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->fuel_intake = $fuel_intake;
				return 1;
			}
			else
				return 0;
		}
		
    function getVent()
		{
			return $this->vent;
		}
		
		function setVent ($vent)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set vent = $vent WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->vent = $vent;
				return 1;
			}
			else
				return 0;
		}
		
    function getFast_fuel()
		{
			return $this->fast_fuel;
		}
		
		function setFast_fuel ($fast_fuel)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set fast_fuel = $fast_fuel WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->fast_fuel = $fast_fuel;
				return 1;
			}
			else
				return 0;
		}
		
    function getPurifier()
		{
			return $this->purifier;
		}
		
		function setPurifier ($purifier)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set purifier = $purifier WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->purifier = $purifier;
				return 1;
			}
			else
				return 0;
		}
		
    function getTurbo_boost()
		{
			return $this->turbo_boost;
		}
		
		function setTurbo_boost ($turbo_boost)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set turbo_boost = $turbo_boost WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->turbo_boost = $turbo_boost;
				return 1;
			}
			else
				return 0;
		}
		
    function getSuspension()
		{
			return $this->suspension;
		}
		
		function setSuspension ($suspension)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set suspension = $suspension WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->suspension = $suspension;
				return 1;
			}
			else
				return 0;
		}
		
    function getWeight()
		{
			return $this->weight;
		}
		
		function setWeight ($weight)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set weight = $weight WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->weight = $weight;
				return 1;
			}
			else
				return 0;
		}
		
    function getBrake_balance()
		{
			return $this->brake_balance;
		}
		
		function setBrake_balance ($brake_balance)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set brake_balance = $brake_balance WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->brake_balance = $brake_balance;
				return 1;
			}
			else
				return 0;
		}
		
    function getHover_height()
		{
			return $this->hover_height;
		}
		
		function setHover_height ($hover_height)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set hover_height = $hover_height WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->hover_height = $hover_height;
				return 1;
			}
			else
				return 0;
		}
		
    function getRewire()
		{
			return $this->rewire;
		}
		
		function setRewire ($rewire)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set rewire = $rewire WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->rewire = $rewire;
				return 1;
			}
			else
				return 0;
		}
		
    function getTraction_control()
		{
			return $this->traction_control;
		}
		
		function setTraction_control ($traction_control)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set traction_control = $traction_control WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->traction_control = $traction_control;
				return 1;
			}
			else
				return 0;
		}
		
    function getBypass_safeties()
		{
			return $this->bypass_safeties;
		}
		
		function setBypass_safeties ($bypass_safeties)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set bypass_safeties = $bypass_safeties WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->bypass_safeties = $bypass_safeties;
				return 1;
			}
			else
				return 0;
		}
		
    function getSnow_hovers()
		{
			return $this->snow_hovers;
		}
		
		function setSnow_hovers ($snow_hovers)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set snow_hovers = $snow_hovers WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->snow_hovers = $snow_hovers;
				return 1;
			}
			else
				return 0;
		}
		
    function getAnti_obstacle()
		{
			return $this->anti_obstacle;
		}
		
		function setAnti_obstacle ($anti_obstacle)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set anti_obstacle = $anti_obstacle WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->anti_obstacle = $anti_obstacle;
				return 1;
			}
			else
				return 0;
		}
		
    function getExhaust_pipes()
		{
			return $this->exhaust_pipes;
		}
		
		function setExhaust_pipes ($exhaust_pipes)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set exhaust_pipes = $exhaust_pipes WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->exhaust_pipes = $exhaust_pipes;
				return 1;
			}
			else
				return 0;
		}
		
    function getAero_wings()
		{
			return $this->aero_wings;
		}
		
		function setAero_wings ($aero_wings)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set aero_wings = $aero_wings WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->aero_wings = $aero_wings;
				return 1;
			}
			else
				return 0;
		}
		
    function getRepair_bots()
		{
			return $this->repair_bots;
		}
		
		function setRepair_bots ($repair_bots)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set repair_bots = $repair_bots WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->repair_bots = $repair_bots;
				return 1;
			}
			else
				return 0;
		}
		
    function getBrake_thrusters()
		{
			return $this->brake_thrusters;
		}
		
		function setBrake_thrusters ($brake_thrusters)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set brake_thrusters = $brake_thrusters WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->brake_thrusters = $brake_thrusters;
				return 1;
			}
			else
			{
				return 0;
			}
		}
		
    function getGrip_gravitons()
		{
			return $this->grip_gravitons;
		}
		
		function setGrip_gravitons ($grip_gravitons)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set grip_gravitons = $grip_gravitons WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->grip_gravitons = $grip_gravitons;
				return 1;
			}
			else
				return 0;
		}
		
    function getWeaponry()
		{
			return $this->weaponry;
		}
		
		function setWeaponry ($weaponry)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set weaponry = $weaponry WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->weaponry = $weaponry;
				return 1;
			}
			else
				return 0;
		}
		
    function getPower_steering()
		{
			return $this->power_steering;
		}
		
		function setPower_steering ($power_steering)
		{
			global $db_obj;
			$update_sql = "UPDATE podracer_owned_pods set power_steering = $power_steering WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$this->power_steering = $power_steering;
				return 1;
			}
			else
				return 0;
		}
      
		function listParts ()
		{
			global $db_obj;
			$part_result = $db_obj->query ("SELECT id FROM podracer_owned_parts WHERE pod = $this->id");
			for ($i = 0; $part_row = mysql_fetch_array ($part_result); $i++)
			{
				$part_array [$i] = new Owned_part ($part_row["id"]);
			}
			return $part_array;
		}
    
    function returnTweaks ($type)
    {
      $traction = 0;
      $turning = 0;
      $acceleration = 0;
      $top_speed = 0;
      $air_brakes = 0;
      $cooling = 0;
      $repair = 0;
      
      if ($this->wings == 1)
      {
        $traction += 0.25;
        $turning += 0.25;
        $top_speed -= 0.25;
        $acceleration -= 0.25;
      }
      if ($this->grav_boosters == 1)
      {
        $traction += 0.50;
        $top_speed -= 0.25;
        $acceleration -= 0.25;
      }
      if ($this->fuel_mix > 0)
      {
        $top_speed += 0.50 * $this->fuel_mix;
        $repair -= 0.50 * $this->fuel_mix;
      }
      if ($this->fuel_intake > 0)
      {
        $top_speed += 0.75 * $this->fuel_intake;
        $cooling -= 0.25 * $this->fuel_intake;
        $repair -= 0.50 * $this->fuel_intake;
      }
      if ($this->vent == 1)
      {
        $cooling += 0.75;
        $top_speed -= 0.75;
      }
      if ($this->fast_fuel == 1)
      {
        $acceleration += 0.75;
        $cooling -= 0.75;
      }
      if ($this->purifier == 1)
      {
        $top_speed += 0.25;
        $acceleration += 0.25;
        $turning -= 0.25;
        $cooling -= 0.25;
      }
      if ($this->turbo_boost > 0)
      {
        $top_speed += 0.25 * $this->turbo_boost;
        $accleration += 0.25 * $this->turbo_boost;    
        $cooling -= 0.25 * $this->turbo_boost;
        $repair -= 0.25 * $this->turbo_boost;
      }
      elseif ($this->turbo_boost < 0)
      {
        $cooling += 0.25 * $this->turbo_boost;
        $repair += 0.25 * $this->turbo_boost;
        $top_speed -= 0.25 * $this->turbo_boost;
        $accleration -= 0.25 * $this->turbo_boost;        
      }
      if ($this->suspension > 0)
      {
        $top_speed += 0.50 * $this->suspension;
        $repair -= 0.50 * $this->suspension;
      }
      elseif ($this->suspension < 0)
      {
        $repair += 0.50 * $this->suspension;
        $top_speed -= 0.50 * $this->suspension;
      }
      if ($this->weight > 0)
      {
        $turning += 0.25 * $this->weight;
        $traction += 0.25 * $this->weight;
        $top_speed -= 0.25 * $this->weight;
        $acceleration -= 0.25 * $this->weight;
      }
      elseif ($this->weight < 0)
      {
        $top_speed += 0.25 * $this->weight;
        $acceleration += 0.25 * $this->weight;
        $turning -= 0.25 * $this->weight;
        $traction -= 0.25 * $this->weight;
      }
      if ($this->brake_balance > 0)
      {
        $top_speed += 0.25 * $this->brake_balance;
        $traction += 0.25 * $this->brake_balance;
        $turning -= 0.50 * $this->brake_balance;
      }
      elseif ($this->brake_balance < 0)
      {
        $acceleration += 0.25 * $this->brake_balance;
        $turning += 0.25 * $this->brake_balance;
        $traction -= 0.50 * $this->brake_balance;
      }
      if ($this->hover_height > 0)
      {
        $repair += 0.25 * $this->hover_height;
        $cooling += 0.25 * $this->hover_height;
        $top_speed -= 0.50 * $this->hover_height;
      }
      elseif ($this->hover_height < 0)
      {
        $top_speed += 0.50 * $this->hover_height;
        $repair -= 0.25 * $this->hover_height;
        $cooling -= 0.25 * $this->hover_height;
      }
      if ($this->rewire == 1)
      {
        $top_speed += 0.25;
        $acceleration += 0.25;
        $repair -= 0.25;
        $cooling -= 0.25;
      }
      elseif ($this->rewire == 2)
      {
        $repair += 0.25;
        $cooling += 0.25;
        $top_speed -= 0.25;
        $acceleration -= 0.25;
      }
      elseif ($this->rewire == 3)
      {
        $traction += 0.25;
        $turning += 0.25;        
        $cooling -= 0.16;
        $top_speed -= 0.17;
        $acceleration -= 0.17;
      }
      if ($this->traction_control == 1)
      {
        $acceleration += 0.50;
        $turning -= 0.50;
      }
      if ($this->bypass_safties == 1)
      {
        $top_speed += 0.25;
        $acceleration += 0.25;
        $repair -= 0.50;
      }
      if ($this->snow_hovers == 1)
      {
        $traction += 0.25;
        $turning =+ 0.25;
        $top_speed -= 0.50;
      }
      if ($this->anti_obstacle == 1)
      {
        $turning += 0.50;
        $top_speed -= 0.50;
      }
      if ($this->exhaust_pipes == 1)
      {
        $top_speed += 0.50;
        $repair -= 0.25;
        $traction -= 0.25;
      }
      if ($this->aero_wings == 1)
      {
        $turning += 0.50;
        $top_speed -= 0.50;
      }
      if ($this->repair_bots == 1)
      {
        $repair += 0.50;
        $top_speed -= 0.50;
      }
      if ($this->brake_thrusters == 1)
      {
        $air_brakes += 0.50;
        $top_speed -= 0.25;
        $acceleration -= 0.25;
      }
      if ($this->grip_gravitons == 1)
      {
        $acceleration += 0.25;
        $traction += 0.25;
        $top_speed -= 0.50;
      }
      if ($this->weaponry == 1)
      {
        $top_speed -= 0.25;
        $acceleratopm -= 0.25;
        $turning -= 0.25;
      }
      if ($this->power_steering == 1)
      {
        $turning += 0.50;
        $acceleration -= 0.50;
      }
      return $$type;
    }
		
		function getTraction ($show)
		{
			global $db_obj;
			$pod_obj = new Pod ($this->type);
			$part_result = $db_obj->query ("SELECT id FROM podracer_owned_parts WHERE pod = $this->id");
			while ($part_row = mysql_fetch_array ($part_result))
			{
				$owned_part_obj = new Owned_part ($part_row["id"]);
				$part_type_obj = $owned_part_obj->getPart();
				if ($part_type_obj->getType() == "traction")
					$part_traction = $part_type_obj->getIncrease();
				unset ($part_type_obj);
				unset ($owned_part_obj);
			}
			$total_traction = $pod_obj->getTraction() + $part_traction;
      if ($show == 1) { $total_traction += $this->returnTweaks ("traction"); }
			return $total_traction;
		}
		
		function getTurning ($show)
		{
			global $db_obj;
			$pod_obj = new Pod ($this->type);
			$part_result = $db_obj->query ("SELECT id FROM podracer_owned_parts WHERE pod = $this->id");
			while ($part_row = mysql_fetch_array ($part_result))
			{
				$owned_part_obj = new Owned_part ($part_row["id"]);
				$part_type_obj = $owned_part_obj->getPart();
				if ($part_type_obj->getType() == "turning")
					$part_turning = $part_type_obj->getIncrease();
				unset ($part_type_obj);
				unset ($owned_part_obj);
			}
			$total_turning = $pod_obj->getTurning() + $part_turning;
      if ($show == 1) { $total_turning += $this->returnTweaks ("turning"); }
			return $total_turning;
		}
		
		function getAcceleration ($show)
		{
			global $db_obj;
			$pod_obj = new Pod ($this->type);
			$part_result = $db_obj->query ("SELECT id FROM podracer_owned_parts WHERE pod = $this->id");
			while ($part_row = mysql_fetch_array ($part_result))
			{
				$owned_part_obj = new Owned_part ($part_row["id"]);
				$part_type_obj = $owned_part_obj->getPart();
				if ($part_type_obj->getType() == "acceleration")
					$part_acceleration = $part_type_obj->getIncrease();
				unset ($part_type_obj);
				unset ($owned_part_obj);
			}
			$total_acceleration = $pod_obj->getAcceleration() + $part_acceleration;   
      if ($show == 1) { $total_acceleration += $this->returnTweaks ("acceleration"); }
			return $total_acceleration;
		}
		
		function getTop_speed ($show)
		{
			global $db_obj;
			$pod_obj = new Pod ($this->type);
			$part_result = $db_obj->query ("SELECT id FROM podracer_owned_parts WHERE pod = $this->id");
			while ($part_row = mysql_fetch_array ($part_result))
			{
				$owned_part_obj = new Owned_part ($part_row["id"]);
				$part_type_obj = $owned_part_obj->getPart();
				if ($part_type_obj->getType() == "top_speed")
					$part_top_speed = $part_type_obj->getIncrease();
				unset ($part_type_obj);
				unset ($owned_part_obj);
			}
			$total_top_speed = $pod_obj->getTop_speed() + $part_top_speed;
      if ($show == 1) { $total_top_speed += $this->returnTweaks ("top_speed"); }
			return $total_top_speed;
		}
		
		function getAir_brake ($show)
		{
			global $db_obj;
			$pod_obj = new Pod ($this->type);
			$part_result = $db_obj->query ("SELECT id FROM podracer_owned_parts WHERE pod = $this->id");
			while ($part_row = mysql_fetch_array ($part_result))
			{
				$owned_part_obj = new Owned_part ($part_row["id"]);
				$part_type_obj = $owned_part_obj->getPart();
				if ($part_type_obj->getType() == "air_brake")
					$part_air_brake = $part_type_obj->getIncrease();
				unset ($part_type_obj);
				unset ($owned_part_obj);
			}
			$total_air_brake = $pod_obj->getAir_brake() + $part_air_brake;
      if ($show == 1) { $total_air_brake += $this->returnTweaks ("air_brake"); }
			return $total_air_brake;
		}
				
		function getCooling ($show)
		{
			global $db_obj;
			$pod_obj = new Pod ($this->type);
			$part_result = $db_obj->query ("SELECT id FROM podracer_owned_parts WHERE pod = $this->id");
			while ($part_row = mysql_fetch_array ($part_result))
			{
				$owned_part_obj = new Owned_part ($part_row["id"]);
				$part_type_obj = $owned_part_obj->getPart();
				if ($part_type_obj->getType() == "cooling")
					$part_cooling = $part_type_obj->getIncrease();
				unset ($part_type_obj);
				unset ($owned_part_obj);
			}
			$total_cooling = $pod_obj->getCooling() + $part_cooling;     
      if ($show == 1) { $total_cooling += $this->returnTweaks ("cooling"); }
			return $total_cooling;
		}
		
		function getRepair ($show)
		{
			global $db_obj;
			$pod_obj = new Pod ($this->type);
			$part_result = $db_obj->query ("SELECT id FROM podracer_owned_parts WHERE pod = $this->id");
			while ($part_row = mysql_fetch_array ($part_result))
			{
				$owned_part_obj = new Owned_part ($part_row["id"]);
				$part_type_obj = $owned_part_obj->getPart();
				if ($part_type_obj->getType() == "repair")
					$part_repair = $part_type_obj->getIncrease();
				unset ($part_type_obj);
				unset ($owned_part_obj);
			}
			$total_repair = $pod_obj->getRepair() + $part_repair;      
      if ($show == 1) { $total_repair += $this->returnTweaks ("repair"); }
			return $total_repair;
		}
		
		function listRaces ()
		{
			global $db_obj;
      $races_array = array ();
			$select_sql = "SELECT race FROM podracer_race_registrations WHERE pod = $this->id";
			$select_result = $db_obj->query($select_sql);
			for ($i = 0; $select_row = mysql_fetch_array ($select_result); $i++)
				$races_array [$i] = new Race ($select_row["race"]);
			return $races_array;
		}
		
		function listRace_registrations ()
		{
			global $db_obj;
      $races_array = array ();
			$select_sql = "SELECT id FROM podracer_race_registrations WHERE pod = $this->id";
			$select_result = $db_obj->query($select_sql);
			for ($i = 0; $select_row = mysql_fetch_array ($select_result); $i++)
			  $races_array [$i] = new Race_registration ($select_row["id"]);
			return $races_array;
		}
		
		function listRace_results ()
		{
			global $db_obj;
      $result_array = array ();
			$counter = 0;
			$select_sql = "SELECT id FROM podracer_race_registrations WHERE pod = $this->id";
			$select_result = $db_obj->query($select_sql);
			for ($i = 0; $select_row = mysql_fetch_array ($select_result); $i++)
			{
				$reg_obj = new Race_registration ($select_row["id"]);
				$result_result = $db_obj->query ("SELECT id FROM podracer_race_results WHERE registration = ".$reg_obj->getID());
				if (mysql_num_rows ($result_result) > 0)
				{
					$result_row = mysql_fetch_array ($result_result);
					$result_array [$counter] = new Race_result ($result_row["id"]);
					$counter++;
				}
			}
			return $result_array;
		}
		
		function getASL ()
		{
			$total = 0;
			$total += $this->getTraction(1);
			$total += $this->getTurning(1);
			$total += $this->getAcceleration(1);
			$total += $this->getTop_speed(1);
			$total += $this->getAir_brake(1);
			$total += $this->getCooling(1);
			$total += $this->getRepair(1);
			return $total;
		}
		
		function delete ()
		{
			global $db_obj;
			$update_sql = "DELETE FROM podracer_owned_pods WHERE id = $this->id";
			$update_result = $db_obj->query($update_sql);
			if ($update_result)
			{
				$update_result = $db_obj->query("DELETE FROM podracer_race_registrations WHERE pod = $this->id");
				$update_result = $db_obj->query("DELETE FROM podracer_owned_parts WHERE pod = $this->id");
				return 1;
			}
			else
				return 0;
		}
	}
?>