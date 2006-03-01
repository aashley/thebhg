<?php
	
	include "../header.php";

	$hunter = new Login_HTTP($coder_id);
	$gui->setTitle("Course Admin");
	
		if (in_array($hunter->getID(), $admin)) {
			if ($_REQUEST['type'] == 1)	{
				if (isset($_REQUEST['Submit'])){
					$course = $podracer->createCourse($_REQUEST['name'], $_REQUEST['description'], $_REQUEST['traction'], $_REQUEST['turning'], $_REQUEST['accel'], 
					$_REQUEST['speed'], $_REQUEST['brake'], $_REQUEST['cooling'], $_REQUEST['repair']);
					$gui->addContent("Course created<br><a href=\"courses.php?type=1\">Create Another Course</a> | <a href=\"index.php\">Return to Admin</a>");
				} else {
					$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
					$gui->addContent("<table>\r\n");
					$gui->addContent("<tr><td>Name</td><td><input type=\"text\" name=\"name\"></td></tr>\r\n");
					$gui->addContent("<tr><td>Description</td><td><textarea cols=\"40\" rows=\"8\" name=\"description\"></textarea></td></tr>\r\n");
					$gui->addContent("<tr><td>Traction</td><td><input type=\"text\" name=\"traction\" size=\"5\"></td></tr>\r\n");
					$gui->addContent("<tr><td>Turning</td><td><input type=\"text\" name=\"turning\" size=\"5\"></td></tr>\r\n");
					$gui->addContent("<tr><td>Acceleration</td><td><input type=\"text\" name=\"accel\" size=\"5\"></td></tr>\r\n");
					$gui->addContent("<tr><td>Top Speed</td><td><input type=\"text\" name=\"speed\" size=\"5\"></td></tr>\r\n");
					$gui->addContent("<tr><td>Air Brake</td><td><input type=\"text\" name=\"brake\" size=\"5\"></td></tr>\r\n");
					$gui->addContent("<tr><td>Cooling</td><td><input type=\"text\" name=\"cooling\" size=\"5\"></td></tr>\r\n");
					$gui->addContent("<tr><td>Repair</td><td><input type=\"text\" name=\"repair\" size=\"5\"></td></tr>\r\n");
					$gui->addContent("</table>\r\n");
					$gui->addContent("<br><input type=\"Submit\" name=\"Submit\" value=\"Submit\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\">\r\n");
					$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
					$gui->addContent("</form>\r\n");
				}
			} elseif (isset($_REQUEST['selected'])) {
				if ($_REQUEST['type'] == 2) {
					if (isset($_REQUEST['Submit'])) {
						$course = new Course ($_REQUEST['selected']);
						$course->setName($_REQUEST['name']);
						$course->setDescription($_REQUEST['description']);
						$course->setTraction($_REQUEST['traction']);
						$course->setTurning($_REQUEST['turning']);
						$course->setAcceleration($_REQUEST['accel']);
						$course->setTopSpeed($_REQUEST['speed']);
						$course->setAirBrake($_REQUEST['brake']);
						$course->setCooling($_REQUEST['cooling']);
						$course->setRepair($_REQUEST['repair']);
						
			            if (strlen ($_REQUEST['new_damage']) > 1) {
							$course->addRandomDamage($_REQUEST['new_damage']);
			            }
			            if ($_REQUEST['random_damage'] != -1) {
			              $course->removeRandomDamage($_REQUEST['random_damage']);
			            }
			            
						$gui->addContent("Course edited<br><a href=\"courses.php?type=2\">Edit Another Course</a> | <a href=\"index.php\">Return to Admin</a>");
					} else {
						$course = new Course ($_REQUEST['selected']);
						$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
						$gui->addContent("<table>\r\n");
						$gui->addContent("<tr><td>Name</td><td><input type=\"text\" name=\"name\" value=\"".$course->getName()."\"></td></tr>\r\n");
						$gui->addContent("<tr><td>Description</td><td><textarea cols=\"40\" rows=\"8\" name=\"description\">".$course->writeDescription()."</textarea></td></tr>\r\n");
						$gui->addContent("<tr><td>Traction</td><td><input type=\"text\" name=\"traction\" size=\"5\" value=\"".$course->getTraction()."\"></td></tr>\r\n");
						$gui->addContent("<tr><td>Turning</td><td><input type=\"text\" name=\"turning\" size=\"5\" value=\"".$course->getTurning()."\"></td></tr>\r\n");
						$gui->addContent("<tr><td>Acceleration</td><td><input type=\"text\" name=\"accel\" size=\"5\" value=\"".$course->getAcceleration()."\"></td></tr>\r\n");
						$gui->addContent("<tr><td>Top Speed</td><td><input type=\"text\" name=\"speed\" size=\"5\" value=\"".$course->getTopSpeed()."\"></td></tr>\r\n");
						$gui->addContent("<tr><td>Air Brake</td><td><input type=\"text\" name=\"brake\" size=\"5\" value=\"".$course->getAirBrake()."\"></td></tr>\r\n");
						$gui->addContent("<tr><td>Cooling</td><td><input type=\"text\" name=\"cooling\" size=\"5\" value=\"".$course->getCooling()."\"></td></tr>\r\n");
						$gui->addContent("<tr><td>Repair</td><td><input type=\"text\" name=\"repair\" size=\"5\" value=\"".$course->getRepair()."\"></td></tr>\r\n");
						$gui->addContent("<tr><td>Remove Random Damage</td><td><select name=\"random_damage\"><option value=\"-1\">Do not remove</option>");
			            $random_array = $course->getRandomDamage();
			            for ($i = 0; $i < sizeof ($random_array); $i++) {
			              $gui->addContent("<option value=\"".$i."\">".$random_array[$i]."</option>");
			            }
			            $gui->addContent("</select></td></tr>\r\n");
						$gui->addContent("<tr><td>Add Random Damage</td><td>&lt;Name&gt; was <input type=\"text\" name=\"new_damage\"> and has taken damage</td></tr>\r\n");
						$gui->addContent("</table>\r\n");
						$gui->addContent("<br><input type=\"Submit\" name=\"Submit\" value=\"Submit\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"selected\" value=\"".$_REQUEST['selected']."\">\r\n");
						$gui->addContent("</form>\r\n");
					}
				} elseif ($_REQUEST['type'] == 3) {
					$course = new Course($_REQUEST['selected']);
					$course->delete();
					$gui->addContent("Course deleted<br><a href=\"courses.php?type=3\">Delete Another Course</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			} else {
				$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");	
				$gui->addContent("<select name=\"selected\">\r\n");
				$courses_array = $podracer->listCourses();
				for ($i = 0; $i < sizeof ($courses_array); $i++) {
					$course = $courses_array [$i];
					$gui->addContent("<option value=\"".$course->getID()."\">".$course->getName()."</option>\r\n");
					unset($course);
				}		
				$gui->addContent("</select>\r\n");
				$gui->addContent("<input type=\"Submit\" name=\"Select\" value=\"Select\">");
				$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
				$gui->addContent("</form>\r\n");
			}				
			$gui->outputGui();
		} else {
			die(login_failed());
		}
?>