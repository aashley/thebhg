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
  		if (isset($Submit_member))
  		{
  			$podracer_obj->createTeam_member ($new_member, $team_obj->getID());
        $new_member_obj = new Person ($new_member);
        $gui_obj->addContent ("<p align=\"center\"><br>".$new_member_obj->getName()." has been added to your team</p>");
  		}
  		elseif (isset($Remove))
  		{
  			if (isset($Submitted))
  			{					
  				$member_obj = $podracer_obj->findTeam_member ($bhg_id);
  				$member_obj->delete();
  				$gui_obj->addContent ("<p align=\"center\"><br>Team member successfully removed</p>");
  			}
  			else
  			{
  				$person_obj = new Person ($bhg_id);
  				$gui_obj->addContent ("<p><br>Are you sure you want to remove ".$person_obj->getName()." from your team?</p>");
  				$gui_obj->addContent ("<p><a href=\"".$base_url."admin/modify_members.php?Remove=1&Submitted=1&bhg_id=".$bhg_id."\">Yes, I am sure</a></p>");					
  				$gui_obj->setTitle ("Modify Members");
  				$gui_obj->outputGui ();
  				exit();
  			}
  		}
  		elseif (isset($Make))
  		{
  			if (isset($Submitted))
  			{					
  				$team_obj->setLeader($bhg_id);
  				$gui_obj->addContent ("<p align=\"center\"><br>New leader set successfully</p>");
  			}
  			else
  			{
  				$person_obj = new Person ($bhg_id);
  				$gui_obj->addContent ("<p><br>Are you sure you want to make ".$person_obj->getName()." the new team leader?</p>");
  				$gui_obj->addContent ("<p><a href=\"".$base_url."admin/modify_members.php?Make=1&Submitted=1&bhg_id=".$bhg_id."\">Yes, I am sure</a></p>");					
  				$gui_obj->setTitle ("Modify Members");
  				$gui_obj->outputGui ();
  				exit();
  			}
  		}
  		$gui_obj->addContent ("<h2 align=\"center\">Team Members</h2>");
  		$members_array = $team_obj->listMembers();
  		for ($i = 0; $i < sizeof ($members_array); $i++)
  		{
  			$pod_member_obj = $members_array [$i];
  			$roster_member_obj = $pod_member_obj->getBhg_id();
        $rank_obj = $roster_member_obj->getRank();
        $kabal_obj = $roster_member_obj->getDivision();
  			$gui_obj->addContent ("<br>&nbsp;&nbsp;&nbsp;<a href=\"http://holonet.thebhg.org/roster/hunter.php?id=".$roster_member_obj->getID()."\" target=\"_blank\">".$rank_obj->getName()." ".$roster_member_obj->getName()." of ".$kabal_obj->getName()."</a>");
  			$gui_obj->addContent ("<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Credits Donated: ".number_format($pod_member_obj->getDonations()));
  			$gui_obj->addContent ("<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Credits Recieved: ".number_format($pod_member_obj->getRecieved())."<br>");
  			if (($roster_member_obj->getID() != $hunter_obj->getID()) && ($team_member_obj->isLeader()))
  			{
  				$gui_obj->addContent ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<a href=\"".$base_url."admin/modify_members.php?Remove=1&bhg_id=".$roster_member_obj->getID()."\">Remove</a>] [<a href=\"".$base_url."admin/modify_members.php?Make=1&bhg_id=".$roster_member_obj->getID()."\">Make Leader</a>]<br>");
  			}
        unset ($kabal_obj);
  			unset ($rank_obj);
  			unset ($roster_member_obj);
  			unset ($pod_member_obj);
  		}
      if ($team_member_obj->isLeader())
  		{
    		$gui_obj->addContent ("<br><form action=\"".$PHP_SELF."\" method=\"POST\">");
    		$gui_obj->addContent ("<p align=\"center\"><b>Add Member:</b> <input type=\"text\" name=\"new_member\" size=\"5\">&nbsp;&nbsp;<input type=\"Submit\" name=\"Submit_member\" value=\"Add Member\">\r\n");
    		$gui_obj->addContent ("<br>Enter a hunter's <a href=\"http://holonet.thebhg.org/\" target=\"_blank\">roster id</a> number above to add a member to your team.</p>");
    		$gui_obj->addContent ("</form>\r\n");
      }
  		$gui_obj->addContent ("<p align=\"center\"><a href=\"".$base_url."admin/index.php\">Return to admin</a></p><br>");					
  		$gui_obj->setTitle ("Modify Members");
  		$gui_obj->outputGui ();
  	}
  	else
  	{
  		die(login_failed());
  	}
  }
?>