<?php

	include "../header.php";

	$hunter = new Login_HTTP($coder_id);
	$team_member = $podracer->findTeamMember ($hunter->getID());
	if ($team_member->isLeader()) {
		$team = $team_member->getTeam();
		if (isset($_REQUEST['Submit'])) {
			$creds = eregi_replace (",", "", $_REQUEST['creds']);
			if (($creds <= $team->getCredits()) && ($creds > 0)) {
				$team->removeCredits ($creds);
				$person = new Person ($_REQUEST['member'], $coder_id);
				$person->makeSale ($creds, 'Lyarna Podracer Circuit', 'Team-Credit Distribution Voucher');
				$dist_team_member = $podracer->findTeammember ($_REQUEST['member']);
				$dist_team_member->addRecieved ($creds);
				$gui->addContent ("<p align=\"center\"><br>".number_format($creds)." credits successfully distributed to ".$person->getName()."</p>");
				$gui->addContent ("<p align=\"center\"><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
			} else {
				$gui->addContent ("<p align=\"center\"><br>You do not have enough credits to distribute</p");
			}
		} else {
			$gui->addContent ("<h2 align=\"center\">Distribute Credits</h2>");
			$gui->addContent ("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"POST\">\r\n");
			$gui->addContent ("<table align=\"center\">");
			$gui->addContent ("<tr><td>Available</td><td>".number_format($team->getCredits())." Credits</td><tr>");
			$gui->addContent ("<tr><td>Member</td><td><select name=\"member\">\r\n");					
			$members_array = $team->listMembersRoster();
			for ($i = 0; $i < sizeof ($members_array); $i++) {
				$person = $members_array [$i];
				$gui->addContent ("<option value=\"".$person->getID()."\">".$person->getName()."</option>\r\n");
				unset ($person);
			}
			$gui->addContent ("</select></td><tr>\r\n");
			$gui->addContent ("<tr><td>Amount</td><td><input type=\"text\" name=\"creds\"></td><tr>\r\n");
			$gui->addContent ("</table>");
			$gui->addContent ("<p align=\"center\"><input type=\"Submit\" name=\"Submit\" value=\"Submit\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\"></p>\r\n");
			$gui->addContent ("</form>\r\n");
		}
	} else {
		$gui->addContent ("Only a team leader can distribute credits.");
	}
	$gui->setTitle ("Distribute Credits");
	$gui->outputGui ();
?>