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
      if (isset($View_result))
  		{
  			$result_obj = new Race_result ($result_id);
  			$reg_obj = $result_obj->getRegistration();
  			$race_obj = $reg_obj->getRace();
  			$course_obj = $race_obj->getCourse();
  			$gui_obj->addContent ("Race: ".$race_obj->getName()."<br>");
  			$gui_obj->addContent ("Course: ".$course_obj->getName()."<br>");
  			$gui_obj->addContent ("Total Pods: ".sizeof($race_obj->listRace_registrations(1))."<br>");
  			$gui_obj->addContent ("Place: ".$result_obj->getPlace()."<br>");					
  			$gui_obj->addContent ("Winnings: ".number_format($result_obj->getWinnings())." credits<br>");					
  			$gui_obj->addContent ("<h3>Comments</h3>");
  			$comments_array = $reg_obj->getComments();
  			for ($i = 0; $i < sizeof ($comments_array); $i++)
  			{
  				$gui_obj->addContent ($comments_array[$i]."<br>");
  			}
  			$gui_obj->addContent ("<p><a href=\"".$base_url."admin/modify_team.php\">Return to modify team</a></p>");					
  			$gui_obj->setTitle ("Modify Team");
  			$gui_obj->outputGui ();
  			exit();
  		}		
      elseif (isset($Withdraw))
  		{
  			$registration_obj = new Race_registration ($race_id);
  			$race_obj = $registration_obj->getRace();
  			if ($race_obj->getReg_date() < time())
  			{
  				$gui_obj->addContent ("<p align=\"center\"><br>The registration period for this race has ended, you can no longer withdraw</p>");
  			}
  			else
  			{
  				$creds = $race_obj->getCost() * .75;
  				$team_obj->addCredits ($creds);
  				$pod_obj = $registration_obj->getPod();
  				$gui_obj->addContent ("<p align=\"center\"><br>\"".$pod_obj->getName()."\" has been withdrawn</p>");
  				$registration_obj->delete();
  			}
  		}
      elseif (isset($Signup))
  		{
  			$race_obj = new Race ($race_id);	
  			$pod_obj = new Owned_pod ($pod_id);
  			if ($race_obj->getPod_limit() <= sizeof($race_obj->listPods()))
  			{
  				$gui_obj->addContent ("<p align=\"center\"><br>This race has reached it's pod limit</p>");
  			}
  			elseif ($race_obj->getCost() > $team_obj->getCredits())
  			{
  				$gui_obj->addContent ("<p align=\"center\"><br>You do not have the ".number_format($race_obj->getCost())." credits needed</p>");
  			}
        elseif (($race_obj->getSkill_level() + 15) < $pod_obj->getASL())
        {
          $gui_obj->addContent ("<p align=\"center\"><br>The pod you are trying to enter has a ASL more than 15 points higher than that race's set skill level</p>");
  			 }
  			else
  			{	
  				$duplicate_result = $db_obj->query ("SELECT COUNT(*) AS num FROM podracer_race_registrations WHERE race = $race_id AND pod = $pod_id");
  				if (mysql_result($duplicate_result, 0, "num") <= 0)
  				{
  					$team_obj->removeCredits ($race_obj->getCost());
  					$registration_obj = $podracer_obj->createRace_registration ($race_id, $pod_id);
  					$gui_obj->addContent ("<p align=\"center\"><br>Registration Successful</p>");
  				}
  				else
  				{
  					$gui_obj->addContent ("<p align=\"center\"><br>\"".$pod_obj->getName()."\" is already signed up for that race</p>");
  				}
  			}
  		}
      $gui_obj->addContent ("<h3 align=\"center\">Current Race Registrations</h3>");	
  		$races_array = $team_obj->listRace_registrations(1);
  		if (sizeof ($races_array) <= 0) 
  		{ 
  			$gui_obj->addContent ("No race registrations<br>"); 
  		}
  		else
  		{
  			for ($f = 0; $f < sizeof ($races_array); $f++)
  			{
  				$race_reg_obj = $races_array [$f];
  				$race_obj = $race_reg_obj->getRace();
  				$pod_obj = $race_reg_obj->getPod();
  				$gui_obj->addContent ("&nbsp;&nbsp;&nbsp;\"<a href=\"".$base_url."list_active.php?View_pod=1&pod_id=".$pod_obj->getID()."\">".$pod_obj->getName()."</a>\" in <a href=\"".$base_url."schedule.php?race_id=".$race_obj->getID()."\">".$race_obj->getName()."</a>");
          if ($team_member_obj->isLeader())
          {
            $gui_obj->addContent (" [<a href=\"".$base_url."admin/modify_races.php?Withdraw=1&race_id=".$race_reg_obj->getID()."\">Withdraw</a>]");
          }
          $gui_obj->addContent ("<br>");
  				unset ($pod_obj);
  				unset ($race_obj);
  				unset ($race_reg_obj);
  			}
  		}
  		$gui_obj->addContent ("<h3 align=\"center\">Past Race Results</h3>");	
  		$results_array = $team_obj->listRace_results();
  		if (sizeof ($results_array) <= 0) 
  		{ 
  			$gui_obj->addContent ("No past race results"); 
  		}
  		else
  		{
  			for ($g = 0; $g < sizeof ($results_array); $g++)
  			{
  				$result_obj = $results_array [$g];
  				$reg_obj = $result_obj->getRegistration();
  				$race_obj = $reg_obj->getRace();
  				$pod_obj = $reg_obj->getPod();
  				$gui_obj->addContent ("&nbsp;&nbsp;&nbsp;\"<a href=\"".$base_url."list_active.php?View_pod=1&pod_id=".$pod_obj->getID()."\">".$pod_obj->getName()."</a>\" won ".number_format($result_obj->getWinnings())." credits in <a href=\"".$base_url."schedule.php?race_id=".$race_obj->getID()."\">".$race_obj->getName()."</a> [<a href=\"".$base_url."admin/modify_races.php?View_result=1&result_id=".$result_obj->getID()."\">View Details</a>]<br>");
  				unset ($pod_obj);
  				unset ($race_obj);
  				unset ($reg_obj);
  				unset ($result_obj);
  			}
  		}        
      if ($team_member_obj->isLeader())
      {
        $gui_obj->addContent ("<form action=\"".$PHP_SELF."\" method=\"GET\">\r\n");
        $gui_obj->addContent ("<h3 align=\"center\">Signup for an upcoming race</h3>");
  			$gui_obj->addContent ("Select a race<br>");
  			$gui_obj->addContent ("<select name=\"race_id\">\r\n");					
  			$races_array = $podracer_obj->listUpcomingRaces();
  			for ($j = 0; $j < sizeof ($races_array); $j++)
  			{
  				$race_obj = $races_array [$j];
  				$gui_obj->addContent ("<option value=\"".$race_obj->getID()."\">".$race_obj->getName().", ".$race_obj->getPod_limit()." pod limit, ".number_format($race_obj->getCost())." credit buyin</option>");
  				unset ($race_obj);
  			}
  			$gui_obj->addContent ("</select><br>");
  			$gui_obj->addContent ("<br>Select a pod<br>");
  			$pods_array = $team_obj->listPods();
  			$gui_obj->addContent ("<select name=\"pod_id\">\r\n");
  			for ($i = 0; $i < sizeof ($pods_array); $i++)
  			{
  				$pod_obj = $pods_array [$i];
  				$gui_obj->addContent ("<option value=\"".$pod_obj->getID()."\">".$pod_obj->getName()."</option>");
  				unset ($pod_obj);
  			}
  			$gui_obj->addContent ("</select><p align=\"center\"><input type=\"Submit\" name=\"Signup\" value=\"Signup\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\"></p>\r\n");
  			$gui_obj->addContent ("</form>\r\n");
      }
		  $gui_obj->addContent ("<p align=\"center\"><a href=\"".$base_url."admin/index.php\">Return to admin</a></p><br>");					
			$gui_obj->setTitle ("Modify Races");
			$gui_obj->outputGui ();
		} 
		else 
		{
			die(login_failed());
		}
	}
?>