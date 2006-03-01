<?php

	include "../header.php";

	$hunter = new Login_HTTP($coder_id);
	$team_member = $podracer->findTeamMember ($hunter->getID());
	if ($team_member->isLeader()){
		$team = $team_member->getTeam();
		if (isset($_REQUEST['Submit']))	{
			$credits = $team->getCredits();							
			$pods_array = $team->listPods();
			for ($i = 0; $i < sizeof ($pods_array ); $i++){	
				$pod = $pods_array [$i];
				$pod_type = $pod->getType();
				$cost = $pod_type->getCost();
				$part_array = $pod->listParts();
				for ($i = 0; $i < sizeof ($part_array); $i++){
					$part = $part_array [$i];
					$part_type = $part->getPart();
					$cost += $part_type->getCost();
					$part->delete();
				}
				$credits += (int)($cost * .75);
				$pod->delete();
			}	
			$members_array = $team->listMembersRoster();
			$team_num = sizeof($members_array);
			$amount = (int)($credits / $team_num);
			for ($i = 0; $i < sizeof ($members_array); $i++){
				$current = $members_array [$i];
				$person = new Person($current->GetID(), $coder_id);
				$person->makeSale ($amount, 'Lyarna Podracer Circuit', 'Team-Share Credit Voucher');
			}
			$gui->addContent ($team->getName()." disbanded, ".number_format($amount)." credits awarded to each member.");
			$team->delete();
			$gui->addContent ("<p><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
		} else {
		  $gui->addContent ("<h2 align=\"center\">Disband Team</h2>\r\n");
			$gui->addContent ("<br>Are you sure you want to disband \"".$team->getName()."\"?<br>If you say yes, the team credits will be divided up equally amoung the members. Perhaps you should divide up the credits manually first unless you want the rewards to be equal.<br><br><a href=\"".$base_url."admin/delete_team.php?Submit=1\"\">Click here if you still want to disband the team</a>");
		}
	} else {
		$gui->addContent ("Only a team leader can disband a team.");
	}
	$gui->setTitle ("Disband Team");
	$gui->outputGui ();
?>