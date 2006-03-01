<?php

	include_once 'header.php';
	
	if (isset($_REQUEST['View'])) {
		$course = new Course($_REQUEST['course_id']);
		$gui->addContent ("<h3>".$course->GetName()."</h3>\r\n");
		$gui->addContent (convertURL($course->GetDescription())."<br /><br />");
		$gui->addContent ("<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n");
		$gui->addContent ("<tr><td align=\"right\">ASL</td><td width=\"10px\">&nbsp;</td><td align=\"left\">".$course->GetASL()."</td></tr>\r\n");
		$gui->addContent ("<tr><td align=\"right\">Traction</td><td width=\"10px\">&nbsp;</td><td align=\"left\">".$podracer->meter(-1 * $course->GetTraction())."</td></tr>\r\n");
		$gui->addContent ("<tr><td align=\"right\">Turning</td><td width=\"10px\">&nbsp;</td><td align=\"left\">".$podracer->meter(-1 * $course->GetTurning())."</td></tr>\r\n");
		$gui->addContent ("<tr><td align=\"right\">Acceleration</td><td width=\"10px\">&nbsp;</td><td align=\"left\">".$podracer->meter(-1 * $course->GetAcceleration())."</td></tr>\r\n");
		$gui->addContent ("<tr><td align=\"right\">Top Speed</td><td width=\"10px\">&nbsp;</td><td align=\"left\">".$podracer->meter(-1 * $course->GetTopSpeed())."</td></tr>\r\n");
		$gui->addContent ("<tr><td align=\"right\">Air Brake</td><td width=\"10px\">&nbsp;</td><td align=\"left\">".$podracer->meter(-1 * $course->GetAirBrake())."</td></tr>\r\n");
		$gui->addContent ("<tr><td align=\"right\">Cooling</td><td width=\"10px\">&nbsp;</td><td align=\"left\">".$podracer->meter(-1 * $course->GetCooling())."</td></tr>\r\n");
		$gui->addContent ("<tr><td align=\"right\">Repair</td><td width=\"10px\">&nbsp;</td><td align=\"left\">".$podracer->meter(-1 * $course->GetRepair())."</td></tr>\r\n");
    $gui->addContent ("</table>\r\n");
		$gui->addContent ("<p align=\"center\"><a href=\"".$base_url."course.php\">Return to course description listings</a></p>\r\n");		
	} else {	
		$gui->addContent ("\r\n<h2 align=\"center\">Available Courses</h2>\r\n");
		$courses_array = $podracer->ListCourses();
		for ($i = 0; $i < sizeof ($courses_array); $i++)
		{
      $course = $courses_array[$i];
      if ($i < (sizeof ($courses_array) / 3))
        $string1 .= "<a href=\"".$base_url."course.php?View=1&amp;course_id=".$course->getID()."\">".$course->getName()."</a><br />\r\n";
      elseif ($i < (2 * sizeof ($courses_array) / 3))
        $string2 .= "<a href=\"".$base_url."course.php?View=1&amp;course_id=".$course->getID()."\">".$course->getName()."</a><br />\r\n";
      else
        $string3 .= "<a href=\"".$base_url."course.php?View=1&amp;course_id=".$course->getID()."\">".$course->getName()."</a><br />\r\n";
		}
	}
	
  	$gui->addContent ("<table align=\"center\" width=\"75%\"><tr><td valign=\"top\" align=\"right\">".$string1."</td><td valign=\"top\" align=\"center\">".$string2."</td><td valign=\"top\" align=\"left\">".$string3."</td></tr></table>");
	$gui->addContent('<center><hr noshade>Key<p>');
  	$gui->addContent('Green Bars indicate the course\'s stat enhances your pods stat.<br />'.$podracer->meter(10).'<br />');
	$gui->addContent('Red Bars indicate the course\'s stat decreased your pods stat.<br />'.$podracer->meter(-10).'<br />');
	$gui->addContent('A single Black Bar indicate the course\'s stat has no effect on your pod.<br />'.$podracer->meter(0).'</center>');
	$gui->setTitle ("Course descriptions");
	$gui->outputGui ();
?>