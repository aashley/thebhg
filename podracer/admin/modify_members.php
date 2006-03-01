<?php

	include "../header.php";

	$hunter = new Login_HTTP($coder_id);
	$team_member = $podracer->findTeamMember ($hunter->getID());
	$team = $team_member->getTeam();
	if (isset($_REQUEST['Remove'])) {
		if (isset($_REQUEST['Submitted'])) {					
			$member = $podracer->findTeamMember ($_REQUEST['bhg_id']);
			$member->delete();
			$gui->addContent ("<p align=\"center\"><br>Team member successfully removed</p>");
		} else {
			$person = new Person ($_REQUEST['bhg_id']);
			$gui->addContent ("<p><br>Are you sure you want to remove ".$person->getName()." from your team?</p>");
			$gui->addContent ("<p><a href=\"".$base_url."admin/modify_members.php?Remove=1&Submitted=1&bhg_id=".$_REQUEST['bhg_id']."\">Yes, I am sure</a></p>");					
			$gui->setTitle ("Modify Members");
			$gui->outputGui ();
			exit();
		}
	} elseif (isset($_REQUEST['Make'])) {
		if (isset($_REQUEST['Submitted'])) {					
			$team->setLeader($_REQUEST['bhg_id']);
			$gui->addContent ("<p align=\"center\"><br>New leader set successfully</p>");
		} else {
			$person = new Person ($_REQUEST['bhg_id']);
			$gui->addContent ("<p><br>Are you sure you want to make ".$person->getName()." the new team leader?</p>");
			$gui->addContent ("<p><a href=\"".$base_url."admin/modify_members.php?Make=1&Submitted=1&bhg_id=".$_REQUEST['bhg_id']."\">Yes, I am sure</a></p>");					
			$gui->setTitle ("Modify Members");
			$gui->outputGui ();
			exit();
		}
	}
	$gui->addContent ("<h2 align=\"center\">Team Members</h2>");
	$members_array = $team->listMembers();

	foreach ($members_array as $pod_member) {
		if (!is_object($pod_member)){
			continue;
		}
		$roster_member = $pod_member->getBhgId();
        $rank = $roster_member->getRank();
        $kabal = $roster_member->getDivision();
		$gui->addContent ("<br>&nbsp;&nbsp;&nbsp;<a href=\"http://holonet.thebhg.org/index.php?module=roster&page=hunter&id=".$roster_member->getID()."\" target=\"_blank\">".$rank->getName()." ".$roster_member->getName()." of ".$kabal->getName()."</a>");
		$gui->addContent ("<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Credits Donated: ".number_format($pod_member->getDonations()));
		$gui->addContent ("<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Credits Recieved: ".number_format($pod_member->getRecieved())."<br>");
		if (($roster_member->getID() != $hunter->getID()) && ($team_member->isLeader())) {
			$gui->addContent ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<a href=\"".$base_url."admin/modify_members.php?Remove=1&bhg_id=".$roster_member->getID()."\">Remove</a>] [<a href=\"".$base_url."admin/modify_members.php?Make=1&bhg_id=".$roster_member->getID()."\">Make Leader</a>]<br>");
		}
		unset ($kabal);
		unset ($rank);
		unset ($roster_member);
		unset ($pod_member);
	}
	
	$gui->addContent ("<p align=\"center\"><a href=\"".$base_url."admin/index.php\">Return to admin</a></p><br>");					
	$gui->setTitle ("Modify Members");
	$gui->outputGui ();
?>