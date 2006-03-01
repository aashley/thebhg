<?php

	include "../header.php";

	$hunter = new Login_HTTP($coder_id);
			$team_member = $podracer->findTeamMember ($hunter->getID());
			if ($team_member->isLeader())
			{
				$team = $team_member->getTeam();
				if (isset($Submit))
				{
					$race = new Race ($race_id);	
					if ($race->getPodlimit() <= sizeof($race->listPods()))
					{
						$gui->addContent ("This race has reached it's pod limit at ".$race->getPodlimit()." pods.<br>");
					}
					elseif ($race->getCost() > $team->getCredits())
					{
						$gui->addContent ($team->getName()." does not have the ".number_format($race->getCost())." credits needed to signup for this race.<br>");
					}
					else
					{	
						$pod = new Owned_pod ($pod_id);
						$duplicate_result = $db->query ("SELECT COUNT(*) AS num FROM podracer_race_registrations WHERE race = $race_id AND pod = $pod_id");
						if (mysql_result($duplicate_result, 0, "num") <= 0)
						{
							$team->removeCredits ($race->getCost());
							$registration = $podracer->createRaceregistration ($race_id, $pod_id);
							$gui->addContent ($team->getName()." has registered \"".$pod->getName()."\" for ".$race->getName()." at a cost of ".number_format($race->getCost())." credits.<br>");
						}
						else
						{
							$gui->addContent ("\"".$pod->getName()."\" has already be signed up for ".$race->getName()."<br>");
						}
					}
					$gui->addContent ("<p><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
				}
				else
				{
					$gui->addContent ("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"POST\">\r\n");
					$gui->addContent ("Select a race<br>");
					$gui->addContent ("<select name=\"race_id\">\r\n");					
					$races_array = $podracer->listUpcomingRaces();
					for ($j = 0; $j < sizeof ($races_array); $j++)
					{
						$race = $races_array [$j];
						$gui->addContent ("<option value=\"".$race->getID()."\">".$race->getName().", ".$race->getPodlimit()." pod limit, ".number_format($race->getCost())." credit buyin</option>");
						unset ($race);
					}
					$gui->addContent ("</select><br>");
					$gui->addContent ("<br>Select a pod<br>");
					$pods_array = $team->listPods();
					$gui->addContent ("<select name=\"pod_id\">\r\n");
					for ($i = 0; $i < sizeof ($pods_array); $i++)
					{
						$pod = $pods_array [$i];
						$gui->addContent ("<option value=\"".$pod->getID()."\">".$pod->getName()."</option>");
						unset ($pod);
					}
					$gui->addContent ("</select><p><input type=\"Submit\" name=\"Submit\" value=\"Submit\"></p>\r\n");
					$gui->addContent ("</form>\r\n");
				}
			}
			else
			{
				$gui->addContent ("Only a team leader can sign a team up for a race.");
			}
			$gui->setTitle ("Signup for a race");
			$gui->outputGui ();
?>