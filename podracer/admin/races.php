<?php
	
	include ("../setup.php");
	$gui_obj->setTitle("Race Admin");
	
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
          $date = mktime (0, 0, 0, $month, $day, $year);
					$reg_date = mktime (0, 0, 0, $reg_month, $reg_day, $reg_year);
					$part_obj = $podracer_obj->createRace($course, $name, $date, $reg_date, $base_reward, $pod_limit, $skill_level, $laps, $buyin);
					$gui_obj->addContent("Race created<br><a href=\"races.php?type=1\">Create Another Race</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");
					$gui_obj->addContent("Course: <select name=\"course\">");
					$courses_array = $podracer_obj->listCourses();
					for ($k = 0; $k < sizeof ($courses_array); $k++)
					{
						$course_list_obj = $courses_array [$k];
						$gui_obj->addContent("<option value=\"".$course_list_obj->getID()."\">".$course_list_obj->getName()."</option>");
						unset ($course_list_obj);
					}					
					$gui_obj->addContent("</select><br>");
					$gui_obj->addContent("Name: <input type=\"text\" name=\"name\"><br>");
					$gui_obj->addContent("Date: 
          <select name=\"month\">
          <option value=\"1\">January</option>
          <option value=\"2\">Febuary</option>
          <option value=\"3\">March</option>
          <option value=\"4\">April</option>
          <option value=\"5\">May</option>
          <option value=\"6\">June</option>
          <option value=\"7\">July</option>
          <option value=\"8\">August</option>
          <option value=\"9\">September</option>
          <option value=\"10\">October</option>
          <option value=\"11\">November</option>
          <option value=\"12\">December</option>
          </select> / 
          <input type=\"text\" size=\"2\" name=\"day\"> / 
          <select name=\"year\">
          <option value=\"2002\">2002</option>
          <option value=\"2003\">2003</option>
          </select><br>");
					$gui_obj->addContent("Reg Date: 
          <select name=\"reg_month\">
          <option value=\"1\">January</option>
          <option value=\"2\">Febuary</option>
          <option value=\"3\">March</option>
          <option value=\"4\">April</option>
          <option value=\"5\">May</option>
          <option value=\"6\">June</option>
          <option value=\"7\">July</option>
          <option value=\"8\">August</option>
          <option value=\"9\">September</option>
          <option value=\"10\">October</option>
          <option value=\"11\">November</option>
          <option value=\"12\">December</option>
          </select> / 
          <input type=\"text\" size=\"2\" name=\"reg_day\"> / 
          <select name=\"reg_year\">
          <option value=\"2002\">2002</option>
          <option value=\"2003\">2003</option>
          </select><br>");
					$gui_obj->addContent("Reward: <input type=\"text\" name=\"base_reward\"><br>");
					$gui_obj->addContent("Pod Limit: <input type=\"text\" name=\"pod_limit\"><br>");
					$gui_obj->addContent("Skill level: <input type=\"text\" name=\"skill_level\"><br>");
					$gui_obj->addContent("Laps: <input type=\"text\" name=\"laps\"><br>");
					$gui_obj->addContent("Buyin: <input type=\"text\" name=\"buyin\"><br>");
					$gui_obj->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
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
						$race_obj = new Race ($selected);						
						$race_obj->setCourse($course);
						$race_obj->setName($name);
						$race_obj->setDate($date);
						$race_obj->setReg_date($reg_date);
						$race_obj->setBase_reward($base_reward);
						$race_obj->setPod_limit($pod_limit);
						$race_obj->setSkill_level($skill_level);
						$race_obj->setLaps($laps);
						$race_obj->setCost($buyin);
						$gui_obj->addContent("Race edited<br><a href=\"races.php?type=2\">Edit Another Race</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$race_obj = new Race ($selected);
						$course_obj = $race_obj->getCourse();
						$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");						
						$gui_obj->addContent("Course: <select name=\"course\">");
						$courses_array = $podracer_obj->listCourses();
						for ($k = 0; $k < sizeof ($courses_array); $k++)
						{
							$course_list_obj = $courses_array [$k];
							$gui_obj->addContent("<option value=\"".$course_list_obj->getID()."\"");
							if ($course_list_obj->getID() == $course_obj->getID())
							{
								$gui_obj->addContent("selected");
							}
							$gui_obj->addContent(">".$course_list_obj->getName()."</option>");
							unset ($course_list_obj);
						}					
						$gui_obj->addContent("</select><br>");
						$gui_obj->addContent("Name: <input type=\"text\" name=\"name\" value=\"".$race_obj->getName()."\"><br>");
						$gui_obj->addContent("Date: <input type=\"text\" name=\"date\" value=\"".$race_obj->getDate()."\"><br>");
						$gui_obj->addContent("Reg Date: <input type=\"text\" name=\"reg_date\" value=\"".$race_obj->getReg_date()."\"><br>");
						$gui_obj->addContent("Reward: <input type=\"text\" name=\"base_reward\" value=\"".$race_obj->getBase_reward()."\"><br>");
						$gui_obj->addContent("Pod Limit: <input type=\"text\" name=\"pod_limit\" value=\"".$race_obj->getPod_limit()."\"><br>");
						$gui_obj->addContent("Skill level: <input type=\"text\" name=\"skill_level\" value=\"".$race_obj->getSkill_level()."\"><br>");
						$gui_obj->addContent("Laps: <input type=\"text\" name=\"laps\" value=\"".$race_obj->getLaps()."\"><br>");
						$gui_obj->addContent("Buyin: <input type=\"text\" name=\"buyin\" value=\"".$race_obj->getCost()."\"><br>");
						$gui_obj->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui_obj->addContent("<input type=\"hidden\" name=\"type\" value=\"$type\">\r\n");
						$gui_obj->addContent("<input type=\"hidden\" name=\"selected\" value=\"$selected\">\r\n");
						$gui_obj->addContent("</form>\r\n");
					}
				}
				elseif ($type == 3)
				{
					$race_obj = new Race ($selected);
					$race_obj->delete();
					$gui_obj->addContent("Race deleted<br><a href=\"races.php?type=3\">Delete Another Race</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");	
				$gui_obj->addContent("<select name=\"selected\">\r\n");
				$races_array = $podracer_obj->listRaces();
				for ($i = 0; $i < sizeof ($races_array); $i++)
				{
					$race_obj = $races_array [$i];
					$gui_obj->addContent("<option value=\"".$race_obj->getID()."\">".$race_obj->getName()."</option>\r\n");
					unset($race_obj);
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