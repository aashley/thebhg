<?php

	include "../header.php";

	$hunter = new Login_HTTP($coder_id);
	$team_member = $podracer->findTeamMember ($hunter->getID());
  		$team = $team_member->getTeam();
      if (isset($_REQUEST['Withdraw']))
  		{
  			$registration = new RaceRegistration ($_REQUEST['race_id']);
  			$race = $registration->getRace();
  			if ($race->writeRegDate() < time())
  			{
  				$gui->addContent ("<p align=\"center\"><br>The registration period for this race has ended, you can no longer withdraw</p>");
  			}
  			else
  			{
  				$creds = $race->getCost() * .75;
  				$team->addCredits ($creds);
  				$pod = $registration->getPod();
  				$gui->addContent ("<p align=\"center\"><br>\"".$pod->getName()."\" has been withdrawn</p>");
  				$registration->delete();
  			}
  		}
      elseif (isset($_REQUEST['Signup']))
  		{
  			$race = new Race ($_REQUEST['race_id']);	
  			$pod = new OwnedPod ($_REQUEST['pod_id']);
  			if ($race->getPodLimit() <= sizeof($race->listPods()))
  			{
  				$gui->addContent ("<p align=\"center\"><br>This race has reached it's pod limit</p>");
  			}
  			elseif ($race->getCost() > $team->getCredits())
  			{
  				$gui->addContent ("<p align=\"center\"><br>You do not have the ".number_format($race->getCost())." credits needed</p>");
  			}
        elseif (($race->getSkillLevel() + 25) < $pod->getASL())
        {
          $gui->addContent ("<p align=\"center\"><br>The pod you are trying to enter has a ASL more than maximum race level</p>");
  			 }
  			else
  			{	
	  			$race = new Race($_REQUEST['race_id']);
	  			$go = true;
	  			foreach ($race->ListPods() as $pod){
		  			if ($pod->GetID() == $_REQUEST['pod_id']){
			  			$badpod = $pod->GetName();
			  			$go = false;
		  			}
	  			}
 
  				if ($go)
  				{
	  				if ($podracer->NumTeamRegistrations($race->GetID(), $team->GetID()) <= 2){
	  					$team->removeCredits ($race->getCost());
	  					$registration = $podracer->createRaceRegistration ($_REQUEST['race_id'], $_REQUEST['pod_id']);
	  					$gui->addContent ("<p align=\"center\"><br>Registration Successful</p>");
  					}
  					else {
	  					$gui->addContent("You cannot have more than 2 pods in the same race.");
  					}
  				}
  				else
  				{
  					$gui->addContent ("<p align=\"center\"><br>\"".$badpod."\" is already signed up for that race</p>");
  				}
  			}
  		}
      $gui->addContent ("<h3 align=\"center\">Current Race Registrations</h3>");	
  		$races_array = $team->listRaceRegistrations(1);
  		if (sizeof ($races_array) <= 0) 
  		{ 
  			$gui->addContent ("No race registrations<br>"); 
  		}
  		else
  		{
  			for ($f = 0; $f < sizeof ($races_array); $f++)
  			{
  				$race_reg = $races_array [$f];
  				$race = $race_reg->getRace();
  				$pod = $race_reg->getPod();
  				$gui->addContent ("&nbsp;&nbsp;&nbsp;\"<a href=\"".$base_url."list_active.php?View_pod=1&pod_id=".$pod->getID()."\">".$pod->getName()."</a>\" in <a href=\"".$base_url."schedule.php?race_id=".$race->getID()."\">".$race->getName()."</a>");
          if ($team_member->isLeader())
          {
            $gui->addContent (" [<a href=\"".$base_url."admin/modify_races.php?Withdraw=1&race_id=".$race_reg->getID()."\">Withdraw</a>]");
          }
          if ($pod->GetASL() > ($race->GetSkillLevel() + 25)){
	          $gui->addContent("<b><span style='color:red;'> INVALID REGISTRY!</span></b>");
          }
          $gui->addContent ("<br>");
  				unset ($pod);
  				unset ($race);
  				unset ($race_reg);
  			}
  		}
  		$gui->addContent ("<h3 align=\"center\">Past Race Results</h3>");	
  		$gui->addContent ('&nbsp;&nbsp;&nbsp;<a href="'.$base_url.'list_active.php?Previous&team='.$team->GetID().'">View All Previous Races</a>');
      if ($team_member->isLeader())
      {
        $gui->addContent ("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"POST\">\r\n");
        $gui->addContent ("<h3 align=\"center\">Signup for an upcoming race</h3>");
        $gui->addContent("<small>Remember, you may only have 2 pods in any one race.</small><p>");
  			$gui->addContent ("Select a race<br>");
  			$gui->addContent ("<select name=\"race_id\">\r\n");					
  			$races_array = $podracer->listUpcomingRaces();
  			if (count($races_array)){
	  			for ($j = 0; $j < sizeof ($races_array); $j++)
	  			{
	  				$race = $races_array [$j];
	  				if ($podracer->NumTeamRegistrations($race->GetID(), $team->GetID()) < 2){
	  					$gui->addContent ("<option value=\"".$race->getID()."\">".$race->getName().", ".$race->getPodlimit()." pod limit, ".number_format($race->getCost())." credit buyin, ".($race->GetSkillLevel()+25)." Max ASL</option>");
  					}
	  				unset ($race);
	  			}
	  			$gui->addContent ("</select><br>");
	  			$gui->addContent ("<br>Select a pod<br>");
	  			$pods_array = $team->listPods();
	  			$gui->addContent ("<select name=\"pod_id\">\r\n");
	  			for ($i = 0; $i < sizeof ($pods_array); $i++)
	  			{
	  				$pod = $pods_array [$i];
	  				$gui->addContent ("<option value=\"".$pod->getID()."\">".$pod->getName().", ".$pod->GetASL()." ASL</option>");
	  				unset ($pod);
	  			}
	  			$gui->addContent ("</select><p align=\"center\"><input type=\"Submit\" name=\"Signup\" value=\"Signup\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\"></p>\r\n");
	  			$gui->addContent ("</form>\r\n");
  			}
      }
		  $gui->addContent ("<p align=\"center\"><a href=\"".$base_url."admin/index.php\">Return to admin</a></p><br>");					
			$gui->setTitle ("Modify Races");
			$gui->outputGui ();
?>