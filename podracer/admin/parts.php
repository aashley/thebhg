<?php
	
	include ("../setup.php");
	$gui_obj->setTitle("Part Admin");
	
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
					$part_obj = $podracer_obj->createPart($part_type, $name, $description, $cost, $limit, $increase);
					$gui_obj->addContent("Part created<br><a href=\"parts.php?type=1\">Create Another Part</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");
					$gui_obj->addContent("Type: <input type=\"text\" name=\"part_type\"><br>");
					$gui_obj->addContent("Name: <input type=\"text\" name=\"name\"><br>");
					$gui_obj->addContent("Description: <textarea name=\"description\" cols=\"40\" rows=\"8\"></textarea><br>");
					$gui_obj->addContent("Cost: <input type=\"text\" name=\"cost\"><br>");
					$gui_obj->addContent("Limit: <input type=\"text\" name=\"limit\"><br>");
					$gui_obj->addContent("Increase: <input type=\"text\" name=\"increase\"><br>");
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
						$part_obj = new Part ($selected);
						$part_obj->setType($part_type);
						$part_obj->setName($name);
						$part_obj->setDescription($description);
						$part_obj->setCost($cost);
						$part_obj->setLimit($limit);
						$part_obj->setIncrease($increase);
						$gui_obj->addContent("Part edited<br><a href=\"parts.php?type=2\">Edit Another Part</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$part_obj = new Part ($selected);
						$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");
						$gui_obj->addContent("Type: <input type=\"text\" name=\"part_type\" value=\"".$part_obj->getType()."\"><br>");
						$gui_obj->addContent("Name: <input type=\"text\" name=\"name\" value=\"".$part_obj->getName()."\"><br>");
						$gui_obj->addContent("Description: <textarea name=\"description\" cols=\"40\" rows=\"8\">".$part_obj->getDescription()."</textarea><br>");
						$gui_obj->addContent("Cost: <input type=\"text\" name=\"cost\" value=\"".$part_obj->getCost()."\"><br>");
						$gui_obj->addContent("Limit: <input type=\"text\" name=\"limit\" value=\"".$part_obj->getLimit()."\"><br>");
						$gui_obj->addContent("Increase: <input type=\"text\" name=\"increase\" value=\"".$part_obj->getIncrease()."\"><br>");
						$gui_obj->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui_obj->addContent("<input type=\"hidden\" name=\"type\" value=\"$type\">\r\n");
						$gui_obj->addContent("<input type=\"hidden\" name=\"selected\" value=\"$selected\">\r\n");
						$gui_obj->addContent("</form>\r\n");
					}
				}
				elseif ($type == 3)
				{
					$part_obj = new Part ($selected);
					$part_obj->delete();
					$gui_obj->addContent("Course deleted<br><a href=\"parts.php?type=3\">Delete Another Part</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");	
				$gui_obj->addContent("<select name=\"selected\">\r\n");
				$parts_array = $podracer_obj->listParts();
				for ($i = 0; $i < sizeof ($parts_array); $i++)
				{
					$part_obj = $parts_array [$i];
					$gui_obj->addContent("<option value=\"".$part_obj->getID()."\">".$part_obj->getName()."</option>\r\n");
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