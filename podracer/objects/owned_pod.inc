<?php

class OwnedPod extends Podracer {
	
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
	var $date_deleted;
	
	function OwnedPod($id)	{
		Podracer::Podracer();
		
		$sql = "SELECT * FROM `podracer_owned_pods` WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		if ($result = @mysql_fetch_array($query)) {
            foreach ($result as $key => $value) {
                $this->$key = stripslashes($value);
            }
        }
	}		
	
	function Update($call, $value) {
		$sql = "UPDATE `podracer_owned_pods` SET `$call` = '$value' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function GetID() {
		return $this->id;
	}
	
	function GetType() {
		return new Pod($this->type);
	}
	
	function SetType($id) {
		return $this->Update('type', $id);
	}
	
	function GetTeam() {
		return new Team($this->team);
	}
	
	function SetTeam($id) {
		return $this->Update('team', $id);
	}
	
	function GetName() {
		return stripslashes($this->name);
	}
	
	function SetName($id) {
		return $this->Update('name', addslashes($id));
	}
	
	function GetWings() {
		return $this->wings;
	}
	
	function SetWings($id) {
		return $this->Update('wings', $id);
	}
	
	function GetGravBoosters() {
		return $this->grav_boosters;
	}
	
	function SetGravBoosters($id) {
		return $this->Update('grav_boosters', $id);
	}
	
	function GetFuelMix() {
		return $this->fuel_mix;
	}
	
	function SetFuelMix($id) {
		return $this->Update('fuel_mix', $id);
	}
	
	function GetFuelIntake() {
		return $this->fuel_intake;
	}
	
	function SetFuelIntake($id) {
		return $this->Update('fuel_intake', $id);
	}
	
	function GetVent() {
		return $this->vent;
	}
	
	function SetVent($id) {
		return $this->Update('vent', $id);
	}
	
	function GetFastFuel() {
		return $this->fast_fuel;
	}
	
	function SetFastFuel($id) {
		return $this->Update('fast_fuel', $id);
	}
	
	function GetPurifier() {
		return $this->purifier;
	}
	
	function SetPurifier($id) {
		return $this->Update('purifier', $id);
	}
	
	function GetTurboBoost() {
		return $this->turbo_boost;
	}
	
	function SetTurboBoost($id) {
		return $this->Update('turbo_boost', $id);
	}
	
	function GetSuspension() {
		return $this->suspension;
	}
	
	function SetSuspension($id) {
		return $this->Update('suspension', $id);
	}
	
	function GetWeight() {
		return $this->weight;
	}
	
	function SetWeight($id) {
		return $this->Update('weight', $id);
	}
	
	function GetBrakeBalance() {
		return $this->brake_balance;
	}
	
	function SetBrakeBalance($id) {
		return $this->Update('brake_balance', $id);
	}
	
	function GetHoverHeight() {
		return $this->hover_height;
	}
	
	function SetHoverHeight($id) {
		return $this->Update('hover_height', $id);
	}
	
	function GetRewire() {
		return $this->rewire;
	}
	
	function SetRewire($id) {
		return $this->Update('rewire', $id);
	}	
	
	function GetTractionControl() {
		return $this->traction_control;
	}
	
	function SetTractionControl($id) {
		return $this->Update('traction_control', $id);
	}
	
	function GetBypassSafeties() {
		return $this->bypass_safeties;
	}
	
	function SetBypassSafeties($id) {
		return $this->Update('bypass_safeties', $id);
	}
	
	function GetSnowHovers() {
		return $this->snow_hovers;
	}
	
	function SetSnowHovers($id) {
		return $this->Update('snow_hovers', $id);
	}
	
	function GetAntiObstacle() {
		return $this->anti_obstacle;
	}
	
	function SetAntiObstacle($id) {
		return $this->Update('anti_obstacle', $id);
	}
	
	function GetExhaustPipes() {
		return $this->exhaust_pipes;
	}
	
	function SetExhaustPipes($id) {
		return $this->Update('exhaust_pipes', $id);
	}
	
	function GetAeroWings() {
		return $this->aero_wings;
	}
	
	function SetAeroWings($id) {
		return $this->Update('aero_wings', $id);
	}
	
	function GetRepairBots() {
		return $this->repair_bots;
	}
	
	function SetRepairBots($id) {
		return $this->Update('repair_bots', $id);
	}

	function GetBrakeThrusters() {
		return $this->brake_thrusters;
	}
	
	function SetBrakeThrusters($id) {
		return $this->Update('brake_thrusters', $id);
	}
	
	function GetGripGravitons() {
		return $this->grip_gravitons;
	}
	
	function SetGripGravitons($id) {
		return $this->Update('grip_gravitons', $id);
	}
	
	function GetWeaponry() {
		return $this->weaponry;
	}
	
	function SetWeaponry($id) {
		return $this->Update('weaponry', $id);
	}
	
	function GetPowerSteering() {
		return $this->power_steering;
	}
	
	function SetPowerSteering($id) {
		return $this->Update('power_steering', $id);
	}
  
	function ListParts() {
  		$sql = "SELECT `id` FROM `podracer_owned_parts` WHERE `date_deleted` = 0 AND `pod` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new OwnedPart($info['id']);
		}
		
		return $return;
	}

	function ReturnTweaks($type) {
		$traction = 0;
		$turning = 0;
		$acceleration = 0;
		$top_speed = 0;
		$air_brake = 0;
		$cooling = 0;
		$repair = 0;
  
		if ($this->wings == 1) {
			$traction += 0.25;
			$turning += 0.25;
			$top_speed -= 0.25;
			$acceleration -= 0.25;
		}
		
		if ($this->grav_boosters > 0) {
			$traction += $this->grav_boosters * 0.50;
			$top_speed -= $this->grav_boosters * 0.25;
			$acceleration -= $this->grav_boosters * 0.25;
		}
		
		if ($this->fuel_mix > 0) {
			$top_speed += 0.50 * $this->fuel_mix;
			$repair -= 0.50 * $this->fuel_mix;
		}
		
		if ($this->fuel_intake > 0) {
			$top_speed += 0.75 * $this->fuel_intake;
			$cooling -= 0.25 * $this->fuel_intake;
			$repair -= 0.50 * $this->fuel_intake;
		}
		
		if ($this->vent == 1) {
			$cooling += 0.75;
			$top_speed -= 0.75;
		}
		
		if ($this->fast_fuel == 1) {
			$acceleration += 0.75;
			$cooling -= 0.75;
		}
		
		if ($this->purifier == 1) {
			$top_speed += 0.25;
			$acceleration += 0.25;
			$turning -= 0.25;
			$cooling -= 0.25;
		}
		
		if ($this->turbo_boost > 0) {
			$top_speed += 0.25 * $this->turbo_boost;
			$accleration += 0.25 * $this->turbo_boost;    
			$cooling -= 0.25 * $this->turbo_boost;
			$repair -= 0.25 * $this->turbo_boost;
		} elseif ($this->turbo_boost < 0) {
			$cooling -= 0.25 * $this->turbo_boost;
			$repair -= 0.25 * $this->turbo_boost;
			$top_speed += 0.25 * $this->turbo_boost;
			$accleration += 0.25 * $this->turbo_boost;        
		}
		
		if ($this->suspension > 0) {
			$top_speed += 0.50 * $this->suspension;
			$repair -= 0.50 * $this->suspension;
		} elseif ($this->suspension < 0) {
			$repair -= 0.50 * $this->suspension;
			$top_speed += 0.50 * $this->suspension;
		}
		
		if ($this->weight > 0) {
			$turning += 0.25 * $this->weight;
			$traction += 0.25 * $this->weight;
			$top_speed -= 0.25 * $this->weight;
			$acceleration -= 0.25 * $this->weight;
		} elseif ($this->weight < 0) {
			$top_speed -= 0.25 * $this->weight;
			$acceleration -= 0.25 * $this->weight;
			$turning += 0.25 * $this->weight;
			$traction += 0.25 * $this->weight;
		}
		
		if ($this->brake_balance > 0) {
			$top_speed += 0.25 * $this->brake_balance;
			$traction += 0.25 * $this->brake_balance;
			$turning -= 0.50 * $this->brake_balance;
		} elseif ($this->brake_balance < 0) {
			$acceleration -= 0.25 * $this->brake_balance;
			$turning -= 0.25 * $this->brake_balance;
			$traction += 0.50 * $this->brake_balance;
		}
		
		if ($this->hover_height > 0) {
			$repair += 0.25 * $this->hover_height;
			$cooling += 0.25 * $this->hover_height;
			$top_speed -= 0.50 * $this->hover_height;
		} elseif ($this->hover_height < 0) {
			$top_speed += 0.50 * $this->hover_height;
			$repair -= 0.25 * $this->hover_height;
			$cooling -= 0.25 * $this->hover_height;
		}
		
		if ($this->rewire == 1) {
			$top_speed += 0.25;
			$acceleration += 0.25;
			$repair -= 0.25;
			$cooling -= 0.25;
		} elseif ($this->rewire == 2) {
			$repair += 0.25;
			$cooling += 0.25;
			$top_speed -= 0.25;
			$acceleration -= 0.25;
		} elseif ($this->rewire == 3) {
			$traction += 0.25;
			$turning += 0.25;        
			$cooling -= 0.16;
			$top_speed -= 0.17;
			$acceleration -= 0.17;
		} 	
		
		if ($this->traction_control == 1) {
			$acceleration += 0.50;
			$turning -= 0.50;
		}
		
		if ($this->bypass_safties == 1) {
			$top_speed += 0.25;
			$acceleration += 0.25;
			$repair -= 0.50;
		}
		
		if ($this->snow_hovers == 1) {
			$traction += 0.25;
			$turning =+ 0.25;
			$top_speed -= 0.50;
		}
		
		if ($this->anti_obstacle == 1) {
			$turning += 0.50;
			$top_speed -= 0.50;
		}
		
		if ($this->exhaust_pipes == 1) {
			$top_speed += 0.50;
			$repair -= 0.25;
			$traction -= 0.25;
		}
		
		if ($this->aero_wings == 1) {
			$turning += 0.50;
			$top_speed -= 0.50;
		}
		
		if ($this->repair_bots == 1) {
			$repair += 0.50;
			$top_speed -= 0.50;
		}
		
		if ($this->brake_thrusters == 1) {
			$air_brake += 0.55;
			$top_speed -= 0.25;
			$acceleration -= 0.25;
		}
		
		if ($this->grip_gravitons == 1) {
			$acceleration += 0.25;
			$traction += 0.25;
			$top_speed -= 0.50;
		}
		
		if ($this->weaponry == 1) {
			$top_speed -= 0.25;
			$acceleratopm -= 0.25;
			$turning -= 0.25;
		}
		
		if ($this->power_steering == 1) {
			$turning += 0.50;
			$acceleration -= 0.50;
		}
		
		return $$type;
	}
	
	function Limit($number){
		if ($number > 20){
			$number = 25;
		}
		if ($number < -10){
			$number = -10;
		}
		return $number;
	}
	
	function GetTraction($show) {
		$lists = $this->ListParts();
		
		foreach ($lists as $part){
			$part = $part->GetPart();
			$traction += $part->GetIncrease('traction');
		}
		$pod = $this->GetType();
		$traction += $pod->GetTraction();
		if ($show){
			$traction += $this->ReturnTweaks('traction');
		}
		return $this->limit($traction);
	}
	
	function GetTurning($show) {
		$lists = $this->ListParts();
		
		foreach ($lists as $part){
			$part = $part->GetPart();
			$turning += $part->GetIncrease('turning');
		}
		$pod = $this->GetType();
		$turning += $pod->Getturning();
		if ($show){
			$turning += $this->ReturnTweaks('turning');
		}
		return $this->limit($turning);
	}
	
	function GetAcceleration($show) {
		$lists = $this->ListParts();
		
		foreach ($lists as $part){
			$part = $part->GetPart();
			$acceleration += $part->GetIncrease('acceleration');
		}
		$pod = $this->GetType();
		$acceleration += $pod->Getacceleration();
		if ($show){
			$acceleration += $this->ReturnTweaks('acceleration');
		}
		return $this->limit($acceleration);
	}
	
	function GetTopSpeed($show) {
		$lists = $this->ListParts();
		
		foreach ($lists as $part){
			$part = $part->GetPart();
			$top_speed += $part->GetIncrease('top_speed');
		}
		$pod = $this->GetType();
		$top_speed += $pod->GetTopSpeed();
		if ($show){
			$top_speed += $this->ReturnTweaks('top_speed');
		}
		return $this->limit($top_speed);
	}
	
	function GetAirBrake($show) {
		$lists = $this->ListParts();
		
		foreach ($lists as $part){
			$part = $part->GetPart();
			$air_brake += $part->GetIncrease('air_brake');
		}
		$pod = $this->GetType();
		$air_brake += $pod->GetAirBrake();
		if ($show){
			$air_brake += $this->ReturnTweaks('air_brake');
		}
		return $this->limit($air_brake);
	}
	
	function GetCooling($show) {
		$lists = $this->ListParts();
	
		foreach ($lists as $part){
			$part = $part->GetPart();
			$cooling += $part->GetIncrease('cooling');
		}
		$pod = $this->GetType();
		$cooling += $pod->Getcooling();
		if ($show){
			$cooling += $this->ReturnTweaks('cooling');
		}
		return $this->limit($cooling);
	}
	
	function GetRepair($show) {
		$lists = $this->ListParts();
		
		foreach ($lists as $part){
			$part = $part->GetPart();
			$repair += $part->GetIncrease('repair');
		}
		$pod = $this->GetType();
		$repair += $pod->Getrepair();
		if ($show){
			$repair += $this->ReturnTweaks('repair');
		}
		return $this->limit($repair);
	}
	
	function ListRaces() {		
  		$sql = "SELECT `race` FROM `podracer_race_registrations` WHERE `date_deleted` = 0 AND `pod` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new Race($info['race']);
		}
		
		return $return;
	}
	
	function ListRaceRegistrations() {		
  		$sql = "SELECT `id` FROM `podracer_race_registrations` WHERE `date_deleted` = 0 AND `pod` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new RaceRegistration($info['id']);
		}
		
		return $return;
	}
	
	function ListRaceResults() {		
  		$sql = "SELECT `id` FROM `podracer_race_registrations` WHERE `date_deleted` = 0 AND `pod` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$sql = "SELECT `id` FROM `podracer_race_results` WHERE registration = '".$info['id']."'";
			$result = mysql_query($sql, $this->connect);
			while ($put = mysql_fetch_array($result)){
				$return[] = new RaceResult($put['id']);
			}
		}
		
		return $return;
	}
	
	function GetASL() {
		$total = 0;
		$total += $this->GetTraction(1);
		$total += $this->GetTurning(1);
		$total += $this->GetAcceleration(1);
		$total += $this->GetTopSpeed(1);
		$total += $this->GetAirBrake(1);
		$total += $this->GetCooling(1);
		$total += $this->GetRepair(1);
		$type = $this->GetType();
		if ($type->GetCat() == 5){
			$total -= 10;
		}
		return $total;
	}
	
	function GetDeleted() {
		return $this->date_deleted;
	}
	
	function Delete() {
		return $this->Update('date_deleted', time());
	}
}
?>