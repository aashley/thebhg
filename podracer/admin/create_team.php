<?php

	include "../header.php";
	
	$hunter = new Login_HTTP();
	if (!$podracer->InTeam($hunter->GetID())) {
		if (isset($_REQUEST['Submit']))	{
			$team = $podracer->CreateTeam($_REQUEST['team_name'], 0, $hunter->getID(), $_REQUEST['slogan'], $_REQUEST['url'], $_REQUEST['image']);
			$team_member = $podracer->CreateTeamMember($hunter->getID(), $team->getID());
			$gui->addContent ("<p>".stripslashes($_REQUEST['team_name'])." successfully created.</p>");
			$gui->addContent ("<p><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
		} else {
			$gui->addContent ("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"POST\">\r\n");
			$gui->addContent ("<table>\r\n");
			$gui->addContent ("<tr><td>Team name</td><td><input type=\"text\" name=\"team_name\"></td></tr>\r\n");
			$gui->addContent ("<tr><td>Slogan</td><td><input type=\"text\" name=\"slogan\" size=\"20\"></td></tr>\r\n");
			$gui->addContent ("<tr><td>Website URL</td><td><input type=\"text\" name=\"url\" size=\"20\"></td></tr>\r\n");
			$gui->addContent ("<tr><td>Logo URL</td><td><input type=\"text\" name=\"image\" size=\"20\"></td></tr>\r\n");
			$gui->addContent ("</table>\r\n");
			$gui->addContent ("<br><input type=\"Submit\" name=\"Submit\" value=\"Submit\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\">\r\n");
			$gui->addContent ("</form>\r\n");
		}
	} else {
		$gui->addContent ("Only a hunter who is not a member of a team can create his own team.");
	}
	$gui->setTitle ("Create Team");
	$gui->outputGui ();
?>