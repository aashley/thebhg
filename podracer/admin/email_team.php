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
			if (isset($Submit))
			{
				$team_member_roster_obj = $team_member_obj->getBhg_id();
				$member_array = $team_obj->listMembersRoster();
				for ($i = 0; $i < sizeof ($member_array); $i++)
				{
					$member_obj = $member_array [$i];
					if ($member_obj->getEmail() != $team_member_roster_obj->getEmail())
					{
						$email_array [$i] = $member_obj->getEmail();
					}
					unset ($member_obj);
				}
				$email_list = join (", ", $email_array);
				$email_headers = "<<<EOH
				X-Sender: ".$team_member_roster_obj->getName()." <".$team_member_roster_obj->getEmail().">
				Return-Path: ".$team_member_roster_obj->getName()." <".$team_member_roster_obj->getEmail().">
				From: ".$team_member_roster_obj->getName()." <".$team_member_roster_obj->getEmail().">
				Reply-To: ".$team_member_roster_obj->getEmail()."
				X-Mailer: PHP
				EOH";
				mail ($email_list, $subject, $body, $headers);
				$gui_obj->addContent ("<p align=\"center\"><br>Email sent</p>");
				$gui_obj->addContent ("<p align=\"center\"><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
			}
			else
			{
				$gui_obj->addContent ("<h2 align=\"center\">Email Team Members</h2>\r\n");
				$gui_obj->addContent ("<form action=\"".$PHP_SELF."\" method=\"GET\">\r\n");
				$gui_obj->addContent ("<table>");
				$gui_obj->addContent ("<tr><td>Subject</td><td><input type=\"text\" name=\"subject\"></td><tr>");
				$gui_obj->addContent ("<tr><td>Message</td><td><textarea name=\"body\" rows=\"9\" cols=\"50\"></textarea></td><tr>\r\n");
				$gui_obj->addContent ("</table>");
				$gui_obj->addContent ("<p align=\"center\"><input type=\"Submit\" name=\"Submit\" value=\"Send Email\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\"></p>\r\n");
				$gui_obj->addContent ("</form>\r\n");
			}
			$gui_obj->setTitle ("Email Team Members");
			$gui_obj->outputGui ();
		} 
		else 
		{
			die(login_failed());
		}
	}
?>