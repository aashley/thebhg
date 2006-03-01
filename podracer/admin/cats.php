<?php
	
	include "../header.php";
	$gui->setTitle("Junkyard Category Admin");

	$hunter = new Login_HTTP($coder_id);
		if (in_array($hunter->getID(), $admin))
		{
			if ($_REQUEST['type'] == 1)
			{
				if (isset($_REQUEST['Submit']))
				{
					$part = $podracer->CreateCategory(addslashes($_REQUEST['name']));
					$gui->addContent("Category created<br><a href=\"cats.php?type=1\">Create Another category</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
					$gui->addContent("Name: <input type=\"text\" name=\"name\"><br>");
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
						$podracer->EditCateory($_REQUEST['selected'], addslashes($_REQUEST['name']));
						$gui->addContent("Category edited<br><a href=\"cats.php?type=2\">Edit Another Category</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$array = array();
						foreach ($podracer->GetCategories() as $id=>$name){
							$array[$id] = $name;
						}
						
						$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
						$gui->addContent("Name: <input type=\"text\" name=\"name\" value=\"".$array[$_REQUEST['selected']]."\"><br>");
						$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"selected\" value=\"".$_REQUEST['selected']."\">\r\n");
						$gui->addContent("</form>\r\n");
					}
				}
				elseif ($_REQUEST['type'] == 3)
				{
					$podracer->DeleteCategory($_REQUEST['selected']);
					$gui->addContent("Category deleted<br><a href=\"pods.php?type=3\">Delete Another Category</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");	
				$gui->addContent("<select name=\"selected\">\r\n");
				foreach ($podracer->GetCategories() as $id=>$name){
						$gui->AddContent('<option value='.$id.'>'.$name."</option>\r\n");
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