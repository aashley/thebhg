<?php

	include "setup.php";
	
	if (isset($View))
	{
		$course_obj = new Course ($course_id);
		$gui_obj->addContent ("<h3>".$course_obj->getName()."</h3>\r\n");
		$gui_obj->addContent (convertURL($course_obj->getDescription())."<br /><br />");
		$gui_obj->addContent ("<table align=\"center\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n");
		$gui_obj->addContent ("<tr><td align=\"right\">Traction</td><td width=\"10px\">&nbsp;</td><td align=\"left\">".$podracer_obj->meter(($course_obj->getTraction() + 5))."</td></tr>\r\n");
		$gui_obj->addContent ("<tr><td align=\"right\">Turning</td><td width=\"10px\">&nbsp;</td><td align=\"left\">".$podracer_obj->meter(($course_obj->getTurning() + 5))."</td></tr>\r\n");
		$gui_obj->addContent ("<tr><td align=\"right\">Acceleration</td><td width=\"10px\">&nbsp;</td><td align=\"left\">".$podracer_obj->meter(($course_obj->getAcceleration() + 5))."</td></tr>\r\n");
		$gui_obj->addContent ("<tr><td align=\"right\">Top Speed</td><td width=\"10px\">&nbsp;</td><td align=\"left\">".$podracer_obj->meter(($course_obj->getTop_speed() + 5))."</td></tr>\r\n");
		$gui_obj->addContent ("<tr><td align=\"right\">Air Brake</td><td width=\"10px\">&nbsp;</td><td align=\"left\">".$podracer_obj->meter(($course_obj->getAir_brake() + 5))."</td></tr>\r\n");
		$gui_obj->addContent ("<tr><td align=\"right\">Cooling</td><td width=\"10px\">&nbsp;</td><td align=\"left\">".$podracer_obj->meter(($course_obj->getCooling() + 5))."</td></tr>\r\n");
		$gui_obj->addContent ("<tr><td align=\"right\">Repair</td><td width=\"10px\">&nbsp;</td><td align=\"left\">".$podracer_obj->meter(($course_obj->getRepair() + 5))."</td></tr>\r\n");
    $gui_obj->addContent ("</table>\r\n");
		$gui_obj->addContent ("<p align=\"center\"><a href=\"".$base_url."course_desc.php\">Return to course description listings</a></p>\r\n");		
	}
	else
	{	
		$gui_obj->addContent ("\r\n<h2 align=\"center\">Available Courses</h2>\r\n");
		$courses_array = $podracer_obj->listCourses();
		for ($i = 0; $i < sizeof ($courses_array); $i++)
		{
      $course_obj = $courses_array[$i];
      if ($i < (sizeof ($courses_array) / 3))
        $string1 .= "<a href=\"".$base_url."course_desc.php?View=1&amp;course_id=".$course_obj->getID()."\">".$course_obj->getName()."</a><br />\r\n";
      elseif ($i < (2 * sizeof ($courses_array) / 3))
        $string2 .= "<a href=\"".$base_url."course_desc.php?View=1&amp;course_id=".$course_obj->getID()."\">".$course_obj->getName()."</a><br />\r\n";
      else
        $string3 .= "<a href=\"".$base_url."course_desc.php?View=1&amp;course_id=".$course_obj->getID()."\">".$course_obj->getName()."</a><br />\r\n";
		}
	}
  $gui_obj->addContent ("<table align=\"center\" width=\"75%\"><tr><td valign=\"top\" align=\"right\">".$string1."</td><td valign=\"top\" align=\"center\">".$string2."</td><td valign=\"top\" align=\"left\">".$string3."</td></tr></table>");
	$gui_obj->setTitle ("Course descriptions");
	$gui_obj->outputGui ();
?>