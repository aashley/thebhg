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
					$creds = eregi_replace (",", "", $creds);
					if (($creds <= $team_obj->getCredits()) && ($creds > 0))
					{
						$team_obj->removeCredits ($creds);
						$person_obj = new Person ($member);
						$person_obj->makeSale ($creds, $coder_id);
						$dist_team_member_obj = $podracer_obj->findTeam_member ($member);
						$dist_team_member_obj->addRecieved ($creds);
						$gui_obj->addContent ("<p align=\"center\"><br>".number_format($creds)." credits successfully distributed to ".$person_obj->getName()."</p>");
						$gui_obj->addContent ("<p align=\"center\"><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
					}
					else
					{
						$gui_obj->addContent ("<p align=\"center\"><br>Uou do not have enough credits to distribute</p");
					}
				}
				else
				{
					$gui_obj->addContent ("<h2 align=\"center\">Distribute Credits</h2>");
					$gui_obj->addContent ("<form action=\"".$PHP_SELF."\" method=\"GET\">\r\n");
					$gui_obj->addContent ("<table align=\"center\">");
					$gui_obj->addContent ("<tr><td>Available</td><td>".number_format($team_obj->getCredits())." Credits</td><tr>");
					$gui_obj->addContent ("<tr><td>Member</td><td><select name=\"member\">\r\n");					
					$members_array = $team_obj->listMembersRoster();
					for ($i = 0; $i < sizeof ($members_array); $i++)
					{
						$person_obj = $members_array [$i];
						$gui_obj->addContent ("<option value=\"".$person_obj->getID()."\">".$person_obj->getName()."</option>\r\n");
						unset ($person_obj);
					}
					$gui_obj->addContent ("</select></td><tr>\r\n");
					$gui_obj->addContent ("<tr><td>Amount</td><td><input type=\"text\" name=\"creds\"></td><tr>\r\n");
					$gui_obj->addContent ("</table>");
					$gui_obj->addContent ("<p align=\"center\"><input type=\"Submit\" name=\"Submit\" value=\"Submit\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\"></p>\r\n");
					$gui_obj->addContent ("</form>\r\n");
				}
			}
			else
			{
				$gui_obj->addContent ("Only a team leader can distribute credits.");
			}
			$gui_obj->setTitle ("Distribute Credits");
			$gui_obj->outputGui ();
		} 
		else 
		{
			die(login_failed());
		}
	}
?>