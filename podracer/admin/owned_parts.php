<?php
	
	include ("../setup.php");
	$gui_obj->setTitle("Owned Parts Admin");
	
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
					$course_obj = $podracer_obj->createOwned_part($part_id, $pod_id);
					$gui_obj->addContent("Owned part created<br><a href=\"owned_parts.php?type=1\">Create Another Part</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");
					$part_array = $podracer_obj->listParts();
					$gui_obj->addContent("<select name=\"part_id\"><br>");
					for ($i = 0; $i < sizeof ($part_array); $i++)
					{
						$part_obj = $part_array [$i];
						$gui_obj->addContent("<option value=\"".$part_obj->getID()."\">".$part_obj->getName()."</option>\r\n");
						unset ($part_obj);
					}
					$gui_obj->addContent("</select><br>");
					$pods_array = $podracer_obj->listOwned_pods();
					$gui_obj->addContent("<select name=\"pod_id\"><br>");
					for ($i = 0; $i < sizeof ($pods_array); $i++)
					{
						$pod_obj = $pods_array [$i];
						$gui_obj->addContent("<option value=\"".$pod_obj->getID()."\">".$pod_obj->getName()."</option>\r\n");
						unset ($pod_obj);
					}
					$gui_obj->addContent("</select><br>");
					$gui_obj->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">");
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
						$part_obj = new Owned_part ($selected);
						$part_obj->setPart($part_id);
						$part_obj->setPod($pod_id);
						$gui_obj->addContent("Owned part edited<br><a href=\"owned_parts.php?type=2\">Edit Another Part</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$owned_part_obj = new Owned_part ($selected);
						$edit_part_obj = $owned_part_obj->getPart();
						$edit_pod_obj = $owned_part_obj->getPod();
						$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");
						$part_array = $podracer_obj->listParts();
						$gui_obj->addContent("<select name=\"part_id\"><br>");
						for ($i = 0; $i < sizeof ($part_array); $i++)
						{
							$part_obj = $part_array [$i];
							$gui_obj->addContent("<option value=\"".$part_obj->getID()."\"");
							if ($edit_part_obj->getID() == $part_obj->getID())
							{
								$gui_obj->addContent(" selected");
							}
							$gui_obj->addContent(">".$part_obj->getName()."</option>\r\n");
							unset ($part_obj);
						}
						$gui_obj->addContent("</select><br>");
						$pods_array = $podracer_obj->listOwned_pods();
						$gui_obj->addContent("<select name=\"pod_id\"><br>");
						for ($i = 0; $i < sizeof ($pods_array); $i++)
						{
							$pod_obj = $pods_array [$i];
							$gui_obj->addContent("<option value=\"".$pod_obj->getID()."\"");
							if ($edit_pod_obj->getID() == $pod_obj->getID())
							{
								$gui_obj->addContent(" selected");
							}
							$gui_obj->addContent(">".$pod_obj->getName()."</option>\r\n");
							unset ($pod_obj);
						}
						$gui_obj->addContent("</select><br>");
						$gui_obj->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">");
						$gui_obj->addContent("<input type=\"hidden\" name=\"type\" value=\"$type\">\r\n");
						$gui_obj->addContent("</form>\r\n");
					}
				}
				elseif ($type == 3)
				{
					$part_obj = new Owned_part ($selected);
					$part_obj->delete();
					$gui_obj->addContent("Owned part deleted<br><a href=\"owned_parts.php?type=3\">Delete Another Part</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");	
				$gui_obj->addContent("<select name=\"selected\">\r\n");
				$parts_array = $podracer_obj->listOwned_parts();
				for ($i = 0; $i < sizeof ($parts_array); $i++)
				{
					$part_obj = $parts_array [$i];
					$part_type_obj = $part_obj->getPart();
					$pod_obj = $part_obj->getPod();
					$gui_obj->addContent("<option value=\"".$part_obj->getID()."\">".$part_type_obj->getName()." on \"".$pod_obj->getName()."\"</option>\r\n");
					unset($pod_obj);
					unset($part_type_obj);
					unset($part_obj);
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