<?php

	include "../header.php";

	$hunter = new Login_HTTP($coder_id);
	$team_member = $podracer->findTeamMember ($hunter->getID());
	$team = $team_member->getTeam();
      if (isset($_REQUEST['Tweak'])) {
        $pod = new Ownedpod ($_REQUEST['pod_id']);
        if (isset($_REQUEST['Submitted'])) {
          $pod->setWings ($_REQUEST['wings']);
          $pod->setGravboosters ($_REQUEST['grav_boosters']);
          $pod->setFuelmix ($_REQUEST['fuel_mix']);
          $pod->setFuelintake ($_REQUEST['fuel_intake']);
          $pod->setVent ($_REQUEST['vent']);
          $pod->setFastfuel ($_REQUEST['fast_fuel']);
          $pod->setPurifier ($_REQUEST['purifier']);
          $pod->setTurboboost ($_REQUEST['turbo_boost']);
          $pod->setSuspension ($_REQUEST['suspension']);
          $pod->setWeight ($_REQUEST['weight']);
          $pod->setBrakebalance ($_REQUEST['brake_balance']);
          $pod->setHoverheight ($_REQUEST['hover_height']);
          $pod->setRewire ($_REQUEST['rewire']);
          $pod->setTractioncontrol ($_REQUEST['traction_control']);
          $pod->setBypasssafeties ($_REQUEST['bypass_safeties']);
          $pod->setSnowhovers ($_REQUEST['snow_hovers']);
          $pod->setAntiobstacle ($_REQUEST['anti_obstacle']);
          $pod->setExhaustpipes ($_REQUEST['exhaust_pipes']);
          $pod->setAerowings ($_REQUEST['aero_wings']);
          $pod->setRepairbots ($_REQUEST['repair_bots']);
          $pod->setBrakethrusters ($_REQUEST['brake_thrusters']);
          $pod->setGripgravitons ($_REQUEST['grip_gravitons']);
          $pod->setWeaponry (0);
          $pod->setPowersteering ($_REQUEST['power_steering']);
          $gui->addContent ("<p align=\"center\"><br>\"".$pod->getName()."\" successfully tweaked</p>\r\n");
        } elseif (isset($_REQUEST['Reset'])) {
          $pod->setWings (0);
          $pod->setGravboosters (0);
          $pod->setFuelmix (0);
          $pod->setFuelintake (0);
          $pod->setVent (0);
          $pod->setFastfuel (0);
          $pod->setPurifier (0);
          $pod->setTurboboost (0);
          $pod->setSuspension (0);
          $pod->setWeight (0);
          $pod->setBrakebalance (0);
          $pod->setHoverheight (0);
          $pod->setRewire (0);
          $pod->setTractioncontrol (0);
          $pod->setBypasssafeties (0);
          $pod->setSnowhovers (0);
          $pod->setAntiobstacle (0);
          $pod->setExhaustpipes (0);
          $pod->setAerowings (0);
          $pod->setRepairbots (0);
          $pod->setBrakethrusters (0);
          $pod->setGripgravitons (0);
          $pod->setWeaponry (0);
          $pod->setPowersteering (0);
          $gui->addContent ("<p align=\"center\"><br>\"".$pod->getName()."\" tweaks successfully reset</p>\r\n");
        } else {
          $gui->addContent ("<h2 align=\"center\">Tweak Pod</h2>\r\n");          
          $gui->addContent ("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"POST\">\r\n");
          $gui->addContent ("  <table>\r\n");
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Wings</td>\r\n");
          $gui->addContent ("      <td><select name=\"wings\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getWings() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">No Wings</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getWings() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Use Wings (+Tr, +Tu, -Sp, -Ac)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");       
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Grav Boosters</td>\r\n");
          $gui->addContent ("      <td><select name=\"grav_boosters\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getGravboosters() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">No Boosters</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getGravboosters() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Boosters Lv1 (++Tr, -Sp, -Ac)</option>\r\n");
          $gui->addContent ("        <option value=\"2\"");
          if ($pod->getGravboosters() == 2) { $gui->addContent (" selected"); }
          $gui->addContent (">Boosters Lv2 (++Tr, -Sp, -Ac)</option>\r\n");
          $gui->addContent ("        <option value=\"3\"");
          if ($pod->getGravboosters() == 3) { $gui->addContent (" selected"); }
          $gui->addContent (">Boosters Lv3 (++Tr, -Sp, -Ac)</option>\r\n");
          $gui->addContent ("        <option value=\"4\"");
          if ($pod->getGravboosters() == 4) { $gui->addContent (" selected"); }
          $gui->addContent (">Boosters Lv4 (++Tr, -Sp, -Ac)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>"); 
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Fuel Mix</td>\r\n");
          $gui->addContent ("      <td><select name=\"fuel_mix\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getFuelmix() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">Normal Mix</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getFuelmix() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Speed Mix Lv1 (++Sp, --Re)</option>\r\n");
          $gui->addContent ("        <option value=\"2\"");
          if ($pod->getFuelmix() == 2) { $gui->addContent (" selected"); }
          $gui->addContent (">Speed Mix Lv2 (++Sp, --Re)</option>\r\n");
          $gui->addContent ("        <option value=\"3\"");
          if ($pod->getFuelmix() == 3) { $gui->addContent (" selected"); }
          $gui->addContent (">Speed Mix Lv3 (++Sp, --Re)</option>\r\n");
          $gui->addContent ("        <option value=\"4\"");
          if ($pod->getFuelmix() == 4) { $gui->addContent (" selected"); }
          $gui->addContent (">Speed Mix Lv4 (++Sp, --Re)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>"); 
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Fuel Intake</td>\r\n");
          $gui->addContent ("      <td><select name=\"fuel_intake\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getFuelintake() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">Default Intake</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getFuelintake() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Increased Intake Lv1 (++Sp, -Co, -Re)</option>\r\n");
          $gui->addContent ("        <option value=\"2\"");
          if ($pod->getFuelintake() == 2) { $gui->addContent (" selected"); }
          $gui->addContent (">Increased Intake Lv2 (++Sp, -Co, -Re)</option>\r\n");
          $gui->addContent ("        <option value=\"3\"");
          if ($pod->getFuelintake() == 3) { $gui->addContent (" selected"); }
          $gui->addContent (">Increased Intake Lv3 (++Sp, -Co, -Re)</option>\r\n");
          $gui->addContent ("        <option value=\"4\"");
          if ($pod->getFuelintake() == 4) { $gui->addContent (" selected"); }
          $gui->addContent (">Increased Intake Lv4 (++Sp, -Co, -Re)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");     
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Cooling Vent</td>\r\n");
          $gui->addContent ("      <td><select name=\"vent\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getVent() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">No Vent</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getVent() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Add Vent (+Co, -Sp)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");   
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Fast Fuel Injection</td>\r\n");
          $gui->addContent ("      <td><select name=\"fast_fuel\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getFastfuel() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">No Injection</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getFastfuel() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Add Injector (+Ac, -Co)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");     
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Fuel Purifier</td>\r\n");
          $gui->addContent ("      <td><select name=\"purifier\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getPurifier() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">No Purifier</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getPurifier() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Add Purifier (+Sp, +Ac, -Co, -Tu)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");      
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Turbo Boost</td>\r\n");
          $gui->addContent ("      <td><select name=\"turbo_boost\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getTurboboost() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">Defaul Boost</option>\r\n");
          $gui->addContent ("        <option value=\"-1\"");
          if ($pod->getTurboboost() == -1) { $gui->addContent (" selected"); }
          $gui->addContent (">Decrease Boost Lv1 (+Co, +Re, -Sp, -Ac)</option>\r\n");
          $gui->addContent ("        <option value=\"-2\"");
          if ($pod->getTurboboost() == -2) { $gui->addContent (" selected"); }
          $gui->addContent (">Decrease Boost Lv2 (+Co, +Re, -Sp, -Ac)</option>\r\n");
          $gui->addContent ("        <option value=\"-3\"");
          if ($pod->getTurboboost() == -3) { $gui->addContent (" selected"); }
          $gui->addContent (">Decrease Boost Lv3 (+Co, +Re, -Sp, -Ac)</option>\r\n");
          $gui->addContent ("        <option value=\"-4\"");
          if ($pod->getTurboboost() == -4) { $gui->addContent (" selected"); }
          $gui->addContent (">Decrease Boost Lv4 (+Co, +Re, -Sp, -Ac)</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getTurboboost() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Increase Boost Lv1 (+Sp, +Ac, -Co, -Re)</option>\r\n");
          $gui->addContent ("        <option value=\"2\"");
          if ($pod->getTurboboost() == 2) { $gui->addContent (" selected"); }
          $gui->addContent (">Increase Boost Lv2 (+Sp, +Ac, -Co, -Re)</option>\r\n");
          $gui->addContent ("        <option value=\"3\"");
          if ($pod->getTurboboost() == 3) { $gui->addContent (" selected"); }
          $gui->addContent (">Increase Boost Lv3 (+Sp, +Ac, -Co, -Re)</option>\r\n");
          $gui->addContent ("        <option value=\"4\"");
          if ($pod->getTurboboost() == 4) { $gui->addContent (" selected"); }
          $gui->addContent (">Increase Boost Lv4 (+Sp, +Ac, -Co, -Re)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");   
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Hovering Suspension</td>\r\n");
          $gui->addContent ("      <td><select name=\"suspension\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getSuspension() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">Default Suspension</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getSuspension() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Hard Suspension Lv1 (+Sp, -Re)</option>\r\n");
          $gui->addContent ("        <option value=\"2\"");
          if ($pod->getSuspension() == 2) { $gui->addContent (" selected"); }
          $gui->addContent (">Hard Suspension Lv2 (+Sp, -Re)</option>\r\n");
          $gui->addContent ("        <option value=\"3\"");
          if ($pod->getSuspension() == 3) { $gui->addContent (" selected"); }
          $gui->addContent (">Hard Suspension Lv3 (+Sp, -Re)</option>\r\n");
          $gui->addContent ("        <option value=\"4\"");
          if ($pod->getSuspension() == 4) { $gui->addContent (" selected"); }
          $gui->addContent (">Hard Suspension Lv4 (+Sp, -Re)</option>\r\n");
          $gui->addContent ("        <option value=\"-1\"");
          if ($pod->getSuspension() == -1) { $gui->addContent (" selected"); }
          $gui->addContent (">Soft  Suspension Lv1 (+Re, -Sp)</option>\r\n");
          $gui->addContent ("        <option value=\"-2\"");
          if ($pod->getSuspension() == -2) { $gui->addContent (" selected"); }
          $gui->addContent (">Soft Suspension Lv2 (+Re, -Sp)</option>\r\n");
          $gui->addContent ("        <option value=\"-3\"");
          if ($pod->getSuspension() == -3) { $gui->addContent (" selected"); }
          $gui->addContent (">Soft Suspension Lv3 (+Re, -Sp)</option>\r\n");
          $gui->addContent ("        <option value=\"-4\"");
          if ($pod->getSuspension() == -4) { $gui->addContent (" selected"); }
          $gui->addContent (">Soft Suspension Lv4 (+Re, -Sp)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");      
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Weight</td>\r\n");
          $gui->addContent ("      <td><select name=\"weight\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getWeight() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">Default Weight</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getWeight() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Make Heavier Lv1 (+Tr, +Tu, -Sp, -Ac)</option>\r\n");
          $gui->addContent ("        <option value=\"2\"");
          if ($pod->getWeight() == 2) { $gui->addContent (" selected"); }
          $gui->addContent (">Make Heavier Lv2 (+Tr, +Tu, -Sp, -Ac)</option>\r\n");
          $gui->addContent ("        <option value=\"3\"");
          if ($pod->getWeight() == 3) { $gui->addContent (" selected"); }
          $gui->addContent (">Make Heavier Lv3 (+Tr, +Tu, -Sp, -Ac)</option>\r\n");
          $gui->addContent ("        <option value=\"4\"");
          if ($pod->getWeight() == 4) { $gui->addContent (" selected"); }
          $gui->addContent (">Make Heavier Lv4 (+Tr, +Tu, -Sp, -Ac)</option>\r\n");
          $gui->addContent ("        <option value=\"-1\"");
          if ($pod->getWeight() == -1) { $gui->addContent (" selected"); }
          $gui->addContent (">Make Lighter Lv1 (+Sp, +Ac, -Tr, -Tu)</option>\r\n");
          $gui->addContent ("        <option value=\"-2\"");
          if ($pod->getWeight() == -2) { $gui->addContent (" selected"); }
          $gui->addContent (">Make Lighter Lv2 (+Sp, +Ac, -Tr, -Tu)</option>\r\n");
          $gui->addContent ("        <option value=\"-3\"");
          if ($pod->getWeight() == -3) { $gui->addContent (" selected"); }
          $gui->addContent (">Make Lighter Lv3 (+Sp, +Ac, -Tr, -Tu)</option>\r\n");
          $gui->addContent ("        <option value=\"-4\"");
          if ($pod->getWeight() == -4) { $gui->addContent (" selected"); }
          $gui->addContent (">Make Lighter Lv4 (+Sp, +Ac, -Tr, -Tu)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");        
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Brake Balance</td>\r\n");
          $gui->addContent ("      <td><select name=\"brake_balance\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getBrakebalance() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">Normal Balance</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getBrakebalance() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Front Balance Lv1 (+Sp, +Tr, --Tu)</option>\r\n");
          $gui->addContent ("        <option value=\"2\"");
          if ($pod->getBrakebalance() == 2) { $gui->addContent (" selected"); }
          $gui->addContent (">Front Balance Lv2 (+Sp, +Tr, --Tu)</option>\r\n");
          $gui->addContent ("        <option value=\"3\"");
          if ($pod->getBrakebalance() == 3) { $gui->addContent (" selected"); }
          $gui->addContent (">Front Balance Lv3 (+Sp, +Tr, --Tu)</option>\r\n");
          $gui->addContent ("        <option value=\"4\"");
          if ($pod->getBrakebalance() == 4) { $gui->addContent (" selected"); }
          $gui->addContent (">Front Balance Lv4 (+Sp, +Tr, --Tu)</option>\r\n");
          $gui->addContent ("        <option value=\"-1\"");
          if ($pod->getBrakebalance() == -1) { $gui->addContent (" selected"); }
          $gui->addContent (">Rear Balance Lv1 (+Ac, +Tu, --Tr)</option>\r\n");
          $gui->addContent ("        <option value=\"-2\"");
          if ($pod->getBrakebalance() == -2) { $gui->addContent (" selected"); }
          $gui->addContent (">Rear Balance Lv1 (+Ac, +Tu, --Tr)</option>\r\n");
          $gui->addContent ("        <option value=\"-3\"");
          if ($pod->getBrakebalance() == -3) { $gui->addContent (" selected"); }
          $gui->addContent (">Rear Balance Lv1 (+Ac, +Tu, --Tr)</option>\r\n");
          $gui->addContent ("        <option value=\"-4\"");
          if ($pod->getBrakebalance() == -4) { $gui->addContent (" selected"); }
          $gui->addContent (">Rear Balance Lv1 (+Ac, +Tu, --Tr)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");       
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Hover Height</td>\r\n");
          $gui->addContent ("      <td><select name=\"hover_height\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getHoverheight() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">Default Height</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getHoverheight() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Higher Lv1 (+Re, +Co, --Sp)</option>\r\n");
          $gui->addContent ("        <option value=\"2\"");
          if ($pod->getHoverheight() == 2) { $gui->addContent (" selected"); }
          $gui->addContent (">Higher Lv2 (+Re, +Co, --Sp)</option>\r\n");
          $gui->addContent ("        <option value=\"3\"");
          if ($pod->getHoverheight() == 3) { $gui->addContent (" selected"); }
          $gui->addContent (">Higher Lv3 (+Re, +Co, --Sp)</option>\r\n");
          $gui->addContent ("        <option value=\"4\"");
          if ($pod->getHoverheight() == 4) { $gui->addContent (" selected"); }
          $gui->addContent (">Higher Lv4 (+Re, +Co, --Sp)</option>\r\n");
          $gui->addContent ("        <option value=\"-1\"");
          if ($pod->getHoverheight() == -1) { $gui->addContent (" selected"); }
          $gui->addContent (">Lower Lv1 (++Sp, -Co, -Re)</option>\r\n");
          $gui->addContent ("        <option value=\"-2\"");
          if ($pod->getHoverheight() == -2) { $gui->addContent (" selected"); }
          $gui->addContent (">Lower Lv2 (++Sp, -Co, -Re)</option>\r\n");
          $gui->addContent ("        <option value=\"-3\"");
          if ($pod->getHoverheight() == -3) { $gui->addContent (" selected"); }
          $gui->addContent (">Lower Lv3 (++Sp, +-Co, -Re)</option>\r\n");
          $gui->addContent ("        <option value=\"-4\"");
          if ($pod->getHoverheight() == -4) { $gui->addContent (" selected"); }
          $gui->addContent (">Lower Lv4 (++Sp, +-Co, -Re)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>"); 
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Rewire</td>\r\n");
          $gui->addContent ("      <td><select name=\"rewire\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getRewire() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">No Rewiring</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getRewire() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Rewire for Speed (+Sp, +Ac, -Re, -Co)</option>\r\n");
          $gui->addContent ("        <option value=\"2\"");
          if ($pod->getRewire() == 2) { $gui->addContent (" selected"); }
          $gui->addContent (">Rewire for Cooling (+Co, +Re, -Sp, -Ac)</option>\r\n");
          $gui->addContent ("        <option value=\"3\"");
          if ($pod->getRewire() == 3) { $gui->addContent (" selected"); }
          $gui->addContent (">Rewire for Traction (+Tr, +Tu, -Sp, -Ac, -Co)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");      
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Traction Control</td>\r\n");
          $gui->addContent ("      <td><select name=\"traction_control\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getTractioncontrol() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">No Traction Control</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getTractioncontrol() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Add Traction Control (+Ac, -Tu)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");          
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Bypass Safeties</td>\r\n");
          $gui->addContent ("      <td><select name=\"bypass_safeties\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getBypasssafeties() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">Do not bypass</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getBypasssafeties() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Bypass (+Ac, +Sp, --Re)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");            
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Snow Hovers</td>\r\n");
          $gui->addContent ("      <td><select name=\"snow_hovers\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getSnowhovers() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">No Snow Hovers</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getSnowhovers() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Add Snow Hovers (+Tr, +Tu, -Sp)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");             
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Anti-Obstacle-Nav</td>\r\n");
          $gui->addContent ("      <td><select name=\"anti_obstacle\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getAntiobstacle() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">No Anti-Obstacle-Nav</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getAntiobstacle() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Add Anti-Obstacle-Nav (+Tu, -Sp)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");          
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Exhaust Pipes</td>\r\n");
          $gui->addContent ("      <td><select name=\"exhaust_pipes\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getExhaustpipes() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">No Exhaust Pipes</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getExhaustpipes() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Add Exhaust Pipes (+Sp, -Re, -Tr)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");      
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Aero-Wings</td>\r\n");
          $gui->addContent ("      <td><select name=\"aero_wings\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getAerowings() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">No Aero-Wings</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getAerowings() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Add Aero-Wings (+Tr, -Sp)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");      
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Micro Repair Bots</td>\r\n");
          $gui->addContent ("      <td><select name=\"repair_bots\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getAerowings() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">No Micro Repair Bots</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getAerowings() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Add Micro Repair Bots (+Re, -Sp)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");       
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Brake Thrusters</td>\r\n");
          $gui->addContent ("      <td><select name=\"brake_thrusters\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getBrakethrusters() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">No Brake Thrusters</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getBrakethrusters() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Add Brake Thrusters (+Br, -Sp, -Ac)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");          
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Grip Gravitons</td>\r\n");
          $gui->addContent ("      <td><select name=\"grip_gravitons\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getGripgravitons() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">No Grip Gravitons</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getGripgravitons() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Add Grip Gravitons (+Ac, +Tr, --Sp)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");         
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Power Steering</td>\r\n");
          $gui->addContent ("      <td><select name=\"power_steering\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getPowersteering() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">No Power Steering</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getPowersteering() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Add Power Steering (+Tu, -Ac)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");        
          $gui->addContent ("    <tr>\r\n");
          $gui->addContent ("      <td>Weaponry *</td>\r\n");
          $gui->addContent ("      <td><select name=\"weaponry\">\r\n");
          $gui->addContent ("        <option value=\"0\"");
          if ($pod->getWeaponry() == 0) { $gui->addContent (" selected"); }
          $gui->addContent (">No Weaponry</option>\r\n");
          $gui->addContent ("        <option value=\"1\"");
          if ($pod->getWeaponry() == 1) { $gui->addContent (" selected"); }
          $gui->addContent (">Add Weaponry (-Sp, -Ac, -Tu)</option>\r\n");
          $gui->addContent ("      </select></td>\r\n");
          $gui->addContent ("    </tr>");                 
          $gui->addContent ("  </table>\r\n");
          $gui->addContent ("  <p align=\"center\"><input type=\"Submit\" name=\"Submitted\" value=\"Apply Tweaks\">&nbsp;&nbsp;<input type=\"Submit\" name=\"Reset\" value=\"Default Tweaks\"></p>\r\n");
          $gui->addContent ("  <input type=\"hidden\" name=\"Tweak\" value=\"1\">\r\n");
          $gui->addContent ("  <input type=\"hidden\" name=\"pod_id\" value=\"".$_REQUEST['pod_id']."\">\r\n");
          $gui->addContent ("</form>\r\n");   
          $gui->addContent ("<p align=\"center\">* Randomly reduces stats of other pods. May cause a disqualification and heavy fine if Race Officials catch you with them.</p>\r\n");       
          $gui->setTitle ("Tweak Pod");
          $gui->outputGui ();
          exit();
        }        
      } elseif (isset($_REQUEST['Sell_pod'])) {
  			if (isset($_REQUEST['Submitted'])) {					
  				$pod = new OwnedPod ($_REQUEST['pod_id']);
  				$pod_type = $pod->getType();
  				$cost = $pod_type->getCost();
  				$part_array = $pod->listParts();
  				for ($i = 0; $i < sizeof ($part_array); $i++) {
  					$part = $part_array [$i];
  					$part_type = $part->getPart();
  					$cost += $part_type->getCost();
  					$part->delete();
  				}
  				$cost = (int)($cost * .75);
  				$team->addCredits ($cost);
  				$gui->addContent ("<p align=\"center\"><br>\"".$pod->getName()."\" was sold for ".(number_format($cost))." credits</p>");
  				$pod->delete();
  			} else {
  				$pod = new OwnedPod($_REQUEST['pod_id']);
  				$gui->addContent ("<p><br>Are you sure you want to sell \"".$pod->getName()."\"?</p>");
  				$gui->addContent ("<p><a href=\"".$base_url."admin/modify_pods.php?Sell_pod=1&Submitted=1&pod_id=".$_REQUEST['pod_id']."\">Yes, I am sure</a></p>");					
  				$gui->setTitle ("Modify Pods");
  				$gui->outputGui ();
  				exit();
  			}
  		} elseif (isset($_REQUEST['Sell_mod'])) {
  			if (isset($_REQUEST['Submitted'])) {					
  				$mod = new OwnedPart ($_REQUEST['mod_id']);
  				$mod_type = $mod->getPart();
  				$cost = $mod_type->getCost();
  				$cost = (int)($cost * .75);
  				$team->addCredits ($cost);
  				$gui->addContent ("<p align=\"center\"><br>\"".$mod_type->getName()."\" was sold for ".(number_format($cost))." credits</p>");
  				$mod->delete();
  			} else {
  				$mod = new OwnedPart ($_REQUEST['mod_id']);
  				$mod_type = $mod->getPart();
  				$gui->addContent ("<p><br>Are you sure you want to sell \"".$mod_type->getName()."\"?</p>");
  				$gui->addContent ("<p><a href=\"".$base_url."admin/modify_pods.php?Sell_mod=1&Submitted=1&mod_id=".$_REQUEST['mod_id']."\">Yes, I am sure</a></p>");					
  				$gui->setTitle ("Modify Pod");
  				$gui->outputGui ();
  				exit();
  			}
  		} elseif (isset($_REQUEST['Rename'])) {
  			if (isset($_REQUEST['Submited']))
  			{
  				$pod = new OwnedPod ($_REQUEST['pod_id']);
  				$pod->setName ($_REQUEST['pod_name']);
  				$pod->setTeam($_REQUEST['team']);
  				$gui->addContent ("<p align=\"center\"><br>Pod successfully edited</p>");
  			}
  			else
  			{
  				$pod = new OwnedPod ($_REQUEST['pod_id']);
  				$gui->addContent ("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"POST\">\r\n");
  				$gui->addContent ("<p align=\"center\"><br>New Pod Name<br><input type=\"text\" name=\"pod_name\" value=\"".stripslashes($pod->getName())."\"><br>");
  				$gui->addContent("Owning Team: <select name=\"team\">");
				$team_array = $podracer->listTeams();
				for ($k = 0; $k < sizeof ($team_array); $k++)
				{
					$team_list = $team_array [$k];
					$gui->addContent("<option value=\"".$team_list->getID()."\"");
					if ($team_list->getID() == $team->getID())
					{
						$gui->addContent("selected");
					}
					$gui->addContent(">".$team_list->getName()."</option>");
					unset ($pod_list);
				}					
				$gui->addContent("</select><br>");
  				$gui->addContent ("<input type=\"hidden\" name=\"Rename\" value=\"1\">\r\n");
  				$gui->addContent ("<input type=\"hidden\" name=\"pod_id\" value=\"".$_REQUEST['pod_id']."\">\r\n");
  				$gui->addContent ("<br><input type=\"Submit\" name=\"Submited\" value=\"Submit\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\">\r\n");
  				$gui->addContent ("</p></form>\r\n");						
  				$gui->setTitle ("Modify Pods");
  				$gui->outputGui ();
  				exit();
  			}
  		}			
  		$gui->addContent ("<h2 align=\"center\">Team Pods</h2>");
  		$pods_array = $team->listPods();
  		if (sizeof ($pods_array) <= 0) { 
  			$gui->addContent ("<p>Your team does not yet own any pods. Visit the <a href=\"".$base_url."junkyard.php\">Junkyard</a> to purchase a pod.</p>"); 
  		}
  		else
  		{
  			for ($j = 0; $j < sizeof ($pods_array); $j++)
  			{
  				$pod = $pods_array [$j];
  				$gui->addContent ("<p><font size=\"+1\"><b><a href=\"".$base_url."list_active.php?View_pod=1&pod_id=".$pod->getID()."\">".$pod->getName()."</a></b></font>\r\n");
          if ($team_member->isLeader())
          {
            $gui->addContent ("<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<a href=\"".$base_url."admin/modify_pods.php?Tweak=1&pod_id=".$pod->getID()."\">Tweak</a>] [<a href=\"".$base_url."admin/modify_pods.php?Rename=1&pod_id=".$pod->getID()."\">Edit</a>] [<a href=\"".$base_url."admin/modify_pods.php?Sell_pod=1&pod_id=".$pod->getID()."\">Sell</a>]\r\n");
  				}
          $mods_array = $pod->listParts();
  				if (sizeof ($mods_array) > 0) { 
            $gui->addContent ("<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Modifications");
           for ($k = 0; $k < sizeof ($mods_array); $k++)
  					{
  						$mod = $mods_array [$k];
  						$mod_type = $mod->getPart();
  						$gui->addContent ("<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"".$base_url."junkyard.php?View_mod=1&mod_id=".$mod_type->getID()."\">".$mod_type->getName()."</a>");
              if ($team_member->isLeader())
              {
                $gui->addContent (" [<a href=\"".$base_url."admin/modify_pods.php?Sell_mod=1&mod_id=".$mod->getID()."\">Remove</a>]");
              }
  						unset ($mod_type);
  						unset ($mod);
  					}
  				}
          $gui->addContent ("</p>\r\n");
  				unset ($pod);
  			}
        $gui->addContent ("<p align=\"center\"><a href=\"".$base_url."junkyard.php\">Visit the Junkyard</a> | <a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
  		}		
    	$gui->setTitle ("Modify Pods");
    	$gui->outputGui ();
?>