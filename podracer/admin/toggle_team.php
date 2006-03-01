<?php

	include "../header.php";

	$hunter = new Login_HTTP($coder_id);
	$team_member = $podracer->findTeamMember ($hunter->getID());
	if ($team_member->isLeader()){
		$team = $team_member->getTeam();
		if (isset($_REQUEST['Submit']))	{
			if ($team->SetAccepting($_REQUEST['Accepting'])){
				$gui->addContent ('The '.$team->GetName().' is ');
				if ($_REQUEST['Accepting']){
					$gui->addContent ('now');
				} else {
					$gui->addContent ('no longer');
				}
				$gui->addContent (' accepting new members.');
				$gui->addContent ("<p><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
			}
		} else {
		  $gui->addContent ("<h2 align=\"center\">Change Accepting</h2>\r\n");
			$gui->addContent ("<br>Your team, ".$team->GetName()." is currently ".($team->GetAccepting() ? '' : 'not')." accepting new members. To change this, please <a href=\"".$base_url."admin/toggle_team.php?Submit=1&Accepting=".($team->GetAccepting() ? 0 : 1)."\">Click here to flip the toggle</a>.");
			$gui->addContent ("<p><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
		}
	} else {
		$gui->addContent ("Only a team leader can toggle team Accepting.");
	}
	$gui->setTitle ("Toggle Accepting");
	$gui->outputGui ();
?>