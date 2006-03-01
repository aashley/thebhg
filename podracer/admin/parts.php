<?php
	
	include "../header.php";
	
	$gui->setTitle("Part Admin");

	$hunter = new Login_HTTP($coder_id);
		if (in_array($hunter->getID(), $admin))
		{
			if ($_REQUEST['type'] == 1)
			{
				if (isset($_REQUEST['Submit']))
				{
					$part = $podracer->createPart($_REQUEST['part_type'], (isset($_REQUEST['sale']) ? 1 : 0), $_REQUEST['name'], $_REQUEST['description'], $_REQUEST['cost'], 
					$_REQUEST['limit'], $_REQUEST['inc']);
					$gui->addContent("Part created<br><a href=\"parts.php?type=1\">Create Another Part</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$obs = array();
					foreach ($podracer->ListPartTypes() as $types){
						$obs[] = '<option value="'.$types->GetID().'">'.$types->GetName().'</option>';
					}
					
					$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
					$gui->addContent("Type: <select name=\"part_type\">".implode('', $obs)."</select><br>");
					$gui->addContent("Name: <input type=\"text\" name=\"name\"><br>");
					$gui->addContent("Description: <textarea name=\"description\" cols=\"40\" rows=\"8\"></textarea><br>");
					$gui->addContent("Cost: <input type=\"text\" name=\"cost\"><br>");
					$gui->addContent('For Sale: <input type="checkbox" value="1" name="sale"><br />');
					$gui->addContent("Limit: <input type=\"text\" name=\"limit\"><br>");
					$gui->addContent("<b>Inreases</b><br>");
					$gui->addContent("Traction: <input type=\"text\" name=\"inc[traction]\"><br>");
					$gui->addContent("Turning: <input type=\"text\" name=\"inc[turning]\"><br>");
					$gui->addContent("Acceleration: <input type=\"text\" name=\"inc[acceleration]\"><br>");
					$gui->addContent("Top Speed: <input type=\"text\" name=\"inc[top_speed]\"><br>");
					$gui->addContent("Air Brake: <input type=\"text\" name=\"inc[air_brake]\"><br>");
					$gui->addContent("Cooling: <input type=\"text\" name=\"inc[cooling]\"><br>");
					$gui->addContent("Repair: <input type=\"text\" name=\"inc[repair]\"><br>");
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
						$part = new Part ($_REQUEST['selected']);
						$part->setType($_REQUEST['part_type']);
						$part->setName($_REQUEST['name']);
						$part->setDescription($_REQUEST['description']);
						$part->setCost($_REQUEST['cost']);
						$part->SetSale($_REQUEST['sale']);
						$part->setLimit($_REQUEST['limit']);
						$part->setIncrease($_REQUEST['inc']);
						$gui->addContent("Part edited<br><a href=\"parts.php?type=2\">Edit Another Part</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$part = new Part ($_REQUEST['selected']);
						$obs = array();
						foreach ($podracer->ListPartTypes() as $typa){
							$typ = $part->getType();
							$se = ($typ->GetID() == $typa->GetID());
							$obs[] = '<option value="'.$typa->GetID().'"'.($se ? ' selected' : '').'>'.$typa->GetName().'</option>';
						}
						$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
						$gui->addContent("Type: <select name=\"part_type\">".implode('', $obs)."</select><br>");
						$gui->addContent("Name: <input type=\"text\" name=\"name\" value=\"".$part->getName()."\"><br>");
						$gui->addContent("Description: <textarea name=\"description\" cols=\"40\" rows=\"8\">".$part->getDescription()."</textarea><br>");
						$gui->addContent("Cost: <input type=\"text\" name=\"cost\" value=\"".$part->getCost()."\"><br>");
						$gui->addContent('For Sale: <input type="checkbox" value="1" name="sale"'.($part->GetSale() ? ' checked' : '').'><br />');
						$gui->addContent("Limit: <input type=\"text\" name=\"limit\" value=\"".$part->getLimit()."\"><br>");
						$gui->addContent("<b>Inreases</b><br>");
						$gui->addContent("Traction: <input type=\"text\" name=\"inc[traction]\" value=\"".$part->getIncrease('traction')."\"><br>");
						$gui->addContent("Turning: <input type=\"text\" name=\"inc[turning]\" value=\"".$part->getIncrease('turning')."\"><br>");
						$gui->addContent("Acceleration: <input type=\"text\" name=\"inc[acceleration]\" value=\"".$part->getIncrease('acceleration')."\"><br>");
						$gui->addContent("Top Speed: <input type=\"text\" name=\"inc[top_speed]\" value=\"".$part->getIncrease('top_speed')."\"><br>");
						$gui->addContent("Air Brake: <input type=\"text\" name=\"inc[air_brake]\" value=\"".$part->getIncrease('air_brake')."\"><br>");
						$gui->addContent("Cooling: <input type=\"text\" name=\"inc[cooling]\" value=\"".$part->getIncrease('cooling')."\"><br>");
						$gui->addContent("Repair: <input type=\"text\" name=\"inc[repair]\" value=\"".$part->getIncrease('repair')."\"><br>");
						$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"selected\" value=\"".$_REQUEST['selected']."\">\r\n");
						$gui->addContent("</form>\r\n");
					}
				}
				elseif ($_REQUEST['type'] == 3)
				{
					$part = new Part ($_REQUEST['selected']);
					$part->delete();
					$gui->addContent("Part deleted<br><a href=\"parts.php?type=3\">Delete Another Part</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");	
				$gui->addContent("<select name=\"selected\">\r\n");
				$parts_array = $podracer->listParts();
				for ($i = 0; $i < sizeof ($parts_array); $i++)
				{
					$part = $parts_array [$i];
					$gui->addContent("<option value=\"".$part->getID()."\">".$part->getName()."</option>\r\n");
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