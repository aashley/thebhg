<?php
	
	include "../header.php";
	
	$gui->setTitle("Owned Pod Admin");

	$hunter = new Login_HTTP($coder_id);
		if (in_array($hunter->getID(), $admin))
		{
			if ($_REQUEST['type'] == 1)
			{
				if (isset($_REQUEST['Submit']))
				{
					$part = $podracer->createOwnedPod ($_REQUEST['pod_type'], $_REQUEST['team'], $_REQUEST['name']);
					$gui->addContent("Owned Pod created<br><a href=\"owned_pods.php?type=1\">Create Another Owned Pod</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
					$gui->addContent("Type: <select name=\"pod_type\">");
					$pod_array = $podracer->listPods();
					for ($k = 0; $k < sizeof ($pod_array); $k++)
					{
						$pod_list = $pod_array [$k];
						$gui->addContent("<option value=\"".$pod_list->getID()."\">".$pod_list->getName()."</option>");
						unset ($pod_list);
					}					
					$gui->addContent("</select><br>");
					$gui->addContent("Team: <select name=\"team\">");
					$team_array = $podracer->listTeams();
					for ($k = 0; $k < sizeof ($team_array); $k++)
					{
						$team_list = $team_array [$k];
						$gui->addContent("<option value=\"".$team_list->getID()."\">".$team_list->getName()."</option>");
						unset ($team_list);
					}					
					$gui->addContent("</select><br>");
					$gui->addContent("Name: <input type=\"text\" name=\"name\"><br>");
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
						$pod = new OwnedPod ($_REQUEST['selected']);
						$pod->setType($_REQUEST['pod_type']);
						$pod->setTeam($_REQUEST['team']);
						$pod->setName($_REQUEST['name']);
						$gui->addContent("Owned Pod edited<br><a href=\"owned_pods.php?type=2\">Edit Another Owned Pod</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$pod = new OwnedPod ($_REQUEST['selected']);
						$pod_type = $pod->getType();
						$gui->AddContent('ASL: '.$pod->GetASL().'<br />');
						$team = $pod->getTeam();
						$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");						
						$gui->addContent("Type: <select name=\"pod_type\">");
						$pod_array = $podracer->listPods();
						for ($k = 0; $k < sizeof ($pod_array); $k++)
						{
							$pod_list = $pod_array [$k];
							$gui->addContent("<option value=\"".$pod_list->getID()."\"");
							if ($pod_list->getID() == $pod_type->getID())
							{
								$gui->addContent("selected");
							}
							$gui->addContent(">".$pod_list->getName()."</option>");
							unset ($pod_list);
						}					
						$gui->addContent("</select><br>");
						$gui->addContent("Team: <select name=\"team\">");
						$team_array = $podracer->listTeams();
						for ($k = 0; $k < sizeof ($team_array); $k++)
						{
							$team_list = $team_array [$k];
							$gui->addContent("<option value=\"".$team_list->getID()."\"");
							if ($team_list->getID() == $team->getID())
							{
								$gui->addContent("selected");
							}
							$gui->addContent(">".$team_list->getName()."</option>");
							unset ($pod_list);
						}					
						$gui->addContent("</select><br>");
						$gui->addContent("Name: <input type=\"text\" name=\"name\" value=\"".$pod->getName()."\"><br>");
						$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"selected\" value=\"".$_REQUEST['selected']."\">\r\n");
						$gui->addContent("</form>\r\n");
					}
				}
				elseif ($_REQUEST['type'] == 3)
				{
					$pod = new OwnedPod ($_REQUEST['selected']);
					$pod->delete();
					$gui->addContent("Owned Pod deleted<br><a href=\"owned_pods.php?type=3\">Delete Another Owned Pod</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");	
				$gui->addContent("<select name=\"selected\">\r\n");
				$pods_array = $podracer->listOwnedPods();
				for ($i = 0; $i < sizeof ($pods_array); $i++)
				{
					$pod = $pods_array [$i];
					$owner_team = $pod->getTeam();
					$gui->addContent("<option value=\"".$pod->getID()."\">".$pod->getName()." owned by ".$owner_team->getName()."</option>\r\n");
					unset($owner_team);
					unset($pod);
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