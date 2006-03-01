<?php
	
	include "../header.php";
	
	$gui->setTitle("Owned Parts Admin");

	$hunter = new Login_HTTP($coder_id);
		if (in_array($hunter->getID(), $admin)){
			if ($_REQUEST['type'] == 1)
			{
				if (isset($_REQUEST['Submit']))
				{
					$course = $podracer->createOwnedPart($_REQUEST['part_id'], $_REQUEST['pod_id']);
					$gui->addContent("Owned part created<br><a href=\"owned_parts.php?type=1\">Create Another Part</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
					$part_array = $podracer->listParts();
					$gui->addContent("<select name=\"part_id\"><br>");
					for ($i = 0; $i < sizeof ($part_array); $i++)
					{
						$part = $part_array [$i];
						$gui->addContent("<option value=\"".$part->getID()."\">".$part->getName()."</option>\r\n");
						unset ($part);
					}
					$gui->addContent("</select><br>");
					$pods_array = $podracer->listOwnedPods();
					$gui->addContent("<select name=\"pod_id\"><br>");
					for ($i = 0; $i < sizeof ($pods_array); $i++)
					{
						$pod = $pods_array [$i];
						$gui->addContent("<option value=\"".$pod->getID()."\">".$pod->getName()."</option>\r\n");
						unset ($pod);
					}
					$gui->addContent("</select><br>");
					$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">");
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
						$part = new OwnedPart ($_REQUEST['selected']);
						$part->setPart($_REQUEST['part_id']);
						$part->setPod($_REQUEST['pod_id']);
						$gui->addContent("Owned part edited<br><a href=\"owned_parts.php?type=2\">Edit Another Part</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$owned_part = new OwnedPart ($_REQUEST['selected']);
						$edit_part = $owned_part->getPart();
						$edit_pod = $owned_part->getPod();
						$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
						$part_array = $podracer->listParts();
						$gui->addContent("<select name=\"part_id\"><br>");
						for ($i = 0; $i < sizeof ($part_array); $i++)
						{
							$part = $part_array [$i];
							$gui->addContent("<option value=\"".$part->getID()."\"");
							if ($edit_part->getID() == $part->getID())
							{
								$gui->addContent(" selected");
							}
							$gui->addContent(">".$part->getName()."</option>\r\n");
							unset ($part);
						}
						$gui->addContent("</select><br>");
						$pods_array = $podracer->listOwnedPods();
						$gui->addContent("<select name=\"pod_id\"><br>");
						for ($i = 0; $i < sizeof ($pods_array); $i++)
						{
							$pod = $pods_array [$i];
							$gui->addContent("<option value=\"".$pod->getID()."\"");
							if ($edit_pod->getID() == $pod->getID())
							{
								$gui->addContent(" selected");
							}
							$gui->addContent(">".$pod->getName()."</option>\r\n");
							unset ($pod);
						}
						$gui->addContent("</select><br>");
						$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">");
						$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"selected\" value=\"".$_REQUEST['selected']."\">\r\n");
						$gui->addContent("</form>\r\n");
					}
				}
				elseif ($_REQUEST['type'] == 3)
				{
					$part = new OwnedPart ($_REQUEST['selected']);
					$part->delete();
					$gui->addContent("Owned part deleted<br><a href=\"owned_parts.php?type=3\">Delete Another Part</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");	
				$gui->addContent("<select name=\"selected\">\r\n");
				$parts_array = $podracer->listOwnedParts();
				for ($i = 0; $i < sizeof ($parts_array); $i++)
				{
					$part = $parts_array [$i];
					$part_type = $part->getPart();
					$pod = $part->getPod();
					$gui->addContent("<option value=\"".$part->getID()."\">".$part_type->getName()." on \"".$pod->getName()."\"</option>\r\n");
					unset($pod);
					unset($part_type);
					unset($part);
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