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
			$team_obj = $team_member_obj->getTeam();
			if (isset($sure))
			{
				$team_member_obj->delete();
				$gui_obj->addContent ("<p>You have left ".$team_obj->getName()."</p>");
				$gui_obj->addContent ("<p><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
			}
			else
			{
				$gui_obj->addContent ("Are you sure you want to leave ".$team_obj->getName()."?<br><br>");
				$gui_obj->addContent ("If you do, you will lose all access to any credits you have donated to the 
				teams account. If you don't wish for this to happen, contact your team leader and have him give you
				your share of the credits before your leave the team. It will be impossible for you to get the credits
				from your leader, if you leave the team now. If you are sure you want to continue...<br><br>
				<a href=\"".$base_url."admin/leave_team.php?sure=1\">Click here to be removed from your team</a>");
			}
			$gui_obj->setTitle ("Leave Team");
			$gui_obj->outputGui ();
		} 
		else 
		{
			die(login_failed());
		}
	}
?>