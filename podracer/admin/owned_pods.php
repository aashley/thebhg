<?php
	
	include ("../setup.php");
	$gui_obj->setTitle("Owned Pod Admin");
	
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
					$part_obj = $podracer_obj->createOwned_Pod ($pod_type, $team, $name);
					$gui_obj->addContent("Owned Pod created<br><a href=\"owned_pods.php?type=1\">Create Another Owned Pod</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");
					$gui_obj->addContent("Type: <select name=\"pod_type\">");
					$pod_array = $podracer_obj->listPods();
					for ($k = 0; $k < sizeof ($pod_array); $k++)
					{
						$pod_list_obj = $pod_array [$k];
						$gui_obj->addContent("<option value=\"".$pod_list_obj->getID()."\">".$pod_list_obj->getName()."</option>");
						unset ($pod_list_obj);
					}					
					$gui_obj->addContent("</select><br>");
					$gui_obj->addContent("Team: <select name=\"team\">");
					$team_array = $podracer_obj->listTeams();
					for ($k = 0; $k < sizeof ($team_array); $k++)
					{
						$team_list_obj = $team_array [$k];
						$gui_obj->addContent("<option value=\"".$team_list_obj->getID()."\">".$team_list_obj->getName()."</option>");
						unset ($team_list_obj);
					}					
					$gui_obj->addContent("</select><br>");
					$gui_obj->addContent("Name: <input type=\"text\" name=\"name\"><br>");
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
						$pod_obj = new Owned_pod ($selected);
						$pod_obj->setType($pod_type);
						$pod_obj->setTeam($team);
						$pod_obj->setName($name);
						$gui_obj->addContent("Owned Pod edited<br><a href=\"owned_pods.php?type=2\">Edit Another Owned Pod</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$pod_obj = new Owned_pod ($selected);
						$pod_type_obj = $pod_obj->getType();
						$team_obj = $pod_obj->getTeam();
						$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");						
						$gui_obj->addContent("Type: <select name=\"pod_type\">");
						$pod_array = $podracer_obj->listPods();
						for ($k = 0; $k < sizeof ($pod_array); $k++)
						{
							$pod_list_obj = $pod_array [$k];
							$gui_obj->addContent("<option value=\"".$pod_list_obj->getID()."\"");
							if ($pod_list_obj->getID() == $pod_type_obj->getID())
							{
								$gui_obj->addContent("selected");
							}
							$gui_obj->addContent(">".$pod_list_obj->getName()."</option>");
							unset ($pod_list_obj);
						}					
						$gui_obj->addContent("</select><br>");
						$gui_obj->addContent("Team: <select name=\"team\">");
						$team_array = $podracer_obj->listTeams();
						for ($k = 0; $k < sizeof ($team_array); $k++)
						{
							$team_list_obj = $team_array [$k];
							$gui_obj->addContent("<option value=\"".$team_list_obj->getID()."\"");
							if ($team_list_obj->getID() == $team_obj->getID())
							{
								$gui_obj->addContent("selected");
							}
							$gui_obj->addContent(">".$team_list_obj->getName()."</option>");
							unset ($pod_list_obj);
						}					
						$gui_obj->addContent("</select><br>");
						$gui_obj->addContent("Name: <input type=\"text\" name=\"name\" value=\"".$pod_obj->getName()."\"><br>");
						$gui_obj->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui_obj->addContent("<input type=\"hidden\" name=\"type\" value=\"$type\">\r\n");
						$gui_obj->addContent("<input type=\"hidden\" name=\"selected\" value=\"$selected\">\r\n");
						$gui_obj->addContent("</form>\r\n");
					}
				}
				elseif ($type == 3)
				{
					$pod_obj = new Owned_pod ($selected);
					$pod_obj->delete();
					$gui_obj->addContent("Owned Pod deleted<br><a href=\"owned_pods.php?type=3\">Delete Another Owned Pod</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");	
				$gui_obj->addContent("<select name=\"selected\">\r\n");
				$pods_array = $podracer_obj->listOwned_pods();
				for ($i = 0; $i < sizeof ($pods_array); $i++)
				{
					$pod_obj = $pods_array [$i];
					$owner_team_obj = $pod_obj->getTeam();
					$gui_obj->addContent("<option value=\"".$pod_obj->getID()."\">".$pod_obj->getName()." owned by ".$owner_team_obj->getName()."</option>\r\n");
					unset($owner_team_obj);
					unset($pod_obj);
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