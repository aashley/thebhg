<?php

	include "setup.php";
	
	if (isset($Purchase))
	{
		if (!isset($PHP_AUTH_USER)) 
			die(login_failed());
		else 
		{  
			$hunter_obj = new Login ($PHP_AUTH_USER, $PHP_AUTH_PW, $coder_id);
			if ($hunter_obj->IsValid())
			{
				$team_member_obj = $podracer_obj->findTeam_member ($hunter_obj->getID());
				if ($team_member_obj->isLeader())
				{
					$team_obj = $team_member_obj->getTeam();
					if ((isset($pod_id)) && (!isset($mod_id)))
					{
						$pod_obj = new Pod ($pod_id);
						if (isset($Submit))
						{
							$team_obj->removeCredits ($pod_obj->getCost());
							$podracer_obj->createOwned_pod ($pod_obj->getID(), $team_obj->getID(), $pod_name);
							$gui_obj->addContent ("Pod, named \"".$pod_name."\", successfully purchased.");
						}
						else
						{
							if ($pod_obj->getCost() <= $team_obj->getCredits())
							{
								$gui_obj->addContent ("<form action=\"".$PHP_SELF."\" method=\"GET\">\r\n");
								$gui_obj->addContent ("Name: <input type=\"text\" name=\"pod_name\">\r\n");
								$gui_obj->addContent ("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
								$gui_obj->addContent ("<input type=\"hidden\" name=\"Purchase\" value=\"1\">\r\n");
								$gui_obj->addContent ("<input type=\"hidden\" name=\"pod_id\" value=\"".$pod_id."\">\r\n");
								$gui_obj->addContent ("</form>\r\n");
							}
							else
								$gui_obj->addContent ("You do not have enough credits to purchase that pod.");
						}
					}
					elseif (isset($mod_id))
					{
						$mod_obj = new Part ($mod_id);
						if (isset($Submit))
						{
							$pod_obj = new Owned_pod ($pod_id);
							$mods_array = $pod_obj->listParts();
							foreach ($mods_array as $loop_mod_obj) 
							{
								$loop_mod_type_obj = $loop_mod_obj->getPart();
								if ($loop_mod_type_obj->getType() == $mod_obj->getType())
								{
									if ($mod_obj->getIncrease() > $loop_mod_type_obj->getIncrease())
									{
										$upgrade = 1;
										$already_mod_obj = $mods_array [$j];
									}
									elseif ($mod_obj->getIncrease() <= $loop_mod_type_obj->getIncrease())
										$already = 1;
								}
							}							
							if ($upgrade == 1)
							{
                                                                $already_mod_type_obj = $already_mod_type_obj->getPart();
								$creds = $already_mod_type_obj->getCost() * 0.75;
								$new_cost = $mod_obj->getCost() - $creds;
								$team_obj->removeCredits ($new_cost);
								$podracer_obj->createOwned_part ($mod_obj->getID(), $pod_obj->getID());
								$already_mod_obj->delete();
								$gui_obj->addContent ("Part successfully install on your pod (".$pod_obj->getName()."). You sold use your old ".$already_mod_type_obj->getName()." for ".number_format($creds)." credits, making the final cost of your new part, ".number_format($new_cost)." credits.");
							}
							elseif ($already == 1)
								$gui_obj->addContent ("You already own that part or a part that is of a higher value than the selected part.");
							else
							{
								$team_obj->removeCredits ($mod_obj->getCost());
								$podracer_obj->createOwned_part ($mod_obj->getID(), $pod_obj->getID());
								$gui_obj->addContent ("Part successfully install on your pod (".$pod_obj->getName().").");
							}
						}
						else
						{
							if ($mod_obj->getCost() <= $team_obj->getCredits())
							{
								$gui_obj->addContent ("<form action=\"".$PHP_SELF."\" method=\"GET\">\r\n");
								$gui_obj->addContent ("Pod: <select name=\"pod_id\">\r\n");
								$pods_array = $team_obj->listPods();
								foreach ($pods_array as $pod_obj)
								{							
									$race_array = $pod_obj->listRaces();
									$no_show = -1;
								//	for ($j = 0; $j < sizeof ($race_array); $j++)
								//	{
								//		$race_obj = $race_array [$j];
								//		if (($race_obj->getReg_date() <= time()) && ($race_obj->getDate() >= time()))
								//		{
								//			$no_show = 1;
								//		}
								//		unset ($race_obj);
								//	}
									//if ($no_show == -1)
									//{
										$gui_obj->addContent ("<option value=\"".$pod_obj->getID()."\">".$pod_obj->getName()."</option>\r\n");
								//	}
								}
								$gui_obj->addContent ("</select>\r\n");
								$gui_obj->addContent ("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
								$gui_obj->addContent ("<input type=\"hidden\" name=\"Purchase\" value=\"1\">\r\n");
								$gui_obj->addContent ("<input type=\"hidden\" name=\"mod_id\" value=\"".$mod_id."\">\r\n");
								$gui_obj->addContent ("</form>\r\n");
							}
							else
								$gui_obj->addContent ("You do not have enough credits to purchase that modifcation.");
						}
					}
				}
				else
					$gui_obj->addContent ("Only a team leader can purchase a pod or modification.");
			} 
			else 
				die(login_failed());
		}
	}
	elseif (isset($View_pod))
	{
		$pod_obj = new Pod ($pod_id);
		$gui_obj->addContent ("<table width=\"100%\"><tr><td align=\"left\"><font size=\"+1\"><b>".$pod_obj->getName()."</b></font></td></tr><tr><td align=\"right\"><b>[</b><a href=\"".$base_url."junkyard.php?Purchase=1&amp;pod_id=".$pod_obj->getID()."\">Purchase This Pod</a><b>]</b></td></tr></table>");
		$gui_obj->addContent ("<p>".convertURL($pod_obj->getDescription())."</p>");
		$gui_obj->addContent ("<table cellspacing=\"3\" cellpadding=\"3\">");
		$gui_obj->addContent ("<tr><td>Cost</td><td>".number_format($pod_obj->getCost())." ICs</td></tr>");
		$gui_obj->addContent ("<tr><td>Traction</td><td>".$pod_obj->getTraction()."</td></tr>");
		$gui_obj->addContent ("<tr><td>Turning</td><td>".$pod_obj->getTurning()."</td></tr>");
		$gui_obj->addContent ("<tr><td>Acceleration</td><td>".$pod_obj->getAcceleration()."</td></tr>");
		$gui_obj->addContent ("<tr><td>Top Speed</td><td>".$pod_obj->getTop_speed()."</td></tr>");
		$gui_obj->addContent ("<tr><td>Air Brake</td><td>".$pod_obj->getAir_brake()."</td></tr>");
		$gui_obj->addContent ("<tr><td>Cooling</td><td>".$pod_obj->getCooling()."</td></tr>");
		$gui_obj->addContent ("<tr><td>Repair</td><td>".$pod_obj->getRepair()."</td></tr>");
		$gui_obj->addContent ("</table>");
		$gui_obj->addContent ("<p><a href=\"".$base_url."junkyard.php\">Return to junkyard listings</a></p>");
	}
	elseif (isset($View_mod))
	{
		$mod_obj = new Part ($mod_id);
		$gui_obj->addContent ("<h3>".$mod_obj->getName()." [<a href=\"".$base_url."junkyard.php?Purchase=1&amp;mod_id=".$mod_obj->getID()."\">Purchase</a>]</h3>");
		$gui_obj->addContent ("<table>");
		$gui_obj->addContent ("<tr><td colspan=\"2\">".$mod_obj->getDescription()."</td></tr>");
		$gui_obj->addContent ("<tr><td>Cost</td><td>".number_format($mod_obj->getCost())." ICs</td></tr>");
		$gui_obj->addContent ("<tr><td colspan=\"2\">Increases ".$podracer_obj->rework_name($mod_obj->getType())." by ".$mod_obj->getIncrease()." points</td></tr>");
		$gui_obj->addContent ("</table>");
		$gui_obj->addContent ("<p><a href=\"".$PHP_SELF."\">Return to junkyard listings</a></p>");
	}
	else
	{	
		$gui_obj->addContent ("<h2 align=\"center\">Pods Types</h2>");
		$pods_array = $podracer_obj->listPods();
		foreach ($pods_array as $pod_obj)
			$gui_obj->addContent ("<a href=\"".$base_url."junkyard.php?View_pod=1&amp;pod_id=".$pod_obj->getID()."\">".$pod_obj->getName()."</a><br>");
		$gui_obj->addContent ("<h2 align=\"center\">Modification Parts</h2>");
		$mods_array = $podracer_obj->listParts();
		foreach ($mods_array as $mod_obj)
		{
			if ($mod_obj->getType() != $last_type)
				$gui_obj->addContent ("<h3>".$podracer_obj->rework_name($mod_obj->getType())."</h3>");
			$gui_obj->addContent ("+".$mod_obj->getIncrease()." - <a href=\"".$base_url."junkyard.php?View_mod=1&amp;mod_id=".$mod_obj->getID()."\">".$mod_obj->getName()."</a><br>");
			$last_type = $mod_obj->getType();
		}
	}	
	$gui_obj->setTitle ("Purchase modification");
	$gui_obj->outputGui ();
?>
