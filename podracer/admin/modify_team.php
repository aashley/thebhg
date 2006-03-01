<?php

	include "../header.php";

	$hunter = new Login_HTTP($coder_id);
			$team_member = $podracer->findTeamMember ($hunter->getID());
			if ($team_member->isLeader()){
				$team = $team_member->getTeam();
				if (isset($_REQUEST['Submit_rename']))
				{					
					if ($team->getName() != stripslashes($_REQUEST['team_name']))
					{
						$gui->addContent ("Team renamed from \"".$team->getName()."\" to \"".stripslashes($_REQUEST['team_name'])."\".<br>");
						$team->setName ($_REQUEST['team_name']);
					}					
					if ($team->getSlogan() != stripslashes($_REQUEST['team_slogan']))
					{
						$gui->addContent ("Slogan changed from \"".$team->getSlogan()."\" to \"".stripslashes($_REQUEST['team_slogan'])."\".<br>");
						$team->setSlogan ($_REQUEST['team_slogan']);
					}						
					if ($team->getUrl() != $_REQUEST['team_url'])
					{
						$gui->addContent ("Website URL changed from \"".$team->getUrl()."\" to \"".$_REQUEST['team_url']."\".<br>");
						$team->setUrl ($_REQUEST['team_url']);
					}					
					if ($team->GetImage() != $_REQUEST['data'])
					{
						$gui->addContent("Updated team image from \"".$team->GetImage()."\" to \"".$_REQUEST['data']."\".<br />");
						$team->setImage($_REQUEST['data']);
					}
				}

				$gui->addContent ("<h2 align=\"center\">Modfiy Team</h2>");
				$gui->addContent ("<form action\"".$_SERVER["PHP_SELF"]."\" method=\"POST\" enctype=\"multipart/form-data\">");
				$gui->addContent ("<table align=\"center\">");
				$gui->addContent ("<tr><td>Team Name:</td><td><input type=\"text\" name=\"team_name\" value=\"".stripslashes($team->getName())."\" size=\"".(strlen($team->getName()) + 5)."\"></td></tr>");
				$gui->addContent ("<tr><td>Team Slogan:</td><td><input type=\"text\" name=\"team_slogan\" value=\"".stripslashes($team->getSlogan())."\" size=\"".(strlen($team->getSlogan()) + 5)."\"></td></tr>");
				$gui->addContent ("<tr><td>Team Website:</td><td><input type=\"text\" name=\"team_url\" value=\"".$team->getUrl()."\" size=\"".((strlen($team->getUrl()) > 0) ? (strlen($team->GetURL()) + 5) : 20)."\"></td></tr>");
				if (strlen($team->getImage()) > 0)
        {
          $gui->addContent ("<tr><td>Current Logo:</td><td><img src=\"".$team->GetImage()."\" width=\"50px\" height=\"50px\"></td></tr>");
				}
        $gui->addContent ("<tr><td>Team Logo:</td><td><input type=\"text\" name=\"data\" value=\"".$team->getImage()."\" size=\"".((strlen($team->getImage()) > 0) ? (strlen($team->GetImage()) + 5) : 20)."\"></td></tr>");
				$gui->addContent ("</table>");				
				$gui->addContent ("<p align=\"center\"><input type=\"Submit\" name=\"Submit_rename\" value=\"Save Changes\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\"></p>");
				$gui->addContent ("</form>\r\n");
				$gui->addContent ("<p align=\"center\"><a href=\"".$base_url."admin/index.php\">Return to admin</a></p><br>");					
			}
			else
			{
				$gui->addContent ("Only a team leader can modify a team.");
			}
			$gui->setTitle ("Modify Team");
			$gui->outputGui ();
?>