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
					$registration_obj = new Race_registration ($race_id);
					$race_obj = $registration_obj->getRace();
					if ($race_obj->getReg_date() < time())
					{
						$gui_obj->addContent ("The registration period for this race has ended, you can no longer withdraw.");
					}
					else
					{
						$creds = $race_obj->getCost() * .75;
						$team_obj->addCredits ($creds);
						$pod_obj = $registration_obj->getPod();
						$gui_obj->addContent ("\"".$pod_obj->getName()."\" has been withdrawn from ".$race_obj->getName().", ".number_format($creds)." credits were returned to ".$team_obj->getName()."'s account.");
						$registration_obj->delete();
					}
					$gui_obj->addContent ("<p><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
				}
				else
				{
					$gui_obj->addContent ("Select a race");
					$gui_obj->addContent ("<form action=\"".$PHP_SELF."\" method=\"GET\">\r\n<select name=\"race_id\">");
					$races_array = $team_obj->listRace_registrations(1);
					for ($i = 0; $i < sizeof ($races_array); $i++)
					{
						$race_reg_obj = $races_array [$i];
						$race_obj = $race_reg_obj->getRace();
						$pod_obj = $race_reg_obj->getPod();
						$gui_obj->addContent ("<option value=\"".$race_reg_obj->getID()."\">\"".$pod_obj->getName()."\" in ".$race_obj->getName()."</option>\r\n");
						unset ($pod_obj);
						unset ($race_obj);
						unset ($race_reg_obj);
					}
					$gui_obj->addContent ("</select><p><input type=\"Submit\" name=\"Submit\" value=\"Submit\"></p>\r\n");
					$gui_obj->addContent ("</form>\r\n");
				}
			}
			else
			{
				$gui_obj->addContent ("Only a team leader can withdraw a team from a race.");
			}
			$gui_obj->setTitle ("Withdraw from a race");
			$gui_obj->outputGui ();
		} 
		else 
		{
			die(login_failed());
		}
	}
?>