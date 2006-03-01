<?php

	include "../header.php";

	$hunter = new Login_HTTP($coder_id);
	$team_member = $podracer->findTeamMember ($hunter->getID());
	$team = $team_member->getTeam();
	if (isset($_REQUEST['sure'])) {
		$team_member->delete();
		$gui->addContent ("<p>You have left ".$team->getName()."</p>");
		$gui->addContent ("<p><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
	} else {
		$gui->addContent ("Are you sure you want to leave ".$team->getName()."?<br><br>");
		$gui->addContent ("If you do, you will lose all access to any credits you have donated to the 
		teams account. If you don't wish for this to happen, contact your team leader and have him give you
		your share of the credits before your leave the team. It will be impossible for you to get the credits
		from your leader, if you leave the team now. If you are sure you want to continue...<br><br>
		<a href=\"".$base_url."admin/leave_team.php?sure=1\">Click here to be removed from your team</a>");
	}
	$gui->setTitle ("Leave Team");
	$gui->outputGui ();
?>