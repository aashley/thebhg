<?php
	
	include ("../setup.php");
	$gui_obj->setTitle("Race Registration Admin");
	
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
					$part_obj = $podracer_obj->createRace_registration($race, $pod);
					$gui_obj->addContent("Race Registration created<br><a href=\"race_registrations.php?type=1\">Create Another Race Registration</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");
					$gui_obj->addContent("Race: <select name=\"race\">");
					$races_array = $podracer_obj->listRaces();
					for ($k = 0; $k < sizeof ($races_array); $k++)
					{
						$race_list_obj = $races_array [$k];
						$gui_obj->addContent("<option value=\"".$race_list_obj->getID()."\">".$race_list_obj->getName()."</option>");
						unset ($race_list_obj);
					}					
					$gui_obj->addContent("</select><br>");
					$gui_obj->addContent("Pod: <select name=\"pod\">");
					$pod_array = $podracer_obj->listOwned_pods();
					for ($k = 0; $k < sizeof ($pod_array); $k++)
					{
						$pod_list_obj = $pod_array [$k];
						$gui_obj->addContent("<option value=\"".$pod_list_obj->getID()."\">".$pod_list_obj->getName()."</option>");
						unset ($pod_list_obj);
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
						$race_obj = new Race_registration ($selected);						
						$race_obj->setRace($race);
						$race_obj->setPod($pod);
						$gui_obj->addContent("Race Registration edited<br><a href=\"race_registrations.php?type=2\">Edit Another Race Registration</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$race_obj = new Race_registration ($selected);
						$pod_obj = $race_obj->getPod();
						$race_type_obj = $race_obj->getRace();
						$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");
						$gui_obj->addContent("Race: <select name=\"race\">");
						$race_array = $podracer_obj->listRaces();
						for ($k = 0; $k < sizeof ($race_array); $k++)
						{
							$race_list_obj = $race_array [$k];
							$gui_obj->addContent("<option value=\"".$race_list_obj->getID()."\"");
							if ($race_list_obj->getID() == $race_obj->getID())
							{
								$gui_obj->addContent("selected");
							}
							$gui_obj->addContent(">".$race_list_obj->getName()."</option>");
							unset ($race_list_obj);
						}					
						$gui_obj->addContent("</select><br>");
						$gui_obj->addContent("Pod: <select name=\"pod\">");
						$pod_array = $podracer_obj->listOwned_pods();
						for ($k = 0; $k < sizeof ($pod_array); $k++)
						{
							$pod_list_obj = $pod_array [$k];
							$gui_obj->addContent("<option value=\"".$pod_list_obj->getID()."\"");
							if ($pod_list_obj->getID() == $pod_obj->getID())
							{
								$gui_obj->addContent("selected");
							}
							$gui_obj->addContent(">".$pod_list_obj->getName()."</option>");
							unset ($pod_list_obj);
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
					$race_obj = new Race_registration ($selected);
					$race_obj->delete();
					$gui_obj->addContent("Race Registration deleted<br><a href=\"race_registrations.php?type=3\">Delete Another Race Registration</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");	
				$gui_obj->addContent("<select name=\"selected\">\r\n");
				$races_array = $podracer_obj->listRace_registrations(1);
				for ($i = 0; $i < sizeof ($races_array); $i++)
				{
					$race_obj = $races_array [$i];
					$pod_obj = $race_obj->getPod();
					$race_type_obj = $race_obj->getRace();
					$gui_obj->addContent("<option value=\"".$race_obj->getID()."\">Race: ".$race_type_obj->getName()." | Pod: ".$pod_obj->getName()."</option>\r\n");
					unset($race_obj);
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