<?php
	include_once 'header.php';

	if (isset($_REQUEST['race_id'])) {
		$race = new Race($_REQUEST['race_id']);
		$course = $race->GetCourse();
		$pods_array = $race->ListPods();
		$gui->addContent ("<p>".$race->GetDate()."<br><font size=\"4\"><b>".$race->GetName()."</b></font></p>");
		$gui->addContent ("<table cellspacing=\"1\" cellpadding=\"3\">");
		$gui->addContent ("<tr><td>Course</td><td><a href=\"".$base_url."course.php?View=1&amp;course_id=".$course->GetID()."\">".$course->GetName()."</a></td></tr>");
		$gui->addContent ("<tr><td>Pod Limit</td><td>".$race->GetPodLimit()." (".($race->GetPodLimit() - sizeof($pods_array))." spots remaining)</td></tr>");
		$gui->addContent ("<tr><td>Max Skill Level (ASL)</td><td>".($race->GetSkillLevel() + 25)."</td></tr>");
		$gui->addContent ("<tr><td>Laps</td><td>".$race->GetLaps()."</td></tr>");
		$gui->addContent ("<tr><td>Buyin per pod</td><td>".number_format($race->GetCost())." Credits</td></tr>");
		$gui->addContent ("<tr><td>Grand Prize</td><td>".number_format($race->GetBaseReward())." Credits</td></tr>");
		$gui->addContent ("<tr><td>Betting Starts</td><td>".$race->GetRegDate()."</td></tr>");
		$gui->addContent ("</table>");		
		$gui->addContent ("<h3>Competing Pods (".sizeof ($pods_array).")</h3>");
		foreach ($pods_array as $pod) {
			$team = $pod->GetTeam();
			$race_reg = $podracer->GetRaceReg($pod, $race);
			$gui->addContent ("&nbsp;&nbsp;&nbsp;\"<a href=\"{$base_url}list_active.php?View_pod=1&amp;pod_id=".$pod->GetID()."\">".$pod->GetName()."</a>\" owned by <a href=\"".$base_url."list_active.php?View_team=1&amp;team_id=".$team->GetID()."\">".$team->GetName()."</a><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;House Odds: ".$race_reg->GetHouseOdds(1)."<br>");
			unset ($race_reg);
			unset ($team);
		}
		$gui->addContent ("<p align=\"center\"><a href=\"{$_SERVER["PHP_SELF"]}\">Return to race listings</a><br></p>");    
    } elseif ($_REQUEST['resl']){
    $gui->addContent ("<h2 align=\"center\">Race Results</h2>\r\n");
		$gui->addContent ("<table width=\"95%\" align=\"center\">\r\n");
	    if ($_REQUEST['item']){
		    $gui->addContent("<tr><td><a href=\"{$_SERVER["PHP_SELF"]}?resl=show\">Return to Race Results</a></td></tr>");
		    $item = new NewsItem($_REQUEST['item'], $coder_id);
		    $gui->addContent("<tr><th>".$item->Render('%topic%')."</th></tr>");
		    $gui->addContent("<tr><td>".$item->Render('%message%')."</td></tr>");
	    } else {
			foreach ($news->GetNews() as $item) {
			    $gui->addContent("<tr><td><a href=\"{$_SERVER["PHP_SELF"]}?resl=show&item=".$item->GetID()."\">".$item->Render('%topic%')."</a></td></tr>");
			}
		}
	    $gui->addContent ("</table>\r\n");  
	} else {
		$gui->addContent ("<p align=\"center\"><a href=\"calender.php\">Show Calender</a><br></p>");
		$gui->addContent ("<p align=\"center\"><a href=\"{$_SERVER["PHP_SELF"]}?resl=show\">Show Race Results</a><br></p>");
		$gui->addContent ("<h2 align=\"center\">Podracer Schedule</h2>\r\n");
		$gui->addContent ("<table width=\"95%\" align=\"center\"><tr><th><font size=\"2\">Date</font></th><th><font size=\"2\">Name</font></th><th><font size=\"2\">Course</font></th></tr>\r\n");
    $races_array = $podracer->listUpcomingRaces();
		foreach ($races_array as $race) {
      $course = $race->getCourse();
      $gui->addContent ("<tr><td align=\"center\"><small>".$race->getDate()."</small></td><td align=\"center\"><small><a href=\"".$base_url."schedule.php?race_id=".$race->GetID()."\">".$race->getName()."</a></small></td><td align=\"center\"><small><a href=\"".$base_url."course.php?View=1&amp;course_id=".$course->GetID()."\">".$course->GetName()."</a></small></td></tr>\r\n");
			unset ($course);
		}
    $gui->addContent ("</table>\r\n");  
		
	}
	$gui->setTitle ("Race Schedule");
	$gui->outputGui ();

?>