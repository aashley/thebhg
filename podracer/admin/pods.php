<?php
	
	include "../header.php";
	$gui->setTitle("Pod Admin");

	$hunter = new Login_HTTP($coder_id);
		if (in_array($hunter->getID(), $admin))
		{
			if ($_REQUEST['type'] == 1)
			{
				if (isset($_REQUEST['Submit']))
				{
					$part = $podracer->createPod($_REQUEST['name'], $_REQUEST['cat'], (isset($_REQUEST['sale']) ? 1 : 0), $_REQUEST['num'], $_REQUEST['description'], $_REQUEST['cost'], $_REQUEST['traction'], $_REQUEST['turning'], 
					$_REQUEST['acceleration'], $_REQUEST['top_speed'], $_REQUEST['air_brake'], $_REQUEST['cooling'], $_REQUEST['repair']);
					$gui->addContent("Pod created<br><a href=\"pods.php?type=1\">Create Another Pod</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
					$gui->addContent("Name: <input type=\"text\" name=\"name\"><br>");
					$gui->addContent("Description: <textarea cols=\"40\" rows=\"8\" name=\"description\"></textarea><br />");
					$gui->addContent("Cost: <input type=\"text\" name=\"cost\" size=\"10\"><br>");
					$gui->AddContent("Number Available: <input type='text' name='num' size='5'><br />");
						$gui->addContent('For Sale: <input type="checkbox" value="1" name="sale"><br />');
					$gui->addContent("Category: <select name='cat'>\r\n");
					foreach ($podracer->GetCategories() as $id=>$name){
						$gui->AddContent('<option value='.$id.'>'.$name."</option>\r\n");
					}
					$gui->addContent("</select><br />");
					$gui->addContent("Traction: <input type=\"text\" name=\"traction\" size=\"5\"><br>");
					$gui->addContent("Turning: <input type=\"text\" name=\"turning\" size=\"5\"><br>");
					$gui->addContent("Accel: <input type=\"text\" name=\"acceleration\" size=\"5\"><br>");
					$gui->addContent("Top Speed: <input type=\"text\" name=\"top_speed\" size=\"5\"><br>");
					$gui->addContent("Air Brake: <input type=\"text\" name=\"air_brake\" size=\"5\"><br>");
					$gui->addContent("Cooling: <input type=\"text\" name=\"cooling\" size=\"5\"><br>");
					$gui->addContent("Repair: <input type=\"text\" name=\"repair\" size=\"5\"><br>");
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
						$pod = new Pod ($_REQUEST['selected']);
						$pod->setName($_REQUEST['name']);
						$pod->SetDescription($_REQUEST['description']);
						$pod->setCost($_REQUEST['cost']);
						$pod->setCat($_REQUEST['cat']);
						$pod->SetNum($_REQUEST['num']);
						$pod->SetSale((isset($_REQUEST['sale']) ? 1 : 0));
						$pod->setTraction($_REQUEST['traction']);
						$pod->setTurning($_REQUEST['turning']);
						$pod->setAcceleration($_REQUEST['acceleration']);
						$pod->setTopSpeed($_REQUEST['top_speed']);
						$pod->setAirBrake($_REQUEST['air_brake']);
						$pod->setCooling($_REQUEST['cooling']);
						$pod->setRepair($_REQUEST['repair']);
						$gui->addContent("Pod edited<br><a href=\"pods.php?type=2\">Edit Another Pod</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$pod = new Pod ($_REQUEST['selected']);
						$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
						$gui->addContent("Name: <input type=\"text\" name=\"name\" value=\"".$pod->getName()."\"><br>");
						$gui->addContent("Description<textarea cols=\"40\" rows=\"8\" name=\"description\">".$pod->WriteDescription()."</textarea><br />");
						$gui->addContent("Cost: <input type=\"text\" name=\"cost\" value=\"".$pod->getCost()."\" size=\"10\"><br>");
						$gui->AddContent("Number Available: <input type='text' name='num' value=\"".$pod->getNum()."\" size='5'><br />");
						$gui->addContent('For Sale: <input type="checkbox" value="1" name="sale"'.(($pod->GetSale() == 1) ? ' checked' : '').'><br />');
						$gui->addContent("Category: <select name='cat'>\r\n");
						foreach ($podracer->GetCategories() as $id=>$name){
							$gui->AddContent('<option value='.$id.(($pod->GetCat() == $id) ? ' selected' : '').'>'.$name."</option>\r\n");
						}
						$gui->addContent("</select><br />");
						$gui->addContent("Traction: <input type=\"text\" name=\"traction\" value=\"".$pod->getTraction()."\" size=\"5\"><br>");
						$gui->addContent("Turning: <input type=\"text\" name=\"turning\" value=\"".$pod->getTurning()."\" size=\"5\"><br>");
						$gui->addContent("Accel: <input type=\"text\" name=\"acceleration\" value=\"".$pod->getAcceleration()."\" size=\"5\"><br>");
						$gui->addContent("Top Speed: <input type=\"text\" name=\"top_speed\" value=\"".$pod->getTopSpeed()."\" size=\"5\"><br>");
						$gui->addContent("Air Brake: <input type=\"text\" name=\"air_brake\" value=\"".$pod->getAirBrake()."\" size=\"5\"><br>");
						$gui->addContent("Cooling: <input type=\"text\" name=\"cooling\" value=\"".$pod->getCooling()."\" size=\"5\"><br>");
						$gui->addContent("Repair: <input type=\"text\" name=\"repair\" value=\"".$pod->getRepair()."\" size=\"5\"><br>");
						$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"selected\" value=\"".$_REQUEST['selected']."\">\r\n");
						$gui->addContent("</form>\r\n");
					}
				}
				elseif ($_REQUEST['type'] == 3)
				{
					$pod = new Pod ($_REQUEST['selected']);
					$pod->delete();
					$gui->addContent("Pod deleted<br><a href=\"pods.php?type=3\">Delete Another Pod</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");	
				$gui->addContent("<select name=\"selected\">\r\n");
				$pods_array = $podracer->listPods();
				for ($i = 0; $i < sizeof ($pods_array); $i++)
				{
					$pod = $pods_array [$i];
					$gui->addContent("<option value=\"".$pod->getID()."\">".$pod->getName()."</option>\r\n");
					unset($pod);
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