<?php
	
	include ("../setup.php");
	$gui_obj->setTitle("Team Member Admin");
	
	if (!isset($PHP_AUTH_USER)) 
	{
		die(login_failed());
	} 
	else 
	{
		//Login object from the BHG roster
		$hunter_obj = new Login ($PHP_AUTH_USER, $PHP_AUTH_PW, $coder_id); //Coder id needed?
		if (($hunter_obj->IsValid()) && ($hunter_obj->getID() == 230))
		{
			if ($type == 1)
			{
				if (isset($Submit))
				{
					$part_obj = $podracer_obj->createTeam_member($bhg_id, $team);
					$gui_obj->addContent("Team Member created<br><a href=\"team_members.php?type=1\">Create Another Team Member</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");
					$gui_obj->addContent("BHG ID: <input type=\"text\" name=\"bhg_id\"><br>");					
					$gui_obj->addContent("Team: <select name=\"team\">");
					$team_array = $podracer_obj->listTeams();
					for ($k = 0; $k < sizeof ($team_array); $k++)
					{
						$team_obj = $team_array [$k];
						$gui_obj->addContent("<option value=\"".$team_obj->getID()."\">".$team_obj->getName()."</option>");
						unset ($team_obj);
					}					
					$gui_obj->addContent("</select><br>");
					$gui_obj->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
					$gui_obj->addContent("<input type=\"hidden\" name=\"type\" value=\"$type\">\r\n");
					$gui_obj->addContent("</form>\r\n");
				}
			}
			elseif (isset($selected))
			{
				if ($type == 2)
				{
					if (isset($Submit))
					{
						$team_obj = new Team_member ($selected);
						$team_obj->setBhg_id($bhg_id);
						$team_obj->setTeam($team);
						$gui_obj->addContent("Team Member edited<br><a href=\"team_members.php?type=2\">Edit Another Team Member</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$team_obj = new Team_member ($selected);
						$team_id_obj = $team_obj->getTeam();
						$person_obj = $team_obj->getBhg_id();
						$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");
						$gui_obj->addContent("BHG ID: <input type=\"text\" name=\"bhg_id\" value=\"".$person_obj->getID()."\"><br>");
						$gui_obj->addContent("Team: <select name=\"team\">");
						$team_array = $podracer_obj->listTeams();
						for ($k = 0; $k < sizeof ($team_array); $k++)
						{
							$team_list_obj = $team_array [$k];
							$gui_obj->addContent("<option value=\"".$team_list_obj->getID()."\"");
							if ($team_id_obj->getID() == $team_list_obj->getID())
							{
								$gui_obj->addContent("selected");
							}
							$gui_obj->addContent(">".$team_list_obj->getName()."</option>");
							unset ($team_list_obj);
						}					
						$gui_obj->addContent("</select><br>");
						$gui_obj->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui_obj->addContent("<input type=\"hidden\" name=\"type\" value=\"$type\">\r\n");
						$gui_obj->addContent("<input type=\"hidden\" name=\"selected\" value=\"$selected\">\r\n");
						$gui_obj->addContent("</form>\r\n");
					}
				}
				elseif ($type == 3)
				{
					$team_obj = new Team_member ($selected);
					$team_obj->delete();
					$gui_obj->addContent("Team Member deleted<br><a href=\"team_members.php?type=3\">Delete Another Team Member</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");	
				$gui_obj->addContent("<select name=\"selected\">\r\n");
				$teams_array = $podracer_obj->listTeam_members();
				for ($i = 0; $i < sizeof ($teams_array); $i++)
				{
					$team_obj = $teams_array [$i];
					$person_obj = $team_obj->getBhg_id();
					$team_id_obj = $team_obj->getTeam();
					$gui_obj->addContent("<option value=\"".$team_obj->getID()."\">".$team_id_obj->getName()." - ".$person_obj->getName()."</option>\r\n");
					unset($team_obj);
				}		
				$gui_obj->addContent("</select>\r\n");
				$gui_obj->addContent("<input type=\"Submit\" name=\"Select\" value=\"Select\">");
				$gui_obj->addContent("<input type=\"hidden\" name=\"type\" value=\"$type\">\r\n");
				$gui_obj->addContent("</form>\r\n");
			}				
			$gui_obj->outputGui();
		} 
		else 
		{
			die(login_failed());
		}
	}
?>