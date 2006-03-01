<?php
	
	include "../header.php";
	$gui->setTitle("Race Result Admin");
	$hunter = new Login_HTTP($coder_id);
		if (in_array($hunter->getID(), $admin))
		{
			if ($_REQUEST['type'] == 1)
			{
				if (isset($_REQUEST['Submit']))
				{
					$part = $podracer->createRaceResult($_REQUEST['reg'], $_REQUEST['place'], $_REQUEST['winnings']);
					$gui->addContent("Race Result created<br><a href=\"race_results.php?type=1\">Create Another Race Result</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
					$gui->addContent("Registration: <select name=\"reg\">");
					$races_array = $podracer->listRaceRegistrations(1);
					for ($i = 0; $i < sizeof ($races_array); $i++)
					{
						$race = $races_array [$i];
						$pod = $race->getPod();
						$race_type = $race->getRace();
						$gui->addContent("<option value=\"".$race->getID()."\">Race: ".$race_type->getName()." | Pod: ".$pod->getName()."</option>\r\n");
						unset($race);
					}			
					$gui->addContent("</select><br>");
					$gui->addContent("Place: <input type=\"text\" name=\"place\"><br>");
					$gui->addContent("Winnings: <input type=\"text\" name=\"winnings\"><br>");
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
						$race = new RaceResult ($_REQUEST['selected']);						
						$race->SetRegistration($_REQUEST['reg']);				
						$race->setPlace($_REQUEST['place']);
						$race->setWinnings($_REQUEST['winnings']);
						$gui->addContent("Race Result edited<br><a href=\"race_results.php?type=2\">Edit Another Race Result</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$racea = new RaceResult ($_REQUEST['selected']);
						$reg = $racea->getRegistration();
						$reg_id  = $reg->GetID();
						$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
						$gui->addContent("Registration: <select name=\"reg\">");
						$races_array = $podracer->listRaceRegistrations(1);
						for ($i = 0; $i < sizeof ($races_array); $i++)
						{
							$race = $races_array [$i];
							$pod = $race->getPod();
							$race_type = $race->getRace();
							$gui->addContent("<option value=\"".$race->getID()."\"");
							if ($reg_id == $race->GetID())
							{
								$gui->addContent("selected");
							}
							
							$gui->AddContent(">Race: ".$race_type->getName()." | Pod: ".$pod->getName()."</option>");
							unset($race);
						}			
						$gui->addContent("</select><br>");
						$gui->addContent("Place: <input type=\"text\" name=\"place\" value=\"".$racea->getPlace()."\"><br>");
						$gui->addContent("Winnings: <input type=\"text\" name=\"winnings\" value=\"".$racea->getWinnings()."\"><br>");
						$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"selected\" value=\"".$_REQUEST['selected']."\">\r\n");
						$gui->addContent("</form>\r\n");
					}
				}
				elseif ($_REQUEST['type'] == 3)
				{
					$race = new RaceResult ($_REQUEST['selected']);
					$race->delete();
					$gui->addContent("Race Result deleted<br><a href=\"race_results.php?type=3\">Delete Another Race Result</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");	
				$gui->addContent("<select name=\"selected\">\r\n");
				$races_array = $podracer->listRaceresults();
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