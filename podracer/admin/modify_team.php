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
				if (isset($Submit_rename))
				{					
					if ($team_obj->getName() != stripslashes($team_name))
					{
						$gui_obj->addContent ("Team renamed from \"".$team_obj->getName()."\" to \"".stripslashes($team_name)."\".<br>");
						$team_obj->setName ($team_name);
					}					
					if ($team_obj->getSlogan() != stripslashes($team_slogan))
					{
						$gui_obj->addContent ("Slogan changed from \"".$team_obj->getSlogan()."\" to \"".stripslashes($team_slogan)."\".<br>");
						$team_obj->setSlogan ($team_slogan);
					}						
					if ($team_obj->getUrl() != $team_url)
					{
						$gui_obj->addContent ("Website URL changed from \"".$team_obj->getUrl()."\" to \"".$team_url."\".<br>");
						$team_obj->setUrl ($team_url);
					}					
					if ($file_pointer = @fopen($form_data, "r"))
					{
						$data = addslashes(fread($file_pointer, filesize($form_data)));
						$team_obj->setImage($data);
						$team_obj->setImage_type($form_data_type);
					}
				}
				$races_result = $db_obj->query ("SELECT id FROM podracer_races WHERE date >= ".time());
				$gui_obj->addContent ("<h2 align=\"center\">Modfiy Team</h2>");
				$gui_obj->addContent ("<form action=\"".$PHP_SELF."\" method=\"POST\" enctype=\"multipart/form-data\">");
				$gui_obj->addContent ("<table align=\"center\">");
				$gui_obj->addContent ("<tr><td>Team Name:</td><td><input type=\"text\" name=\"team_name\" value=\"".stripslashes($team_obj->getName())."\" size=\"".(strlen($team_obj->getName()) + 5)."\"></td></tr>");
				$gui_obj->addContent ("<tr><td>Team Slogan:</td><td><input type=\"text\" name=\"team_slogan\" value=\"".stripslashes($team_obj->getSlogan())."\" size=\"".(strlen($team_obj->getSlogan()) + 5)."\"></td></tr>");
				$gui_obj->addContent ("<tr><td>Team Website:</td><td><input type=\"text\" name=\"team_url\" value=\"".$team_obj->getUrl()."\" size=\"".(strlen($team_obj->getUrl()) + 5)."\"></td></tr>");
				if (strlen($team_obj->getImage_type()) > 0)
        {
          $gui_obj->addContent ("<tr><td>Current Logo:</td><td><img src=\"".$base_url."list_active.php?team_image=".$team_obj->getID()."\" width=\"50px\" height=\"50px\"></td></tr>");
				}
        $gui_obj->addContent ("<tr><td>New Logo:</td><td><input type=\"file\" name=\"form_data\"></td></tr>");
				$gui_obj->addContent ("</table>");				
				$gui_obj->addContent ("<p align=\"center\"><input type=\"Submit\" name=\"Submit_rename\" value=\"Save Changes\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\"></p>");
				$gui_obj->addContent ("</form>\r\n");
				$gui_obj->addContent ("<p align=\"center\"><a href=\"".$base_url."admin/index.php\">Return to admin</a></p><br>");					
			}
			else
			{
				$gui_obj->addContent ("Only a team leader can modify a team.");
			}
			$gui_obj->setTitle ("Modify Team");
			$gui_obj->outputGui ();
		} 
		else 
		{
			die(login_failed());
		}
	}
?>