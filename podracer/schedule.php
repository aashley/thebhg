<?php

	include "setup.php";
	
	if (isset($race_id))
	{
		$race_obj = new Race ($race_id);
		$course_obj = $race_obj->getCourse();
		$pods_array = $race_obj->listPods();		
		$gui_obj->addContent ("<p>".date ("l, F jS", $race_obj->getDate())."<br><font size=\"4\"><b>".$race_obj->getName()."</b></font></p>");
		$gui_obj->addContent ("<table cellspacing=\"1\" cellpadding=\"3\">");
		$gui_obj->addContent ("<tr><td>Course</td><td><a href=\"".$base_url."course_desc.php?View=1&amp;course_id=".$course_obj->getID()."\">".$course_obj->getName()."</a></td></tr>");
		$gui_obj->addContent ("<tr><td>Pod Limit</td><td>".$race_obj->getPod_limit()." (".($race_obj->getPod_limit() - sizeof($pods_array))." spots remaining)</td></tr>");
		$gui_obj->addContent ("<tr><td>Skill Level (ASL)</td><td>".$race_obj->getSkill_level()."</td></tr>");
		$gui_obj->addContent ("<tr><td>Laps</td><td>".$race_obj->getLaps()."</td></tr>");
		$gui_obj->addContent ("<tr><td>Buyin per pod</td><td>".number_format($race_obj->getCost())." Credits</td></tr>");
		$gui_obj->addContent ("<tr><td>Grand Prize</td><td>".number_format($race_obj->getBase_reward())." Credits</td></tr>");
		$gui_obj->addContent ("<tr><td>Betting Starts</td><td>".date ("l, F jS", $race_obj->getReg_date())."</td></tr>");
		$gui_obj->addContent ("<tr><td>Bets Placed</td><td>".$race_obj->totalBets(1)." bets for a total of ".number_format($race_obj->totalBets(2))." credits</td></tr>");
		$gui_obj->addContent ("</table>");		
		$gui_obj->addContent ("<h3>Competing Pods (".sizeof ($pods_array).")</h3>");
		foreach ($pods_array as $pod_obj)
		{
			$team_obj = $pod_obj->getTeam();
			$select_result = $db_obj->query ("SELECT id FROM podracer_race_registrations WHERE pod = ".$pod_obj->getID()." AND race = ".$race_obj->getID());
			$select_row = mysql_fetch_array ($select_result);
			$race_reg_obj = new Race_registration ($select_row["id"]);
			$gui_obj->addContent ("&nbsp;&nbsp;&nbsp;\"<a href=\"{$base_url}list_active.php?View_pod=1&amp;pod_id=".$pod_obj->getID()."\">".$pod_obj->getName()."</a>\" owned by <a href=\"".$base_url."list_active.php?View_team=1&amp;team_id=".$team_obj->getID()."\">".$team_obj->getName()."</a><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;House Odds: 1 / ".$race_reg_obj->getHouse_odds()."<br>");
			unset ($race_reg_obj);
			unset ($team_obj);
		}
		$gui_obj->addContent ("<p align=\"center\"><a href=\"{$_SERVER["PHP_SELF"]}\">Return to race listings</a><br></p>");
	}
	else
	{
    $gui_obj->addContent ("<h2 align=\"center\">Podracer Schedule</h2>\r\n");
		$gui_obj->addContent ("<table width=\"95%\" align=\"center\"><tr><th><font size=\"2\">Date</font></th><th><font size=\"2\">Name</font></th><th><font size=\"2\">Course</font></th></tr>\r\n");
    $races_array = $podracer_obj->listUpcomingRaces();
		foreach ($races_array as $race_obj)
		{
      $course_obj = $race_obj->getCourse();
      $gui_obj->addContent ("<tr><td align=\"center\">".date("m/d/y", $race_obj->getDate())."</td><td align=\"center\"><a href=\"".$base_url."schedule.php?race_id=".$race_obj->getID()."\">".$race_obj->getName()."</a></td><td align=\"center\"><a href=\"".$base_url."course_desc.php?View=1&amp;course_id=".$course_obj->getID()."\">".$course_obj->getName()."</a></td></tr>\r\n");
			unset ($course_obj);
		}
    $gui_obj->addContent ("</table>\r\n");    
	}
	$gui_obj->setTitle ("Race Schedule");
	$gui_obj->outputGui ();
?>