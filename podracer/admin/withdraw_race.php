<?php

	include_once '../header.php';

	$hunter = new Login_HTTP($coder_id);
	$team_member = $podracer->findTeamMember ($hunter->getID());
	if ($team_member->isLeader()) {
				$team = $team_member->getTeam();
				if (isset($_REQUEST['Submit']))
				{
					$registration = new Raceregistration ($_REQUEST['race_id']);
					$race = $registration->getRace();
					if ($race->writeRegdate() < time())
					{
						$gui->addContent ("The registration period for this race has ended, you can no longer withdraw.");
					}
					else
					{
						$creds = $race->getCost() * .75;
						$team->addCredits ($creds);
						$pod = $registration->getPod();
						$gui->addContent ("\"".$pod->getName()."\" has been withdrawn from ".$race->getName().", ".number_format($creds)." credits were returned to ".$team->getName()."'s account.");
						$registration->delete();
					}
					$gui->addContent ("<p><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
				}
				else
				{
					$gui->addContent ("Select a race");
					$gui->addContent ("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"GET\">\r\n<select name=\"race_id\">");
					$races_array = $team->listRaceregistrations(1);
					for ($i = 0; $i < sizeof ($races_array); $i++)
					{
						$race_reg = $races_array [$i];
						$race = $race_reg->getRace();
						$pod = $race_reg->getPod();
						$gui->addContent ("<option value=\"".$race_reg->getID()."\">\"".$pod->getName()."\" in ".$race->getName()."</option>\r\n");
						unset ($pod);
						unset ($race);
						unset ($race_reg);
					}
					$gui->addContent ("</select><p><input type=\"Submit\" name=\"Submit\" value=\"Submit\"></p>\r\n");
					$gui->addContent ("</form>\r\n");
				}
			}
			else
			{
				$gui->addContent ("Only a team leader can withdraw a team from a race.");
			}
			$gui->setTitle ("Withdraw from a race");
			$gui->outputGui ();
?>