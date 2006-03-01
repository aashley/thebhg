<?php

	include "../header.php";

	$hunter = new Login_HTTP($coder_id);
	$team_member = $podracer->findTeammember ($hunter->getID());
	$team = $team_member->getTeam();
	if (isset($_REQUEST['Submit'])) {
		$team_member_roster = $team_member->getBhgid();
		$member_array = $team->listMembersRoster();
		$email_array = array();
		for ($i = 0; $i < sizeof ($member_array); $i++) {
			$member = $member_array [$i];
				$email_array [$i] = $member->getEmail();
			unset ($member);
		}
		$email_list = implode (", ", $email_array);
		$headers = "From: ".$team_member_roster->getEmail()."\nReply-To: ".$team_member_roster->getEmail()."\n";
		mail ($email_list, 'Podracer :: '.$_REQUEST['subject'], $_REQUEST['body'], $headers);
		$gui->addContent ("<p align=\"center\"><br>Email sent</p>");
		$gui->addContent ("<p align=\"center\"><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
	} else {
		$gui->addContent ("<h2 align=\"center\">Email Team Members</h2>\r\n");
		$gui->addContent ("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"POST\">\r\n");
		$gui->addContent ("<table>");
		$gui->addContent ("<tr><td>Subject</td><td><input type=\"text\" name=\"subject\"></td><tr>");
		$gui->addContent ("<tr><td>Message</td><td><textarea name=\"body\" rows=\"9\" cols=\"50\"></textarea></td><tr>\r\n");
		$gui->addContent ("</table>");
		$gui->addContent ("<p align=\"center\"><input type=\"Submit\" name=\"Submit\" value=\"Send Email\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\"></p>\r\n");
		$gui->addContent ("</form>\r\n");
	}
	$gui->setTitle ("Email Team Members");
	$gui->outputGui ();
?>