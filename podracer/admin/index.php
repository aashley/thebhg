<?php

	include "../header.php";
	
	$hunter = new Login_HTTP();
	if ($podracer->InTeam($hunter->GetID())) {
		$team_member = $podracer->FindTeamMember($hunter->getID());
		$team = $team_member->getTeam();
		$gui->addContent ("<br>");
		$gui->addContent ("<p align=\"center\"><a href=\"../manual.php\"><img src=\"".$base_url."images/wtf.png\" border=\"0\" alt=\"\"></a><br>Podracer Manual.</p><hr />");
		if ($team_member->isLeader()) {				
			$gui->addContent ("<br><table><tr><td><p align=\"center\"><a href=\"modify_team.php\"><img src=\"".$base_url."images/modify_team.png\" border=\"0\" alt=\"\"></a><br>Rename Team.</p></td><td>");
			$gui->addContent ("<td><p align=\"center\"><a href=\"modify_members.php\"><img src=\"".$base_url."images/members.png\" border=\"0\" alt=\"\"></a><br>Add, Remove and Promote Members.</p></td></tr>");
			$gui->addContent ("<tr><td><p align=\"center\"><a href=\"modify_pods.php\"><img src=\"".$base_url."images/pods.png\" border=\"0\" alt=\"\"></a><br>Sell & Rename Pods.</p></td><td>");
			$gui->addContent ("<td><p align=\"center\"><a href=\"modify_races.php\"><img src=\"".$base_url."images/races.png\" border=\"0\" alt=\"\"></a><br>Signup & Withdraw From Races.</p></td></tr>");
			$gui->addContent ("<tr><td><p align=\"center\"><a href=\"email_team.php\"><img src=\"".$base_url."images/email_team.png\" border=\"0\" alt=\"\"></a><br>Email all the members of your team.</p></td><td>");
			$gui->addContent ("<td><p align=\"center\"><a href=\"distribute_credits.php\"><img src=\"".$base_url."images/distribute.png\" border=\"0\" alt=\"\"></a><br>From the team account to a member's roster account.</p></td></tr>");
			$gui->addContent ("<tr><td><p align=\"center\"><a href=\"add_credits.php\"><img src=\"".$base_url."images/contribute.png\" border=\"0\" alt=\"\"></a><br>To the team's account from a member's roster account.</p></td><td>");
			$gui->addContent ("<td><p align=\"center\"><a href=\"withdraw_race.php\"><img src=\"".$base_url."images/withdraw.png\" border=\"0\" alt=\"\"></a><br>Withdraw from a race.</p></td></tr>");
			$gui->addContent ("<tr><td><p align=\"center\"><a href=\"toggle_team.php\"><img src=\"".$base_url."images/team.png\" border=\"0\" alt=\"\"></a><br>Toggle your accepting new members.</p></td><td>");
			$gui->addContent ("<td><p align=\"center\"><a href=\"delete_team.php\"><img src=\"".$base_url."images/disband.png\" border=\"0\" alt=\"\"></a><br>Divides leftover credits amoung team members evenly.</p></td></tr></table>");
		} else {			
			$gui->addContent ("<p align=\"center\"><a href=\"modify_members.php\"><img src=\"".$base_url."images/members.png\" border=\"0\" alt=\"\"></a><br>View Team Members.</p>");
			$gui->addContent ("<p align=\"center\"><a href=\"modify_pods.php\"><img src=\"".$base_url."images/pods.png\" border=\"0\" alt=\"\"></a><br>View Team Pods.</p>");
			$gui->addContent ("<p align=\"center\"><a href=\"modify_races.php\"><img src=\"".$base_url."images/races.png\" border=\"0\" alt=\"\"></a><br>View Races and Race Results.</p>");
			$gui->addContent ("<p align=\"center\"><a href=\"email_team.php\"><img src=\"".$base_url."images/email_team.png\" border=\"0\" alt=\"\"></a><br>Email all the members of your team.</p>");
			$gui->addContent ("<p align=\"center\"><a href=\"add_credits.php\"><img src=\"".$base_url."images/contribute.png\" border=\"0\" alt=\"\"></a><br>To the team's account from a member's roster account.</p>");
			$gui->addContent ("<p align=\"center\"><a href=\"leave_team.php\"><img src=\"".$base_url."images/leave.png\" border=\"0\" alt=\"\"></a><br>All records of donations will be destroyed.</p>");
		}
	} else {
		$gui->addContent ("<p align=\"center\"><a href=\"join_team.php\"><img src=\"".$base_url."images/members.png\" border=\"0\" alt=\"\"></a><br>Join a team.</p>");
		$gui->addContent ("<p align=\"center\"><a href=\"create_team.php\"><img src=\"".$base_url."images/create.png\" border=\"0\" alt=\"\"></a><br>Create your own team of podracers</p>");
	}
	
	if ($hunter->getID() == 2650) {
		$gui->addContent ("<hr>");
		$gui->addContent ("Bets: <a href=\"bets.php?type=1\">Create</a> | <a href=\"bets.php?type=2\">Edit</a> | <a href=\"bets.php?type=3\">Delete</a><br>");
		$gui->addContent ("Courses: <a href=\"courses.php?type=1\">Create</a> | <a href=\"courses.php?type=2\">Edit</a> | <a href=\"courses.php?type=3\">Delete</a><br>");
		$gui->addContent ("Categories: <a href=\"cats.php?type=1\">Create</a> | <a href=\"cats.php?type=2\">Edit</a> | <a href=\"cats.php?type=3\">Delete</a><br>");
		$gui->addContent ("Part Types: <a href=\"part_types.php?type=1\">Create</a> | <a href=\"part_types.php?type=2\">Edit</a> | <a href=\"part_types.php?type=3\">Delete</a><br>");
		$gui->addContent ("Parts: <a href=\"parts.php?type=1\">Create</a> | <a href=\"parts.php?type=2\">Edit</a> | <a href=\"parts.php?type=3\">Delete</a><br>");
		$gui->addContent ("Pods: <a href=\"pods.php?type=1\">Create</a> | <a href=\"pods.php?type=2\">Edit</a> | <a href=\"pods.php?type=3\">Delete</a><br>");
		$gui->addContent ("Owned Parts: <a href=\"owned_parts.php?type=1\">Create</a> | <a href=\"owned_parts.php?type=2\">Edit</a> | <a href=\"owned_parts.php?type=3\">Delete</a><br>");
		$gui->addContent ("Owned Pods: <a href=\"owned_pods.php?type=1\">Create</a> | <a href=\"owned_pods.php?type=2\">Edit</a> | <a href=\"owned_pods.php?type=3\">Delete</a><br>");
		$gui->addContent ("Races: <a href=\"races.php?type=1\">Create</a> | <a href=\"races.php?type=2\">Edit</a> | <a href=\"races.php?type=3\">Delete</a><br>");
		$gui->addContent ("Race Registrations: <a href=\"race_registrations.php?type=1\">Create</a> | <a href=\"race_registrations.php?type=2\">Edit</a> | <a href=\"race_registrations.php?type=3\">Delete</a><br>");
		$gui->addContent ("Race Results: <a href=\"race_results.php?type=1\">Create</a> | <a href=\"race_results.php?type=2\">Edit</a> | <a href=\"race_results.php?type=3\">Delete</a><br>");
		$gui->addContent ("Teams: <a href=\"teams.php?type=1\">Create</a> | <a href=\"teams.php?type=2\">Edit</a> | <a href=\"teams.php?type=3\">Delete</a><br>");
		$gui->addContent ("Team Members: <a href=\"team_members.php?type=1\">Create</a> | <a href=\"team_members.php?type=2\">Edit</a> | <a href=\"team_members.php?type=3\">Delete</a><br>");
		$gui->addContent ("<br><a href=\"run_race.php\">Run Race</a><br>");
	}
	$gui->setTitle ("Admin");
	$gui->outputGui ();
?>
		