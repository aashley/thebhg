<?php

	include "../header.php";

	$hunter = new Login_HTTP($coder_id);
	$team_member = $podracer->findTeamMember ($hunter->getID());
	if (!$team_member){
		if (isset($_REQUEST['Submit']))	{
			$part = $podracer->createTeammember($hunter->GetID(), $_REQUEST['team']);
			$team = new Team($_REQUEST['team']);
			$leader = $team->GetLeader();
			$leader->SendeMail($hunter->GetEmail(), 'Notice of new Team Member', $hunter->GetName().' has just joined your podracing team, '.$team->GetName().'. If you do not wish them to be on your team, you can delete them via your membership management options in the admin section.');
			$gui->addContent( "You have joined team ".$team->GetName().". Your next step should be to donate some credits so your Team Leader can buy more pods.");
			$gui->addContent ("<p><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
		} else {	
			$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
			$gui->addContent("Team: <select name=\"team\">");
			$team_array = $podracer->listTeams();
			for ($k = 0; $k < sizeof ($team_array); $k++)
			{
				$team = $team_array [$k];
				if ($team->GetAccepting()){
					$gui->addContent("<option value=\"".$team->getID()."\">".$team->getName()."</option>");
				}
				unset ($team);
			}					
			$gui->addContent("</select><br>");
			$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
			$gui->addContent("</form>\r\n");
		}
	} else {
		$gui->addContent ("You cannot join more than one team at a time.");
		$gui->addContent ("<p><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
	}
	$gui->setTitle ("Join Team");
	$gui->outputGui ();
?>