<?php

	include "setup.php";
	
	if (!isset($PHP_AUTH_USER)) 
		die(login_failed());
	else 
	{  
		$hunter_obj = new Login ($PHP_AUTH_USER, $PHP_AUTH_PW, $coder_id);
		if ($hunter_obj->IsValid())
		{
			if (isset($Submit))
			{
				$race_obj = new Race ($race_id);
				$teams_array = $race_obj->listTeams();
				foreach ($teams_array as $invalid_team_obj)
					$team_str_array [$f] = $invalid_team_obj->getID();
				$team_str = join (" OR team = ", $team_str_array);
				$is_member_sql = "SELECT COUNT(*) AS num FROM podracer_team_members WHERE bhg_id = ".$hunter_obj->getID()." AND (team = ".$team_str.")";
				$is_member_result = $db_obj->query ($is_member_sql);				
				if (mysql_result ($is_member_result, 0, "num") <= 0)
				{
					$previous_result = $db_obj->query ("SELECT COUNT(*) AS num FROM podracer_bets WHERE bhg_id = ".$hunter_obj->getID()." AND race = ".$race_id);
					if (mysql_result ($previous_result, 0, "num") <= 0)
					{
						if (isset($Final))
						{
							$pod_obj = new Owned_pod ($pod_id);
							$podracer_obj->createBet ($hunter_obj->getID(), $pod_id, $race_id, $amount);
							$gui_obj->addContent (number_format($amount)." Credits successfully placed on \"".$pod_obj->getName()."\" in ".$race_obj->getName());
						}
						else
						{
							$skill_level = $race_obj->getSkill_level();
							$gui_obj->addContent ("<form action=\"".$PHP_SELF."\" method=\"GET\">\r\n");
							$gui_obj->addContent ("<h3>Further betting details for ".$race_obj->getName()."</h3>");
							$gui_obj->addContent ("<table>");
							$gui_obj->addContent ("<tr><td>Pod</td><td><select name=\"pod_id\">");
							$pods_array = $race_obj->listPods();
							foreach ($pods_array as $pod_obj)
							{
								$team_obj = $pod_obj->getTeam();
								$difference = 1 + ($skill_level / $pod_obj->getASL());
								$difference = (int)(pow (4, $difference) / 2);
								$gui_obj->addContent ("<option value=\"".$pod_obj->getID()."\"");
								if ($pod_id == $pod_obj->getID()) 
									$gui_obj->addContent (" selected");
								$gui_obj->addContent (">1 / ".$difference.": \"".$pod_obj->getName()."\" owned by ".$team_obj->getName()."</option>");
							}
							$gui_obj->addContent ("</select></td></tr>");
							$gui_obj->addContent ("<tr><td>Amount</td><td><input type=\"text\" name=\"amount\"></td></tr>");
							$gui_obj->addContent ("</table>");
							$gui_obj->addContent ("<input type=\"Submit\" name=\"Final\" value=\"Submit\">");
							$gui_obj->addContent ("<input type=\"hidden\" name=\"Submit\" value=\"Submit\">");
							$gui_obj->addContent ("<input type=\"hidden\" name=\"race_id\" value=\"".$race_id."\">");
							$gui_obj->addContent ("</form>");
						}
					}
					else
						$gui_obj->addContent ("You have already placed a bet in this race. If you want to change the pod or amount, remove your old bet and then create a new bet.");
				}
				else
					$gui_obj->addContent ("Only hunters who are not a part of a competing podracer team may place bets.");
			}
			elseif (isset($Remove))
			{
				$bet_obj = new Bet ($bet_id);
				$bet_obj->delete();
				$gui_obj->addContent ("Bet removed successfully.");
				$gui_obj->addContent ("<p><a href=\"".$base_url."bets.php\">Return to bets page</a></p>");
			}
			else
			{
				$gui_obj->addContent ("<h3>Races currently available for bet placement</h3>");
				$gui_obj->addContent ("<form action=\"".$PHP_SELF."\" method=\"GET\">\r\n");
				$gui_obj->addContent ("<select name=\"race_id\">");
				$races_array = $podracer_obj->listUpcomingRaces();
				foreach ($races_array as $race_obj)
				{
					if ((time() >= $race_obj->getReg_date()) && (time() <=  $race_obj->getDate()))
						$gui_obj->addContent ("<option value=\"".$race_obj->getID()."\">".$race_obj->getName()."</option>");
				}
				$gui_obj->addContent ("</select> <input type=\"Submit\" name=\"Submit\" value=\"Submit\">");
				$gui_obj->addContent ("</form>");
				$gui_obj->addContent ("<h3>Current Bets</h3>");
				$bets_array = $podracer_obj->listBets ($hunter_obj->getID());
				foreach ($bets_array as $bet_obj)
				{
					$pod_obj = $bet_obj->getPod();
					$race_obj = $bet_obj->getRace();
					$team_obj = $pod_obj->getTeam();
					$gui_obj->addContent ("&nbsp;&nbsp;&nbsp;".number_format($bet_obj->getAmount())." Credits on \"<a href=\"".$base_url."list_active.php?View_pod=1&amp;pod_id=".$pod_obj->getID()."\">".$pod_obj->getName()."</a>\" owned by <a href=\"".$base_url."list_active.php?View_team=1&amp;team_id=".$team_obj->getID()."\">".$team_obj->getName()."</a> in <a href=\"".$base_url."schedule.php?race_id=".$race_obj->getID()."\">".$race_obj->getName()."</a> [<a href=\"".$base_url."bets.php?Remove=1&amp;bet_id=".$bet_obj->getID()."\">Remove</a>]<br>");
					unset ($team_obj);
					unset ($race_obj);
					unset ($pod_obj);
				}
			}
			$gui_obj->setTitle ("Betting Central");
			$gui_obj->outputGui ();
		} 
		else 
			die(login_failed());
	}
?>