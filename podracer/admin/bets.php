<?php
	
	include ("../setup.php");
	$gui_obj->setTitle("Owned Parts Admin");
	
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
					$bet_obj = $podracer_obj->createBet($bhg_id, $pod_id, $race_id, $amount);
					$gui_obj->addContent("Bet created<br><a href=\"bets.php?type=1\">Create Another Bet</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");					
					$gui_obj->addContent("<table>");
					$gui_obj->addContent("<tr><td>BHG ID</td><td><input type=\"text\" name=\"bhg_id\"></td></tr>\r\n");
					$pods_array = $podracer_obj->listOwned_pods();
					$gui_obj->addContent("<tr><td>Pods</td><td><select name=\"pod_id\">");
					for ($i = 0; $i < sizeof ($pods_array); $i++)
					{
						$pod_obj = $pods_array [$i];
						$gui_obj->addContent("<option value=\"".$pod_obj->getID()."\">".$pod_obj->getName()."</option>\r\n");
						unset ($pod_obj);
					}
					$gui_obj->addContent("</select></td></tr>");
					$races_array = $podracer_obj->listRaces();
					$gui_obj->addContent("<tr><td>Race</td><td><select name=\"race_id\"><br>");
					for ($i = 0; $i < sizeof ($races_array); $i++)
					{
						$race_obj = $races_array [$i];
						$gui_obj->addContent("<option value=\"".$race_obj->getID()."\">".$race_obj->getName()."</option>\r\n");
						unset ($race_obj);
					}
					$gui_obj->addContent("</select></td></tr>");
					$gui_obj->addContent("<tr><td>Amount</td><td><input type=\"text\" name=\"amount\"></td></tr>");
					$gui_obj->addContent("</table>");
					$gui_obj->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">");
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
						$bet_obj = new Bet ($selected);
						$bet_obj->setBhg_id($bhg_id);
						$bet_obj->setPod($pod_id);
						$bet_obj->setRace($race_id);
						$bet_obj->setAmount($amount);
						$gui_obj->addContent("Bet edited<br><a href=\"bets.php?type=2\">Edit Another Part</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$bet_obj = new Bet ($selected);
						$edit_race_obj = $bet_obj->getRace();
						$edit_pod_obj = $bet_obj->getPod();
						$edit_person_obj = $bet_obj->getBhg_id();
						$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");
						$gui_obj->addContent("<table>");
						$gui_obj->addContent("<tr><td>BHG ID</td><td><input type=\"text\" name=\"bhg_id\" value=\"".$edit_person_obj->getID()."\"></td></tr>");
						$pods_array = $podracer_obj->listOwned_pods();
						$gui_obj->addContent("<tr><td>Pod</td><td><select name=\"pod_id\"><br>");
						for ($i = 0; $i < sizeof ($pods_array); $i++)
						{
							$pod_obj = $pods_array [$i];
							$gui_obj->addContent("<option value=\"".$pod_obj->getID()."\"");
							if ($edit_pod_obj->getID() == $pod_obj->getID())
							{
								$gui_obj->addContent(" selected");
							}
							$gui_obj->addContent(">".$pod_obj->getName()."</option>\r\n");
							unset ($pod_obj);
						}
						$gui_obj->addContent("</select></td></tr>");					
						$races_array = $podracer_obj->listRaces();
						$gui_obj->addContent("<tr><td>Race</td><td><select name=\"race_id\"><br>");
						for ($i = 0; $i < sizeof ($races_array); $i++)
						{
							$race_obj = $races_array [$i];
							$gui_obj->addContent("<option value=\"".$race_obj->getID()."\"");
							if ($edit_race_obj->getID() == $race_obj->getID())
							{
								$gui_obj->addContent(" selected");
							}
							$gui_obj->addContent(">".$race_obj->getName()."</option>\r\n");
							unset ($race_obj);
						}
						$gui_obj->addContent("</select></td></tr>");						
						$gui_obj->addContent("<tr><td>Amount</td><td><input type=\"text\" name=\"amount\" value=\"".$bet_obj->getAmount()."\"></td></tr>");
						$gui_obj->addContent("</table>");
						$gui_obj->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">");
						$gui_obj->addContent("<input type=\"hidden\" name=\"type\" value=\"$type\">\r\n");
						$gui_obj->addContent("</form>\r\n");
					}
				}
				elseif ($type == 3)
				{
					$vet_obj = new Bet ($selected);
					$vet_obj->delete();
					$gui_obj->addContent("Bet deleted<br><a href=\"bets.php?type=3\">Delete Another Bet</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");	
				$gui_obj->addContent("<select name=\"selected\">\r\n");
				$bets_array = $podracer_obj->listBets();
				for ($i = 0; $i < sizeof ($bets_array); $i++)
				{
					$bet_obj = $bets_array [$i];
					$person_obj = $bet_obj->getBhg_id();
					$pod_obj = $bet_obj->getPod();
					$race_obj = $bet_obj->getRace();
					$gui_obj->addContent("<option value=\"".$bet_obj->getID()."\">".$person_obj->getName()." with ".number_format($bet_obj->getAmount())." Credits on \"".$pod_obj->getName()."\" in ".$race_obj->getName()."</option>\r\n");
					unset($race_obj);
					unset($pod_obj);
					unset($person_obj);
					unset($bet_obj);
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