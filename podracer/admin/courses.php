<?php
	
	include ("../setup.php");
	$gui_obj->setTitle("Course Admin");
	
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
					$course_obj = $podracer_obj->createCourse($name, $description, $traction, $turning, $accel, $speed, $brake, $cooling, $repair);
					$gui_obj->addContent("Course created<br><a href=\"courses.php?type=1\">Create Another Course</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui_obj->addContent("<form action=\"".$PHP_SELF."\" method=\"Post\">\r\n");
					$gui_obj->addContent("<table>\r\n");
					$gui_obj->addContent("<tr><td>Name</td><td><input type=\"text\" name=\"name\"></td></tr>\r\n");
					$gui_obj->addContent("<tr><td>Description</td><td><textarea cols=\"40\" rows=\"8\" name=\"description\"></textarea></td></tr>\r\n");
					$gui_obj->addContent("<tr><td>Traction</td><td><input type=\"text\" name=\"traction\"></td></tr>\r\n");
					$gui_obj->addContent("<tr><td>Turning</td><td><input type=\"text\" name=\"turning\"></td></tr>\r\n");
					$gui_obj->addContent("<tr><td>Acceleration</td><td><input type=\"text\" name=\"accel\"></td></tr>\r\n");
					$gui_obj->addContent("<tr><td>Top Speed</td><td><input type=\"text\" name=\"speed\"></td></tr>\r\n");
					$gui_obj->addContent("<tr><td>Air Brake</td><td><input type=\"text\" name=\"brake\"></td></tr>\r\n");
					$gui_obj->addContent("<tr><td>Cooling</td><td><input type=\"text\" name=\"cooling\"></td></tr>\r\n");
					$gui_obj->addContent("<tr><td>Repair</td><td><input type=\"text\" name=\"repair\"></td></tr>\r\n");
					$gui_obj->addContent("</table>\r\n");
					$gui_obj->addContent("<br><input type=\"Submit\" name=\"Submit\" value=\"Submit\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\">\r\n");
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
						$course_obj = new Course ($selected);
						$course_obj->setName($name);
						$course_obj->setDescription($description);
						$course_obj->setTraction($traction);
						$course_obj->setTurning($turning);
						$course_obj->setAcceleration($accel);
						$course_obj->setTop_speed($speed);
						$course_obj->setAir_brake($brake);
						$course_obj->setCooling($cooling);
						$course_obj->setRepair($repair);
            if (strlen ($new_damage) > 1)
            {
						  $course_obj->addRandom_damage($new_damage);
            }
            if ($random_damage != -1)
            {
              $course_obj->removeRandom_damage($random_damage);
            }
						$gui_obj->addContent("Course edited<br><a href=\"courses.php?type=2\">Edit Another Course</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$course_obj = new Course ($selected);
						$gui_obj->addContent("<form action=\"".$PHP_SELF."\" method=\"Post\">\r\n");
						$gui_obj->addContent("<table>\r\n");
						$gui_obj->addContent("<tr><td>Name</td><td><input type=\"text\" name=\"name\" value=\"".$course_obj->getName()."\"></td></tr>\r\n");
						$gui_obj->addContent("<tr><td>Description</td><td><textarea cols=\"40\" rows=\"8\" name=\"description\">".$course_obj->getDescription()."</textarea></td></tr>\r\n");
						$gui_obj->addContent("<tr><td>Traction</td><td><input type=\"text\" name=\"traction\" value=\"".$course_obj->getTraction()."\"></td></tr>\r\n");
						$gui_obj->addContent("<tr><td>Turning</td><td><input type=\"text\" name=\"turning\" value=\"".$course_obj->getTurning()."\"></td></tr>\r\n");
						$gui_obj->addContent("<tr><td>Acceleration</td><td><input type=\"text\" name=\"accel\" value=\"".$course_obj->getAcceleration()."\"></td></tr>\r\n");
						$gui_obj->addContent("<tr><td>Top Speed</td><td><input type=\"text\" name=\"speed\" value=\"".$course_obj->getTop_speed()."\"></td></tr>\r\n");
						$gui_obj->addContent("<tr><td>Air Brake</td><td><input type=\"text\" name=\"brake\" value=\"".$course_obj->getAir_brake()."\"></td></tr>\r\n");
						$gui_obj->addContent("<tr><td>Cooling</td><td><input type=\"text\" name=\"cooling\" value=\"".$course_obj->getCooling()."\"></td></tr>\r\n");
						$gui_obj->addContent("<tr><td>Repair</td><td><input type=\"text\" name=\"repair\" value=\"".$course_obj->getRepair()."\"></td></tr>\r\n");
						$gui_obj->addContent("<tr><td>RemoveRandom Damage</td><td><select name=\"random_damage\"><option value=\"-1\">Do not remove</option>");
            $random_array = $course_obj->getRandom_damage();
            for ($i = 0; $i < sizeof ($random_array); $i++)
            {
              $gui_obj->addContent("<option value=\"".$i."\">".$random_array[$i]."</option>");
            }
            $gui_obj->addContent("</select></td></tr>\r\n");
						$gui_obj->addContent("<tr><td>Add Random Damage</td><td><input type=\"text\" name=\"new_damage\"></td></tr>\r\n");
						$gui_obj->addContent("</table>\r\n");
						$gui_obj->addContent("<br><input type=\"Submit\" name=\"Submit\" value=\"Submit\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\">\r\n");
						$gui_obj->addContent("<input type=\"hidden\" name=\"type\" value=\"$type\">\r\n");
						$gui_obj->addContent("<input type=\"hidden\" name=\"selected\" value=\"$selected\">\r\n");
						$gui_obj->addContent("</form>\r\n");
					}
				}
				elseif ($type == 3)
				{
					$course_obj = new Course ($selected);
					$course_obj->delete();
					$gui_obj->addContent("Course deleted<br><a href=\"courses.php?type=3\">Delete Another Course</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui_obj->addContent("<form action=\"".$PHP_SELF."\" method=\"Post\">\r\n");	
				$gui_obj->addContent("<select name=\"selected\">\r\n");
				$courses_array = $podracer_obj->listCourses();
				for ($i = 0; $i < sizeof ($courses_array); $i++)
				{
					$course_obj = $courses_array [$i];
					$gui_obj->addContent("<option value=\"".$course_obj->getID()."\">".$course_obj->getName()."</option>\r\n");
					unset($course_obj);
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