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
			if ($team_member_obj->isLeader())
			{
				$team_obj = $team_member_obj->getTeam();
				if (isset($Submit))
				{
					$race_obj = new Race ($race_id);	
					if ($race_obj->getPod_limit() <= sizeof($race_obj->listPods()))
					{
						$gui_obj->addContent ("This race has reached it's pod limit at ".$race_obj->getPod_limit()." pods.<br>");
					}
					elseif ($race_obj->getCost() > $team_obj->getCredits())
					{
						$gui_obj->addContent ($team_obj->getName()." does not have the ".number_format($race_obj->getCost())." credits needed to signup for this race.<br>");
					}
					else
					{	
						$pod_obj = new Owned_pod ($pod_id);
						$duplicate_result = $db_obj->query ("SELECT COUNT(*) AS num FROM podracer_race_registrations WHERE race = $race_id AND pod = $pod_id");
						if (mysql_result($duplicate_result, 0, "num") <= 0)
						{
							$team_obj->removeCredits ($race_obj->getCost());
							$registration_obj = $podracer_obj->createRace_registration ($race_id, $pod_id);
							$gui_obj->addContent ($team_obj->getName()." has registered \"".$pod_obj->getName()."\" for ".$race_obj->getName()." at a cost of ".number_format($race_obj->getCost())." credits.<br>");
						}
						else
						{
							$gui_obj->addContent ("\"".$pod_obj->getName()."\" has already be signed up for ".$race_obj->getName()."<br>");
						}
					}
					$gui_obj->addContent ("<p><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
				}
				else
				{
					$gui_obj->addContent ("<form action=\"".$PHP_SELF."\" method=\"GET\">\r\n");
					$gui_obj->addContent ("Select a race<br>");
					$gui_obj->addContent ("<select name=\"race_id\">\r\n");					
					$races_array = $podracer_obj->listUpcomingRaces();
					for ($j = 0; $j < sizeof ($races_array); $j++)
					{
						$race_obj = $races_array [$j];
						$gui_obj->addContent ("<option value=\"".$race_obj->getID()."\">".$race_obj->getName().", ".$race_obj->getPod_limit()." pod limit, ".number_format($race_obj->getCost())." credit buyin</option>");
						unset ($race_obj);
					}
					$gui_obj->addContent ("</select><br>");
					$gui_obj->addContent ("<br>Select a pod<br>");
					$pods_array = $team_obj->listPods();
					$gui_obj->addContent ("<select name=\"pod_id\">\r\n");
					for ($i = 0; $i < sizeof ($pods_array); $i++)
					{
						$pod_obj = $pods_array [$i];
						$gui_obj->addContent ("<option value=\"".$pod_obj->getID()."\">".$pod_obj->getName()."</option>");
						unset ($pod_obj);
					}
					$gui_obj->addContent ("</select><p><input type=\"Submit\" name=\"Submit\" value=\"Submit\"></p>\r\n");
					$gui_obj->addContent ("</form>\r\n");
				}
			}
			else
			{
				$gui_obj->addContent ("Only a team leader can sign a team up for a race.");
			}
			$gui_obj->setTitle ("Signup for a race");
			$gui_obj->outputGui ();
		} 
		else 
		{
			die(login_failed());
		}
	}
?>