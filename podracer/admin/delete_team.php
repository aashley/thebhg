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
		if ($hunter_obj->IsValid())
		{
			$team_member_obj = $podracer_obj->findTeam_member ($hunter_obj->getID());
			if ($team_member_obj->isLeader())
			{
				$team_obj = $team_member_obj->getTeam();
				if (isset($Submit))
				{
					$credits = $team_obj->getCredits();							
					$pods_array = $team_obj->listPods();
					for ($i = 0; $i < sizeof ($pods_array ); $i++)
					{	
						$pod_obj = $pods_array [$i];
						$pod_type_obj = $pod_obj->getType();
						$cost = $pod_type_obj->getCost();
						$part_array = $pod_obj->listParts();
						for ($i = 0; $i < sizeof ($part_array); $i++)
						{
							$part_obj = $part_array [$i];
							$part_type_obj = $part_obj->getPart();
							$cost += $part_type_obj->getCost();
							$part_obj->delete();
						}
						$credits += (int)($cost * .75);
						$pod_obj->delete();
					}	
					$members_array = $team_obj->listMembersRoster();
					$team_num = sizeof($members_array);
					$amount = (int)($credits / $team_num);
					for ($i = 0; $i < sizeof ($members_array); $i++)
					{
						$current_obj = $members_array [$i];
						$current_obj->makeSale ($amount, $coder_id);
					}
					$gui_obj->addContent ($team_obj->getName()." disbanded, ".number_format($amount)." credits awarded to each member.");
					$team_obj->delete();
					$gui_obj->addContent ("<p><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
				}
				else
				{
				  $gui_obj->addContent ("<h2 align=\"center\">Disband Team</h2>\r\n");
					$gui_obj->addContent ("<br>Are you sure you want to disband \"".$team_obj->getName()."\"?<br>If you say yes, the team credits will be divided up equally amoung the members. Perhaps you should divide up the credits manually first unless you want the rewards to be equal.<br><br><a href=\"".$base_url."admin/delete_team.php?Submit=1\"\">Click here if you still want to disband the team</a>");
				}
			}
			else
			{
				$gui_obj->addContent ("Only a team leader can disband a team.");
			}
			$gui_obj->setTitle ("Disband Team");
			$gui_obj->outputGui ();
		} 
		else 
		{
			die(login_failed());
		}
	}
?>