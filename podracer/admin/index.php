<?php

	include "../setup.php";
	
	if (!isset($PHP_AUTH_USER)) 
	{
		die(login_failed());
	} 
	else 
	{  
		//Login object from the BHG roster
		$hunter_obj = new Login ($PHP_AUTH_USER, $PHP_AUTH_PW, $coder_id);
		$exists_result = $db_obj->query ("SELECT COUNT(*) AS num FROM podracer_team_members WHERE bhg_id = ".$hunter_obj->getID());
		if (($hunter_obj->IsValid()) || ($hunter_obj->getID() == 230))
		{
			if (mysql_result ($exists_result, 0, "num") >= 1)
			{
				$team_member_obj = $podracer_obj->findTeam_member ($hunter_obj->getID());
				$team_obj = $team_member_obj->getTeam();
        $gui_obj->addContent ("<br>");
				if ($team_member_obj->isLeader())
				{				
					$gui_obj->addContent ("<br><table><tr><td><p align=\"center\"><a href=\"modify_team.php\"><img src=\"".$base_url."images/modify_team.png\" border=\"0\" alt=\"\"></a><br>Rename Team and Pods, and Pods.</p></td><td>");
					$gui_obj->addContent ("<td><p align=\"center\"><a href=\"modify_members.php\"><img src=\"".$base_url."images/members.png\" border=\"0\" alt=\"\"></a><br>Add, Remove and promote Members.</p></td></tr>");
					$gui_obj->addContent ("<tr><td><p align=\"center\"><a href=\"modify_pods.php\"><img src=\"".$base_url."images/pods.png\" border=\"0\" alt=\"\"></a><br>Sell & Rename Pods.</p></td><td>");
					$gui_obj->addContent ("<td><p align=\"center\"><a href=\"modify_races.php\"><img src=\"".$base_url."images/races.png\" border=\"0\" alt=\"\"></a><br>Signup & Withdraw From Races.</p></td></tr>");
					$gui_obj->addContent ("<tr><td><p align=\"center\"><a href=\"email_team.php\"><img src=\"".$base_url."images/email_team.png\" border=\"0\" alt=\"\"></a><br>Email all the members of your team.</p></td><td>");
					$gui_obj->addContent ("<td><p align=\"center\"><a href=\"distribute_credits.php\"><img src=\"".$base_url."images/distribute.png\" border=\"0\" alt=\"\"></a><br>From the team account to a member's roster account.</p></td></tr>");
					$gui_obj->addContent ("<tr><td><p align=\"center\"><a href=\"add_credits.php\"><img src=\"".$base_url."images/contribute.png\" border=\"0\" alt=\"\"></a><br>To the team's account from a member's roster account.</p></td><td>");
					$gui_obj->addContent ("<td><p align=\"center\"><a href=\"delete_team.php\"><img src=\"".$base_url."images/disband.png\" border=\"0\" alt=\"\"></a><br>Divides leftover credits amoung team members evenly.</p></td></tr></table>");
				}
				else
				{			
					$gui_obj->addContent ("<p align=\"center\"><a href=\"modify_members.php\"><img src=\"".$base_url."images/members.png\" border=\"0\" alt=\"\"></a><br>View Team Members.</p>");
					$gui_obj->addContent ("<p align=\"center\"><a href=\"modify_pods.php\"><img src=\"".$base_url."images/pods.png\" border=\"0\" alt=\"\"></a><br>View Team Pods.</p>");
					$gui_obj->addContent ("<p align=\"center\"><a href=\"modify_races.php\"><img src=\"".$base_url."images/races.png\" border=\"0\" alt=\"\"></a><br>View Races and Race Results.</p>");
					$gui_obj->addContent ("<p align=\"center\"><a href=\"email_team.php\"><img src=\"".$base_url."images/email_team.png\" border=\"0\" alt=\"\"></a><br>Email all the members of your team.</p>");
					$gui_obj->addContent ("<p align=\"center\"><a href=\"add_credits.php\"><img src=\"".$base_url."images/contribute.png\" border=\"0\" alt=\"\"></a><br>To the team's account from a member's roster account.</p>");
					$gui_obj->addContent ("<p align=\"center\"><a href=\"leave_team.php\"><img src=\"".$base_url."images/leave.png\" border=\"0\" alt=\"\"></a><br>All records of donations will be destroyed.</p>");
				}
			}
			else
			{
				$gui_obj->addContent ("<p align=\"center\"><a href=\"create_team.php\"><img src=\"".$base_url."images/create.png\" border=\"0\" alt=\"\"></a><br>Create your own team of podracers</p>");
			}
			if ($hunter_obj->getID() == 230)
			{
				$gui_obj->addContent ("<hr><a href=\"../bhgnews/news-admin.php\">News Admin</a><br>");
				$gui_obj->addContent ("Bets: <a href=\"bets.php?type=1\">Create</a> | <a href=\"bets.php?type=2\">Edit</a> | <a href=\"bets.php?type=3\">Delete</a><br>");
				$gui_obj->addContent ("Courses: <a href=\"courses.php?type=1\">Create</a> | <a href=\"courses.php?type=2\">Edit</a> | <a href=\"courses.php?type=3\">Delete</a><br>");
				$gui_obj->addContent ("Parts: <a href=\"parts.php?type=1\">Create</a> | <a href=\"parts.php?type=2\">Edit</a> | <a href=\"parts.php?type=3\">Delete</a><br>");
				$gui_obj->addContent ("Owned Parts: <a href=\"owned_parts.php?type=1\">Create</a> | <a href=\"owned_parts.php?type=2\">Edit</a> | <a href=\"owned_parts.php?type=3\">Delete</a><br>");
				$gui_obj->addContent ("Pods: <a href=\"pods.php?type=1\">Create</a> | <a href=\"pods.php?type=2\">Edit</a> | <a href=\"pods.php?type=3\">Delete</a><br>");
				$gui_obj->addContent ("Owned Pods: <a href=\"owned_pods.php?type=1\">Create</a> | <a href=\"owned_pods.php?type=2\">Edit</a> | <a href=\"owned_pods.php?type=3\">Delete</a><br>");
				$gui_obj->addContent ("Races: <a href=\"races.php?type=1\">Create</a> | <a href=\"races.php?type=2\">Edit</a> | <a href=\"races.php?type=3\">Delete</a><br>");
				$gui_obj->addContent ("Race Registrations: <a href=\"race_registrations.php?type=1\">Create</a> | <a href=\"race_registrations.php?type=2\">Edit</a> | <a href=\"race_registrations.php?type=3\">Delete</a><br>");
				$gui_obj->addContent ("Race Results: <a href=\"race_results.php?type=1\">Create</a> | <a href=\"race_results.php?type=2\">Edit</a> | <a href=\"race_results.php?type=3\">Delete</a><br>");
				$gui_obj->addContent ("Teams: <a href=\"teams.php?type=1\">Create</a> | <a href=\"teams.php?type=2\">Edit</a> | <a href=\"teams.php?type=3\">Delete</a><br>");
				$gui_obj->addContent ("Team Members: <a href=\"team_members.php?type=1\">Create</a> | <a href=\"team_members.php?type=2\">Edit</a> | <a href=\"team_members.php?type=3\">Delete</a><br>");
				$gui_obj->addContent ("<br><a href=\"run_race.php\">Run Race</a><br>");
			}
			$gui_obj->setTitle ("Admin");
			$gui_obj->outputGui ();			
		} 
		elseif ($hunter_obj->IsValid())
		{
			$gui_obj->addContent ("<a href=\"create_team.php\">Create a team</a><br>");
			$gui_obj->outputGui ();
		}
		else
		{
			die(login_failed());
		}
	}
?>