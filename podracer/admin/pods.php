<?php
	
	include ("../setup.php");
	$gui_obj->setTitle("Pod Admin");
	
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
					$part_obj = $podracer_obj->createPod($name, $description, $cost, $traction, $turning, $acceleration, $top_speed, $air_brake, $cooling, $repair);
					$gui_obj->addContent("Pod created<br><a href=\"pods.php?type=1\">Create Another Pod</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");
					$gui_obj->addContent("Name: <input type=\"text\" name=\"name\"><br>");
					$gui_obj->addContent("Cost: <input type=\"text\" name=\"cost\"><br>");
					$gui_obj->addContent("Traction: <input type=\"text\" name=\"traction\"><br>");
					$gui_obj->addContent("Turning: <input type=\"text\" name=\"turning\"><br>");
					$gui_obj->addContent("Accel: <input type=\"text\" name=\"acceleration\"><br>");
					$gui_obj->addContent("Top Speed: <input type=\"text\" name=\"top_speed\"><br>");
					$gui_obj->addContent("Air Brake: <input type=\"text\" name=\"air_brake\"><br>");
					$gui_obj->addContent("Cooling: <input type=\"text\" name=\"cooling\"><br>");
					$gui_obj->addContent("Repair: <input type=\"text\" name=\"repair\"><br>");
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
						$pod_obj = new Pod ($selected);
						$pod_obj->setName($name);
						$pod_obj->setCost($cost);
						$pod_obj->setTraction($traction);
						$pod_obj->setTurning($turning);
						$pod_obj->setAcceleration($acceleration);
						$pod_obj->setTop_speed($top_speed);
						$pod_obj->setAir_brake($air_brake);
						$pod_obj->setCooling($cooling);
						$pod_obj->setRepair($repair);
						$gui_obj->addContent("Pod edited<br><a href=\"pods.php?type=2\">Edit Another Pod</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$pod_obj = new Pod ($selected);
						$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");
						$gui_obj->addContent("Name: <input type=\"text\" name=\"name\" value=\"".$pod_obj->getName()."\"><br>");
						$gui_obj->addContent("Cost: <input type=\"text\" name=\"cost\" value=\"".$pod_obj->getCost()."\"><br>");
						$gui_obj->addContent("Traction: <input type=\"text\" name=\"traction\" value=\"".$pod_obj->getTraction()."\"><br>");
						$gui_obj->addContent("Turning: <input type=\"text\" name=\"turning\" value=\"".$pod_obj->getTurning()."\"><br>");
						$gui_obj->addContent("Accel: <input type=\"text\" name=\"acceleration\" value=\"".$pod_obj->getAcceleration()."\"><br>");
						$gui_obj->addContent("Top Speed: <input type=\"text\" name=\"top_speed\" value=\"".$pod_obj->getTop_speed()."\"><br>");
						$gui_obj->addContent("Air Brake: <input type=\"text\" name=\"air_brake\" value=\"".$pod_obj->getAir_brake()."\"><br>");
						$gui_obj->addContent("Cooling: <input type=\"text\" name=\"cooling\" value=\"".$pod_obj->getCooling()."\"><br>");
						$gui_obj->addContent("Repair: <input type=\"text\" name=\"repair\" value=\"".$pod_obj->getRepair()."\"><br>");
						$gui_obj->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui_obj->addContent("<input type=\"hidden\" name=\"type\" value=\"$type\">\r\n");
						$gui_obj->addContent("<input type=\"hidden\" name=\"selected\" value=\"$selected\">\r\n");
						$gui_obj->addContent("</form>\r\n");
					}
				}
				elseif ($type == 3)
				{
					$pod_obj = new Pod ($selected);
					$pod_obj->delete();
					$gui_obj->addContent("Pod deleted<br><a href=\"pods.php?type=3\">Delete Another Pod</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");	
				$gui_obj->addContent("<select name=\"selected\">\r\n");
				$pods_array = $podracer_obj->listPods();
				for ($i = 0; $i < sizeof ($pods_array); $i++)
				{
					$pod_obj = $pods_array [$i];
					$gui_obj->addContent("<option value=\"".$pod_obj->getID()."\">".$pod_obj->getName()."</option>\r\n");
					unset($pod_obj);
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