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
			$exists_result = $db_obj->query ("SELECT COUNT(*) AS num FROM podracer_team_members WHERE bhg_id = ".$hunter_obj->getID());
			if (mysql_result ($exists_result, 0, "num") <= 0)
			{
				if (isset($Submit))
				{
					$team_obj = $podracer_obj->createTeam($team_name, 0, $hunter_obj->getID(), $slogan, $url);
					$team_member_obj = $podracer_obj->createTeam_member($hunter_obj->getID(), $team_obj->getID());
					$gui_obj->addContent ("<p>".stripslashes($team_name)." successfully created.</p>");
					$gui_obj->addContent ("<p><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
				}
				else
				{
					$gui_obj->addContent ("<form action=\"".$PHP_SELF."\" method=\"GET\">\r\n");
					$gui_obj->addContent ("<table>\r\n");
					$gui_obj->addContent ("<tr><td>Team name</td><td><input type=\"text\" name=\"team_name\"></td></tr>\r\n");
					$gui_obj->addContent ("<tr><td>Slogan</td><td><input type=\"text\" name=\"slogan\"></td></tr>\r\n");
					$gui_obj->addContent ("<tr><td>Website URL</td><td><input type=\"text\" name=\"url\"></td></tr>\r\n");
					$gui_obj->addContent ("</table>\r\n");
					$gui_obj->addContent ("<br><input type=\"Submit\" name=\"Submit\" value=\"Submit\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\">\r\n");
					$gui_obj->addContent ("</form>\r\n");
				}
			}
			else
			{
				$gui_obj->addContent ("Only a hunter who is not a member of a team can create his own team.");
			}
			$gui_obj->setTitle ("Create Team");
			$gui_obj->outputGui ();
		} 
		else 
		{
			die(login_failed());
		}
	}
?>