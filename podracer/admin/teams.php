<?php
	
	include ("../setup.php");
	$gui_obj->setTitle("Team Admin");
	
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
					$part_obj = $podracer_obj->createTeam($name, $credits, $leader);
					$gui_obj->addContent("Team created<br><a href=\"teams.php?type=1\">Create Another Team</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");
					$gui_obj->addContent("Name: <input type=\"text\" name=\"name\"><br>");
					$gui_obj->addContent("Credits: <input type=\"text\" name=\"credits\"><br>");
					$gui_obj->addContent("Leader: <input type=\"text\" name=\"leader\"><br>");
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
						$team_obj = new Team ($selected);
						$team_obj->setName($name);
						$team_obj->setCredits($credits);
						$team_obj->setLeader($leader);
						$gui_obj->addContent("Team edited<br><a href=\"teams.php?type=2\">Edit Another Team</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$team_obj = new Team ($selected);
						$leader_obj = $team_obj->getLeader();
						$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");
						$gui_obj->addContent("Name: <input type=\"text\" name=\"name\" value=\"".$team_obj->getName()."\"><br>");
						$gui_obj->addContent("Credits: <input type=\"text\" name=\"credits\" value=\"".$team_obj->getCredits()."\"><br>");
						$gui_obj->addContent("Leader: <input type=\"text\" name=\"leader\" value=\"".$leader_obj->getID()."\"><br>");
						$gui_obj->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui_obj->addContent("<input type=\"hidden\" name=\"type\" value=\"$type\">\r\n");
						$gui_obj->addContent("<input type=\"hidden\" name=\"selected\" value=\"$selected\">\r\n");
						$gui_obj->addContent("</form>\r\n");
					}
				}
				elseif ($type == 3)
				{
					$team_obj = new Team ($selected);
					$team_obj->delete();
					$gui_obj->addContent("Team deleted<br><a href=\"teams.php?type=3\">Delete Another Team</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");	
				$gui_obj->addContent("<select name=\"selected\">\r\n");
				$teams_array = $podracer_obj->listTeams();
				for ($i = 0; $i < sizeof ($teams_array); $i++)
				{
					$team_obj = $teams_array [$i];
					$gui_obj->addContent("<option value=\"".$team_obj->getID()."\">".$team_obj->getName()."</option>\r\n");
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