<?php

	include "../setup.php";
	
	if (!isset($PHP_AUTH_USER)) 
	{
		die(login_failed());
	} 
	else 
	{  
		//Login object from the BHG roster
		$hunter_obj = new Login ($PHP_AUTH_USER, $PHP_AUTH_PW, $coder_id);
		if ($hunter_obj->IsValid())
		{
  		$team_member_obj = $podracer_obj->findTeam_member ($hunter_obj->getID());
  		$team_obj = $team_member_obj->getTeam();
      if (isset($Tweak))
      {
        $pod_obj = new Owned_pod ($pod_id);
        if (isset($Submitted))
        {
          $pod_obj->setWings ($wings);
          $pod_obj->setGrav_boosters ($grav_boosters);
          $pod_obj->setFuel_mix ($fuel_mix);
          $pod_obj->setFuel_intake ($fuel_intake);
          $pod_obj->setVent ($vent);
          $pod_obj->setFast_fuel ($fast_fuel);
          $pod_obj->setPurifier ($purifier);
          $pod_obj->setTurbo_boost ($turbo_boost);
          $pod_obj->setSuspension ($suspension);
          $pod_obj->setWeight ($weight);
          $pod_obj->setBrake_balance ($brake_balance);
          $pod_obj->setHover_height ($hover_height);
          $pod_obj->setRewire ($rewire);
          $pod_obj->setTraction_control ($traction_control);
          $pod_obj->setBypass_safeties ($bypass_safeties);
          $pod_obj->setSnow_hovers ($snow_hovers);
          $pod_obj->setAnti_obstacle ($anti_obstacle);
          $pod_obj->setExhaust_pipes ($exhaust_pipes);
          $pod_obj->setAero_wings ($aero_wings);
          $pod_obj->setRepair_bots ($repair_bots);
          $pod_obj->setBrake_thrusters ($brake_thrusters);
          $pod_obj->setGrip_gravitons ($grip_gravitons);
          $pod_obj->setWeaponry ($weaponry);
          $pod_obj->setPower_steering ($power_steering);
          $gui_obj->addContent ("<p align=\"center\"><br>\"".$pod_obj->getName()."\" successfully tweaked</p>\r\n");
        }
        elseif (isset($Reset))
        {
          $pod_obj->setWings (0);
          $pod_obj->setGrav_boosters (0);
          $pod_obj->setFuel_mix (0);
          $pod_obj->setFuel_intake (0);
          $pod_obj->setVent (0);
          $pod_obj->setFast_fuel (0);
          $pod_obj->setPurifier (0);
          $pod_obj->setTurbo_boost (0);
          $pod_obj->setSuspension (0);
          $pod_obj->setWeight (0);
          $pod_obj->setBrake_balance (0);
          $pod_obj->setHover_height (0);
          $pod_obj->setRewire (0);
          $pod_obj->setTraction_control (0);
          $pod_obj->setBypass_safeties (0);
          $pod_obj->setSnow_hovers (0);
          $pod_obj->setAnti_obstacle (0);
          $pod_obj->setExhaust_pipes (0);
          $pod_obj->setAero_wings (0);
          $pod_obj->setRepair_bots (0);
          $pod_obj->setBrake_thrusters (0);
          $pod_obj->setGrip_gravitons (0);
          $pod_obj->setWeaponry (0);
          $pod_obj->setPower_steering (0);
          $gui_obj->addContent ("<p align=\"center\"><br>\"".$pod_obj->getName()."\" tweaks successfully reset</p>\r\n");
        }
        else
        {
          $gui_obj->addContent ("<h2 align=\"center\">Tweak Pod</h2>\r\n");          
          $gui_obj->addContent ("<form action=\"".$PHP_SELF."\" method=\"POST\">\r\n");
          $gui_obj->addContent ("  <table>\r\n");
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Wings</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"wings\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getWings() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">No Wings</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getWings() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Use Wings (+Tr, +Tu, -Sp, -Ac)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");       
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Grav Boosters</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"grav_boosters\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getGrav_boosters() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">No Boosters</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getGrav_boosters() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Boosters Lv1 (++Tr, -Sp, -Ac)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"2\"");
          if ($pod_obj->getGrav_boosters() == 2) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Boosters Lv2 (++Tr, -Sp, -Ac)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"3\"");
          if ($pod_obj->getGrav_boosters() == 3) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Boosters Lv3 (++Tr, -Sp, -Ac)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"4\"");
          if ($pod_obj->getGrav_boosters() == 4) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Boosters Lv4 (++Tr, -Sp, -Ac)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>"); 
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Fuel Mix</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"fuel_mix\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getFuel_mix() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Normal Mix</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getFuel_mix() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Speed Mix Lv1 (++Sp, --Re)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"2\"");
          if ($pod_obj->getFuel_mix() == 2) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Speed Mix Lv2 (++Sp, --Re)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"3\"");
          if ($pod_obj->getFuel_mix() == 3) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Speed Mix Lv3 (++Sp, --Re)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"4\"");
          if ($pod_obj->getFuel_mix() == 4) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Speed Mix Lv4 (++Sp, --Re)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>"); 
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Fuel Intake</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"fuel_intake\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getFuel_intake() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Default Intake</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getFuel_intake() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Increased Intake Lv1 (++Sp, -Co, -Re)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"2\"");
          if ($pod_obj->getFuel_intake() == 2) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Increased Intake Lv2 (++Sp, -Co, -Re)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"3\"");
          if ($pod_obj->getFuel_intake() == 3) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Increased Intake Lv3 (++Sp, -Co, -Re)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"4\"");
          if ($pod_obj->getFuel_intake() == 4) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Increased Intake Lv4 (++Sp, -Co, -Re)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");     
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Cooling Vent</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"vent\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getVent() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">No Vent</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getVent() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Add Vent (+Co, -Sp)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");   
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Fast Fuel Injection</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"fast_fuel\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getFast_fuel() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">No Injection</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getFast_fuel() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Add Injector (+Ac, -Co)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");     
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Fuel Purifier</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"purifier\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getPurifier() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">No Purifier</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getPurifier() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Add Purifier (+Sp, +Ac, -Co, -Tu)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");      
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Turbo Boost</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"turbo_boost\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getTurbo_boost() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Defaul Boost</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-1\"");
          if ($pod_obj->getTurbo_boost() == -1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Decrease Boost Lv1 (+Co, +Re, -Sp, -Ac)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-2\"");
          if ($pod_obj->getTurbo_boost() == -2) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Decrease Boost Lv2 (+Co, +Re, -Sp, -Ac)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-3\"");
          if ($pod_obj->getTurbo_boost() == -3) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Decrease Boost Lv3 (+Co, +Re, -Sp, -Ac)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-4\"");
          if ($pod_obj->getTurbo_boost() == -4) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Decrease Boost Lv4 (+Co, +Re, -Sp, -Ac)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getTurbo_boost() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Increase Boost Lv1 (+Sp, +Ac, -Co, -Re)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"2\"");
          if ($pod_obj->getTurbo_boost() == 2) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Increase Boost Lv2 (+Sp, +Ac, -Co, -Re)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"3\"");
          if ($pod_obj->getTurbo_boost() == 3) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Increase Boost Lv3 (+Sp, +Ac, -Co, -Re)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"4\"");
          if ($pod_obj->getTurbo_boost() == 4) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Increase Boost Lv4 (+Sp, +Ac, -Co, -Re)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");   
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Hovering Suspension</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"suspension\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getSuspension() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Default Suspension</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getSuspension() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Hard Suspension Lv1 (+Sp, -Re)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"2\"");
          if ($pod_obj->getSuspension() == 2) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Hard Suspension Lv2 (+Sp, -Re)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"3\"");
          if ($pod_obj->getSuspension() == 3) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Hard Suspension Lv3 (+Sp, -Re)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"4\"");
          if ($pod_obj->getSuspension() == 4) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Hard Suspension Lv4 (+Sp, -Re)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-1\"");
          if ($pod_obj->getSuspension() == -1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Soft  Suspension Lv1 (+Re, -Sp)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-2\"");
          if ($pod_obj->getSuspension() == -2) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Soft Suspension Lv2 (+Re, -Sp)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-3\"");
          if ($pod_obj->getSuspension() == -3) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Soft Suspension Lv3 (+Re, -Sp)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-4\"");
          if ($pod_obj->getSuspension() == -4) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Soft Suspension Lv4 (+Re, -Sp)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");      
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Weight</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"weight\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getWeight() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Default Weight</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getWeight() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Make Heavier Lv1 (+Tr, +Tu, -Sp, -Ac)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"2\"");
          if ($pod_obj->getWeight() == 2) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Make Heavier Lv2 (+Tr, +Tu, -Sp, -Ac)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"3\"");
          if ($pod_obj->getWeight() == 3) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Make Heavier Lv3 (+Tr, +Tu, -Sp, -Ac)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"4\"");
          if ($pod_obj->getWeight() == 4) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Make Heavier Lv4 (+Tr, +Tu, -Sp, -Ac)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-1\"");
          if ($pod_obj->getWeight() == -1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Make Lighter Lv1 (+Sp, +Ac, -Tr, -Tu)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-2\"");
          if ($pod_obj->getWeight() == -2) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Make Lighter Lv2 (+Sp, +Ac, -Tr, -Tu)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-3\"");
          if ($pod_obj->getWeight() == -3) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Make Lighter Lv3 (+Sp, +Ac, -Tr, -Tu)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-4\"");
          if ($pod_obj->getWeight() == -4) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Make Lighter Lv4 (+Sp, +Ac, -Tr, -Tu)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");        
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Brake Balance</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"brake_balance\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getBrake_balance() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Normal Balance</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getBrake_balance() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Front Balance Lv1 (+Sp, +Tr, --Tu)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"2\"");
          if ($pod_obj->getBrake_balance() == 2) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Front Balance Lv2 (+Sp, +Tr, --Tu)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"3\"");
          if ($pod_obj->getBrake_balance() == 3) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Front Balance Lv3 (+Sp, +Tr, --Tu)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"4\"");
          if ($pod_obj->getBrake_balance() == 4) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Front Balance Lv4 (+Sp, +Tr, --Tu)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-1\"");
          if ($pod_obj->getBrake_balance() == -1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Rear Balance Lv1 (+Ac, +Tu, --Tr)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-2\"");
          if ($pod_obj->getBrake_balance() == -2) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Rear Balance Lv1 (+Ac, +Tu, --Tr)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-3\"");
          if ($pod_obj->getBrake_balance() == -3) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Rear Balance Lv1 (+Ac, +Tu, --Tr)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-4\"");
          if ($pod_obj->getBrake_balance() == -4) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Rear Balance Lv1 (+Ac, +Tu, --Tr)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");       
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Hover Height</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"hover_height\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getHover_height() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Default Height</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getHover_height() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Higher Lv1 (+Re, +Co, --Sp)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"2\"");
          if ($pod_obj->getHover_height() == 2) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Higher Lv2 (+Re, +Co, --Sp)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"3\"");
          if ($pod_obj->getHover_height() == 3) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Higher Lv3 (+Re, +Co, --Sp)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"4\"");
          if ($pod_obj->getHover_height() == 4) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Higher Lv4 (+Re, +Co, --Sp)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-1\"");
          if ($pod_obj->getHover_height() == -1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Lower Lv1 (++Sp, -Co, -Re)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-2\"");
          if ($pod_obj->getHover_height() == -2) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Lower Lv2 (++Sp, -Co, -Re)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-3\"");
          if ($pod_obj->getHover_height() == -3) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Lower Lv3 (++Sp, +-Co, -Re)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"-4\"");
          if ($pod_obj->getHover_height() == -4) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Lower Lv4 (++Sp, +-Co, -Re)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>"); 
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Rewire</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"rewire\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getRewire() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">No Rewiring</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getRewire() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Rewire for Speed (+Sp, +Ac, -Re, -Co)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"2\"");
          if ($pod_obj->getRewire() == 2) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Rewire for Cooling (+Co, +Re, -Sp, -Ac)</option>\r\n");
          $gui_obj->addContent ("        <option value=\"3\"");
          if ($pod_obj->getRewire() == 3) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Rewire for Traction (+Tr, +Tu, -Sp, -Ac, -Co)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");      
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Traction Control</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"traction_control\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getTraction_control() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">No Traction Control</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getTraction_control() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Add Traction Control (+Ac, -Tu)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");          
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Bypass Safeties</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"bypass_safeties\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getBypass_safeties() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Do not bypass</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getBypass_safeties() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Bypass (+Ac, +Sp, --Re)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");            
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Snow Hovers</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"snow_hovers\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getSnow_hovers() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">No Snow Hovers</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getSnow_hovers() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Add Snow Hovers (+Tr, +Tu, -Sp)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");             
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Anti-Obstacle-Nav</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"anti_obstacle\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getAnti_obstacle() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">No Anti-Obstacle-Nav</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getAnti_obstacle() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Add Anti-Obstacle-Nav (+Tu, -Sp)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");          
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Exhaust Pipes</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"exhaust_pipes\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getExhaust_pipes() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">No Exhaust Pipes</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getExhaust_pipes() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Add Exhaust Pipes (+Sp, -Re, -Tr)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");      
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Aero-Wings</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"aero_wings\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getAero_wings() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">No Aero-Wings</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getAero_wings() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Add Aero-Wings (+Tr, -Sp)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");      
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Micro Repair Bots</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"repair_bots\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getAero_wings() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">No Micro Repair Bots</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getAero_wings() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Add Micro Repair Bots (+Re, -Sp)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");       
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Brake Thrusters</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"brake_thrusters\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getBrake_thrusters() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">No Brake Thrusters</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getBrake_thrusters() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Add Brake Thrusters (+Br, -Sp, -Ac)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");          
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Grip Gravitons</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"grip_gravitons\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getGrip_gravitons() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">No Grip Gravitons</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getGrip_gravitons() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Add Grip Gravitons (+Ac, +Tr, --Sp)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");         
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Power Steering</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"power_steering\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getPower_steering() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">No Power Steering</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getPower_steering() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Add Power Steering (+Tu, -Ac)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");        
          $gui_obj->addContent ("    <tr>\r\n");
          $gui_obj->addContent ("      <td>Weaponry *</td>\r\n");
          $gui_obj->addContent ("      <td><select name=\"weaponry\">\r\n");
          $gui_obj->addContent ("        <option value=\"0\"");
          if ($pod_obj->getWeaponry() == 0) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">No Weaponry</option>\r\n");
          $gui_obj->addContent ("        <option value=\"1\"");
          if ($pod_obj->getWeaponry() == 1) { $gui_obj->addContent (" selected"); }
          $gui_obj->addContent (">Add Weaponry (-Sp, -Ac, -Tu)</option>\r\n");
          $gui_obj->addContent ("      </select></td>\r\n");
          $gui_obj->addContent ("    </tr>");                 
          $gui_obj->addContent ("  </table>\r\n");
          $gui_obj->addContent ("  <p align=\"center\"><input type=\"Submit\" name=\"Submitted\" value=\"Apply Tweaks\">&nbsp;&nbsp;<input type=\"Submit\" name=\"Reset\" value=\"Default Tweaks\"></p>\r\n");
          $gui_obj->addContent ("  <input type=\"hidden\" name=\"Tweak\" value=\"1\">\r\n");
          $gui_obj->addContent ("  <input type=\"hidden\" name=\"pod_id\" value=\"".$pod_id."\">\r\n");
          $gui_obj->addContent ("</form>\r\n");   
          $gui_obj->addContent ("<p align=\"center\">* Reduces Repair of all other pods</p>\r\n");       
          $gui_obj->setTitle ("Tweak Pod");
          $gui_obj->outputGui ();
          exit();
        }        
      }
  		elseif (isset($Sell_pod))
  		{
  			if (isset($Submitted))
  			{					
  				$pod_obj = new Owned_pod ($pod_id);
  				$pod_type_obj = $pod_obj->getType();
  				$cost = $pod_type_obj->getCost();
  				$part_array = $pod_obj->listParts();
  				for ($i = 0; $i < sizeof ($part_array); $i++)
  				{
  					$part_obj = $part_array [$i];
  					$part_type_obj = $part_obj->getPart();
  					$cost += $part_type_obj->getCost();
  				}
  				$cost = (int)($cost * .75);
  				$team_obj->addCredits ($cost);
  				$gui_obj->addContent ("<p align=\"center\"><br>\"".$pod_obj->getName()."\" was sold for ".(number_format($cost))." credits</p>");
  				$pod_obj->delete();
  			}
  			else
  			{
  				$pod_obj = new Owned_pod ($pod_id);
  				$gui_obj->addContent ("<p><br>Are you sure you want to sell \"".$pod_obj->getName()."\"?</p>");
  				$gui_obj->addContent ("<p><a href=\"".$base_url."admin/modify_pods.php?Sell_pod=1&Submitted=1&pod_id=".$pod_id."\">Yes, I am sure</a></p>");					
  				$gui_obj->setTitle ("Modify Pods");
  				$gui_obj->outputGui ();
  				exit();
  			}
  		}
  		elseif (isset($Sell_mod))
  		{
  			if (isset($Submitted))
  			{					
  				$mod_obj = new Owned_part ($mod_id);
  				$mod_type_obj = $mod_obj->getPart();
  				$cost = $mod_type_obj->getCost();
  				$cost = (int)($cost * .75);
  				$team_obj->addCredits ($cost);
  				$gui_obj->addContent ("<p align=\"center\"><br>\"".$mod_type_obj->getName()."\" was sold for ".(number_format($cost))." credits</p>");
  				$mod_obj->delete();
  			}
  			else
  			{
  				$mod_obj = new Owned_part ($mod_id);
  				$mod_type_obj = $mod_obj->getPart();
  				$gui_obj->addContent ("<p><br>Are you sure you want to sell \"".$mod_type_obj->getName()."\"?</p>");
  				$gui_obj->addContent ("<p><a href=\"".$base_url."admin/modify_pods.php?Sell_mod=1&Submitted=1&mod_id=".$mod_id."\">Yes, I am sure</a></p>");					
  				$gui_obj->setTitle ("Modify Pod");
  				$gui_obj->outputGui ();
  				exit();
  			}
  		}
  		elseif (isset($Rename))
  		{
  			if (isset($Submited))
  			{
  				$pod_obj = new Owned_pod ($pod_id);
  				$pod_obj->setName ($pod_name);
  				$gui_obj->addContent ("<p align=\"center\"><br>Pod successfully renamed</p>");
  			}
  			else
  			{
  				$pod_obj = new Owned_pod ($pod_id);
  				$gui_obj->addContent ("<form action=\"".$PHP_SELF."\" method=\"POST\">\r\n");
  				$gui_obj->addContent ("<p align=\"center\"><br>New Pod Name<br><input type=\"text\" name=\"pod_name\" value=\"".stripslashes($pod_obj->getName())."\"><br>");
  				$gui_obj->addContent ("<input type=\"hidden\" name=\"Rename\" value=\"1\">\r\n");
  				$gui_obj->addContent ("<input type=\"hidden\" name=\"pod_id\" value=\"".$pod_id."\">\r\n");
  				$gui_obj->addContent ("<br><input type=\"Submit\" name=\"Submited\" value=\"Submit\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\">\r\n");
  				$gui_obj->addContent ("</p></form>\r\n");						
  				$gui_obj->setTitle ("Modify Pods");
  				$gui_obj->outputGui ();
  				exit();
  			}
  		}			
  		$gui_obj->addContent ("<h2 align=\"center\">Team Pods</h2>");
  		$pods_array = $team_obj->listPods();
  		if (sizeof ($pods_array) <= 0) { 
  			$gui_obj->addContent ("<p>Your team does not yet own any pods. Visit the <a href=\"".$base_url."junkyard.php\">Junkyard</a> to purchase a pod.</p>"); 
  		}
  		else
  		{
  			for ($j = 0; $j < sizeof ($pods_array); $j++)
  			{
  				$pod_obj = $pods_array [$j];
  				$gui_obj->addContent ("<p><font size=\"+1\"><b><a href=\"".$base_url."list_active.php?View_pod=1&pod_id=".$pod_obj->getID()."\">".$pod_obj->getName()."</a></b></font>\r\n");
          if ($team_member_obj->isLeader())
          {
            $gui_obj->addContent ("<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<a href=\"".$base_url."admin/modify_pods.php?Tweak=1&pod_id=".$pod_obj->getID()."\">Tweak</a>] [<a href=\"".$base_url."admin/modify_pods.php?Rename=1&pod_id=".$pod_obj->getID()."\">Rename</a>] [<a href=\"".$base_url."admin/modify_pods.php?Sell_pod=1&pod_id=".$pod_obj->getID()."\">Sell</a>]\r\n");
  				}
          $mods_array = $pod_obj->listParts();
  				if (sizeof ($mods_array) > 0) { 
            $gui_obj->addContent ("<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Modifications");
           for ($k = 0; $k < sizeof ($mods_array); $k++)
  					{
  						$mod_obj = $mods_array [$k];
  						$mod_type_obj = $mod_obj->getPart();
  						$gui_obj->addContent ("<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"".$base_url."junkyard.php?View_mod=1&mod_id=".$mod_type_obj->getID()."\">".$mod_type_obj->getName()."</a>");
              if ($team_member_obj->isLeader())
              {
                $gui_obj->addContent (" [<a href=\"".$base_url."admin/modify_pods.php?Sell_mod=1&mod_id=".$mod_obj->getID()."\">Remove</a>]");
              }
              $gui_obj->addContent ("<br>");
  						unset ($mod_type_obj);
  						unset ($mod_obj);
  					}
  				}
          $gui_obj->addContent ("</p>\r\n");
  				unset ($pod_obj);
  			}
        $gui_obj->addContent ("<p align=\"center\"><a href=\"".$base_url."junkyard.php\">Visit the Junkyard</a> | <a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
  		}		
    	$gui_obj->setTitle ("Modify Pods");
    	$gui_obj->outputGui ();
		} 
		else 
		{
			die(login_failed());
		}
	}
?>