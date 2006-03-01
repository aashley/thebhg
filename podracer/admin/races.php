<?php

	function DateBox($name, $ts = 0, $show_time = false) {
		$df = '<input type="text" id="' . htmlspecialchars($name) . '_day" name="' . htmlspecialchars($name) . '_day" size="3" maxsize="2"';
		if ($ts) {
			$df .= ' value="' . date('j', $ts) . '">';
		}
		else {
			$df .= ' value="day" onFocus="if (this.value == \'day\') this.value = \'\'" onBlur="if (this.value == \'\') this.value = \'day\'">';
		}
		$df .= ' <select id="' . htmlspecialchars($name) . '_month" name="' . htmlspecialchars($name) . '_month" size="1">';
		for ($i = 1; $i <= 12; $i++) {
			$df .= '<option value="' . $i . '"';
			if ($ts && date('n', $ts) == $i) {
				$df .= ' selected';
			}
			$df .= '>' . date('F', mktime(0, 0, 0, $i)) . '</option>';
		}
		$df .= '</select> ';
		$df .= '<input type="text" id="' . htmlspecialchars($name) . '_year" name="' . htmlspecialchars($name) . '_year" size="5" maxsize="4"';
		if ($ts) {
			$df .= ' value="' . date('Y', $ts) . '">';
		}
		else {
			$df .= ' value="year" onFocus="if (this.value == \'year\') this.value = \'\'" onBlur="if (this.value == \'\') this.value = \'year\'">';
		}
		if ($show_time) {
			$df .= ' at ';
			$df .= '<input type="text" id="' . htmlspecialchars($name) . '_hour" name="' . htmlspecialchars($name) . '_hour" size="4" maxsize="2"';
			if ($ts) {
				$df .= ' value="' . date('G', $ts) . '">';
			}
			else {
				$df .= ' value="hour" onFocus="if (this.value == \'hour\') this.value = \'\'" onBlur="if (this.value == \'\') this.value = \'hour\'">';
			}
			$df .= ':<input type="text" id="' . htmlspecialchars($name) . '_min" name="' . htmlspecialchars($name) . '_min" size="4" maxsize="2"';
			if ($ts) {
				$df .= ' value="' . date('i', $ts) . '">';
			}
			else {
				$df .= ' value="min" onFocus="if (this.value == \'min\') this.value = \'\'" onBlur="if (this.value == \'\') this.value = \'min\'">';
			}
			$df .= ' ' . date('T');
		}
		return $df;
	}
	
	function parse_date_box($name) {
		if (isset($_REQUEST["{$name}_hour"])) {
			$hour = $_REQUEST["{$name}_hour"];
		}
		else {
			$hour = 0;
		}
		if (isset($_REQUEST["{$name}_min"])) {
			$min = $_REQUEST["{$name}_min"];
		}
		else {
			$min = 0;
		}
		$year = $_REQUEST["{$name}_year"];
		$month = $_REQUEST["{$name}_month"];
		$day = $_REQUEST["{$name}_day"];
		return mktime($hour, $min, 0, $month, $day, $year);
	}

	include "../header.php";
	$gui->setTitle("Race Admin");
	$hunter = new Login_HTTP($coder_id);
		if (in_array($hunter->getID(), $admin))
		{
			if ($_REQUEST['type'] == 1)
			{
				if (isset($_REQUEST['Submit']))
				{
          			$date = parse_date_box('date');
					$reg_date = parse_date_box('reg_date');
					$part = $podracer->createRace($_REQUEST['course'], $_REQUEST['name'], $date, $reg_date, $_REQUEST['base_reward'], 
					$_REQUEST['pod_limit'], $_REQUEST['skill_level'], $_REQUEST['laps'], $_REQUEST['buyin']);
					$gui->addContent("Race created<br><a href=\"races.php?type=1\">Create Another Race</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
					$gui->addContent("Course: <select name=\"course\">");
					$courses_array = $podracer->listCourses();
					for ($k = 0; $k < sizeof ($courses_array); $k++)
					{
						$course_list = $courses_array [$k];
						$gui->addContent("<option value=\"".$course_list->getID()."\">".$course_list->getName()."</option>");
						unset ($course_list);
					}					
					$gui->addContent("</select><br>");
					$gui->addContent("Name: <input type=\"text\" name=\"name\"><br>");
					$time = time()+(60*60*7*24);
					$racerspeed = $time + (60*60*7*24);
					$gui->addContent("Reg Date: ".DateBox('reg_date', $time)."<br>Date: ".DateBox('date', $racerspeed)."<br>");
					$gui->addContent("Reward: <input type=\"text\" size=\"10\" name=\"base_reward\"><br>");
					$gui->addContent("Pod Limit: <input type=\"text\" size=\"5\" name=\"pod_limit\"><br>");
					$gui->addContent("Skill level: <input type=\"text\" size=\"10\" name=\"skill_level\"><br>");
					$gui->addContent("Laps: <input type=\"text\" size=\"5\" name=\"laps\"><br>");
					$gui->addContent("Buyin: <input type=\"text\" size=\"10\" name=\"buyin\"><br>");
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
						
					$date = parse_date_box('date');
					$reg_date = parse_date_box('reg_date');
						$race = new Race ($_REQUEST['selected']);						
						$race->setCourse($_REQUEST['course']);
						$race->setName($_REQUEST['name']);
						$race->setDate($date);
						$race->setRegdate($reg_date);
						$race->setBasereward($_REQUEST['base_reward']);
						$race->setPodlimit($_REQUEST['pod_limit']);
						$race->setSkilllevel($_REQUEST['skill_level']);
						$race->setLaps($_REQUEST['laps']);
						$race->setCost($_REQUEST['buyin']);
						$gui->addContent("Race edited<br><a href=\"races.php?type=2\">Edit Another Race</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$race = new Race ($_REQUEST['selected']);
						$course = $race->getCourse();
						$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");						
						$gui->addContent("Course: <select name=\"course\">");
						$courses_array = $podracer->listCourses();
						for ($k = 0; $k < sizeof ($courses_array); $k++)
						{
							$course_list = $courses_array [$k];
							$gui->addContent("<option value=\"".$course_list->getID()."\"");
							if ($course_list->getID() == $course->getID())
							{
								$gui->addContent("selected");
							}
							$gui->addContent(">".$course_list->getName()."</option>");
							unset ($course_list);
						}					
						$gui->addContent("</select><br>");
						$gui->addContent("Name: <input type=\"text\" name=\"name\" value=\"".$race->getName()."\"><br>");
						$gui->addContent("Reg Date:".DateBox('reg_date', $race->writeRegDate())."<br>Date:".DateBox('date', $race->writeDate())."<br>");
						$gui->addContent("Reward: <input type=\"text\" name=\"base_reward\" size=\"10\" value=\"".$race->getBaseReward()."\"><br>");
						$gui->addContent("Pod Limit: <input type=\"text\" name=\"pod_limit\" size=\"5\" value=\"".$race->getPodLimit()."\"><br>");
						$gui->addContent("Skill level: <input type=\"text\" name=\"skill_level\" size=\"10\" value=\"".$race->getSkillLevel()."\"><br>");
						$gui->addContent("Laps: <input type=\"text\" name=\"laps\" size=\"5\"  value=\"".$race->getLaps()."\"><br>");
						$gui->addContent("Buyin: <input type=\"text\" name=\"buyin\" size=\"10\"  value=\"".$race->getCost()."\"><br>");
						$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"selected\" value=\"".$_REQUEST['selected']."\">\r\n");
						$gui->addContent("</form>\r\n");
					}
				}
				elseif ($_REQUEST['type'] == 3)
				{
					$race = new Race ($_REQUEST['selected']);
					$race->delete();
					$gui->addContent("Race deleted<br><a href=\"races.php?type=3\">Delete Another Race</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");	
				$gui->addContent("<select name=\"selected\">\r\n");
				$races_array = $podracer->listRaces();
				for ($i = 0; $i < sizeof ($races_array); $i++)
				{
					$race = $races_array [$i];
					if (!$race->GetHasRun()){
						$gui->addContent("<option value=\"".$race->getID()."\">".$race->getName()."</option>\r\n");
					}
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