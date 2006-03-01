<?php
	
	include "../header.php";
	$gui->setTitle("Race Registration Admin");

	$hunter = new Login_HTTP($coder_id);
		if (in_array($hunter->getID(), $admin))
		{
			if ($_REQUEST['type'] == 1)
			{
				if (isset($_REQUEST['Submit']))
				{
					$part = $podracer->createRaceRegistration($_REQUEST['race'], $_REQUEST['pod']);
					$gui->addContent("Race Registration created<br><a href=\"race_registrations.php?type=1\">Create Another Race Registration</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
					$gui->addContent("Race: <select name=\"race\">");
					$races_array = $podracer->listRaces();
					for ($k = 0; $k < sizeof ($races_array); $k++)
					{
						$race_list = $races_array [$k];
						$gui->addContent("<option value=\"".$race_list->getID()."\">".$race_list->getName()."</option>");
						unset ($race_list);
					}					
					$gui->addContent("</select><br>");
					$gui->addContent("Pod: <select name=\"pod\">");
					$pod_array = $podracer->listOwnedPods();
					for ($k = 0; $k < sizeof ($pod_array); $k++)
					{
						$pod_list = $pod_array [$k];
						$gui->addContent("<option value=\"".$pod_list->getID()."\">".$pod_list->getName()."</option>");
						unset ($pod_list);
					}					
					$gui->addContent("</select><br>");
					$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
					$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
					$gui->addContent("</form>\r\n");
				}
			}
			elseif (isset($_REQUEST['selected']))
			{
				if ($_REQUEST['type'] == 2)
				{
					if (isset($_REQUEST['Submit']))
					{
						$race = new RaceRegistration ($_REQUEST['selected']);						
						$race->setRace($_REQUEST['race']);
						$race->setPod($_REQUEST['pod']);
						$gui->addContent("Race Registration edited<br><a href=\"race_registrations.php?type=2\">Edit Another Race Registration</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$race = new RaceRegistration ($_REQUEST['selected']);
						$pod = $race->getPod();
						$race_type = $race->getRace();
						$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
						$gui->addContent("Race: <select name=\"race\">");
						$race_array = $podracer->listRaces();
						for ($k = 0; $k < sizeof ($race_array); $k++)
						{
							$race_list = $race_array [$k];
							$gui->addContent("<option value=\"".$race_list->getID()."\"");
							if ($race_list->getID() == $race_type->getID())
							{
								$gui->addContent("selected");
							}
							if (!$race_list->GetHasRun()){
								$gui->addContent(">".$race_list->getName()."</option>");
							}
							unset ($race_list);
						}					
						$gui->addContent("</select><br>");
						$gui->addContent("Pod: <select name=\"pod\">");
						$pod_array = $podracer->listOwnedpods();
						for ($k = 0; $k < sizeof ($pod_array); $k++)
						{
							$pod_list = $pod_array [$k];
							$gui->addContent("<option value=\"".$pod_list->getID()."\"");
							if ($pod_list->getID() == $pod->getID())
							{
								$gui->addContent("selected");
							}
							$gui->addContent(">".$pod_list->getName()."</option>");
							unset ($pod_list);
						}					
						$gui->addContent("</select><br>");
						$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"selected\" value=\"".$_REQUEST['selected']."\">\r\n");
						$gui->addContent("</form>\r\n");
					}
				}
				elseif ($_REQUEST['type'] == 3)
				{
					$race = new RaceRegistration ($_REQUEST['selected']);
					$race->delete();
					$gui->addContent("Race Registration deleted<br><a href=\"race_registrations.php?type=3\">Delete Another Race Registration</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");	
				$gui->addContent("<select name=\"selected\">\r\n");
				$races_array = $podracer->listRaceRegistrations(1);
				for ($i = 0; $i < sizeof ($races_array); $i++)
				{
					$race = $races_array [$i];
					$pod = $race->getPod();
					$race_type = $race->getRace();
					$gui->addContent("<option value=\"".$race->getID()."\">Race: ".$race_type->getName()." | Pod: ".$pod->getName()."</option>\r\n");
					unset($race);
				}		
				$gui->addContent("</select>\r\n");
				$gui->addContent("<input type=\"Submit\" name=\"Select\" value=\"Select\">");
				$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
				$gui->addContent("</form>\r\n");
			}				
			$gui->outputGui();
		} 
		else 
		{
			die(login_failed());
		}
?>