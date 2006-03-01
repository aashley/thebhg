<?php
	
	include "../header.php";
	$gui->setTitle("Part Type Admin");

	$hunter = new Login_HTTP($coder_id);
		if (in_array($hunter->getID(), $admin))
		{
			if ($_REQUEST['type'] == 1)
			{
				if (isset($_REQUEST['Submit']))
				{
					$part = $podracer->CreatePartType(addslashes($_REQUEST['name']), addslashes($_REQUEST['upgrades']), addslashes($_REQUEST['desc']));
					$gui->addContent("Category created<br><a href=\"cats.php?type=1\">Create Another category</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
					$gui->addContent("Name: <input type=\"text\" name=\"name\"><br>");
					$gui->addContent("Updates: <input type=\"text\" name=\"upgrades\"><br>");
					$gui->addContent("Description: <textarea cols=\"40\" rows=\"8\" name=\"desc\"></textarea><br />");
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
						$part = new PartType($_REQUEST['selected']);
						$part->SetName($_REQUEST['name']);
						$part->SetUpdates($_REQUEST['upgrades']);
						$part->SetDescription($_REQUEST['desc']);
						$gui->addContent("Category edited<br><a href=\"cats.php?type=2\">Edit Another Category</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$part = new PartType($_REQUEST['selected']);
						
						$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
						$gui->addContent("Name: <input type=\"text\" name=\"name\" value=\"".$part->GetName()."\"><br>");
						$gui->addContent("Updates: <input type=\"text\" name=\"upgrades\" value=\"".$part->GetUpdates()."\"><br>");
						$gui->addContent("Description: <textarea cols=\"40\" rows=\"8\" name=\"desc\">".$part->GetDescription()."</textarea><br />");
						$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"selected\" value=\"".$_REQUEST['selected']."\">\r\n");
						$gui->addContent("</form>\r\n");
					}
				}
				elseif ($_REQUEST['type'] == 3)
				{
					$part = new PartType($_REQUEST['selected']);
					$part->delete();
					$gui->addContent("Category deleted<br><a href=\"pods.php?type=3\">Delete Another Category</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");	
				$gui->addContent("<select name=\"selected\">\r\n");
				foreach ($podracer->ListPartTypes() as $part){
						$gui->AddContent('<option value='.$part->Getid().'>'.$part->Getname()."</option>\r\n");
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