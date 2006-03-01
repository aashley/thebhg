<?php

	include_once 'header.php';
	
	if (isset($_REQUEST['View_pod'])) {	
		$pod = new OwnedPod ($_REQUEST['pod_id']);
		$pod_type = $pod->GetType();
		$gui->addContent ("<h3>".$pod->GetName()."</h3>\r\n");
		$gui->addContent ('<a href="'.$base_url.'list_active.php?Previous&pod='.$pod->GetID().'">View Race History</a>');
		$gui->addContent ("<table cellspacing=\"3\" cellpadding=\"3\">\r\n");
		$gui->addContent ("<tr><td>Average Skill Level (ASL)</td><td colspan=\"2\">".$pod->GetASL()."</td></tr>\r\n");
		
		if ($pod->GetASL() <= 5){
			$class = 'Mouse';
		} elseif ($pod->GetASL() <= 10){
			$class = 'Light';
		} elseif ($pod->GetASL() <= 20){
			$class = 'Medium-Light';
		} elseif ($pod->GetASL() <= 30){
			$class = 'Medium';
		} elseif ($pod->GetASL() <= 40){
			$class = 'Medium-Large';
		} elseif ($pod->GetASL() <= 50){
			$class = 'Large';
		} elseif ($pod->GetASL() <= 70){
			$class = 'Juggernaut';
		}
		$gui->addContent ("<tr><td>Podrcer Class</td><td colspan=\"2\">".$class."</td></tr>\r\n");
		$gui->addContent ("<tr><td>Type</td><td colspan=\"2\">".$pod_type->GetName()."</td></tr>\r\n");
		$gui->addContent ("<tr><td>Traction</td><td>".$podracer->pmeter($pod->GetTraction(1))."</td><td>(".$pod->GetTraction(1).")</td></tr>\r\n");
		$gui->addContent ("<tr><td>Turning</td><td>".$podracer->pmeter($pod->GetTurning(1))."</td><td>(".$pod->GetTurning(1).")</td></tr>\r\n");
		$gui->addContent ("<tr><td>Acceleration</td><td>".$podracer->pmeter($pod->GetAcceleration(1))."</td><td>(".$pod->GetAcceleration(1).")</td></tr>\r\n");
		$gui->addContent ("<tr><td>Top Speed</td><td>".$podracer->pmeter($pod->GetTopSpeed(1))."</td><td>(".$pod->GetTopSpeed(1).")</td></tr>\r\n");
		$gui->addContent ("<tr><td>Air Brake</td><td>".$podracer->pmeter($pod->GetAirBrake(1))."</td><td>(".$pod->GetAirBrake(1).")</td></tr>\r\n");
		$gui->addContent ("<tr><td>Cooling</td><td>".$podracer->pmeter($pod->GetCooling(1))."</td><td>(".$pod->GetCooling(1).")</td></tr>\r\n");
		$gui->addContent ("<tr><td>Repair</td><td>".$podracer->pmeter($pod->GetRepair(1))."</td><td>(".$pod->GetRepair(1).")</td></tr>\r\n");
		$gui->addContent ("</table><br>\r\n");
		$gui->addContent ("<h3>Mods</h3>\r\n");
		$mods = $pod->listParts();
		foreach ($mods as $mod) {
			$mod_type = $mod->GetPart();
			$type = $mod_type->GetType();	
			$gui->addContent ("<a href=\"".$base_url."junkyard.php?View_mod=1&amp;mod_id=".$mod->GetID()."\">".$mod_type->GetName()."</a> ".$mod_type->WriteIncrease()."<br>\r\n");
		}
		if (count($mods) <= 0) { $gui->addContent ("No modifications<br>\r\n"); }	
		$gui->addContent ("<br><a href=\"".$base_url."list_active.php\">Return to team listings</a><br>\r\n");
		
	}		
      elseif (isset($_REQUEST['Previous']))
  		{
	  		if ($_REQUEST['team']){
		  		$team = new Team($_REQUEST['team']);
	  		} elseif ($_REQUEST['pod']){
	  			$pod = new OwnedPod($_REQUEST['pod']);
	  			$team = $pod->GetTeam();
  			}
  			
	  		$results_array = $team->listRaceResults();
	  		$array = array();
  			foreach ($results_array as $result){
  				$reg = $result->getRegistration();
  				$race = $reg->getRace();
  				$pod = $reg->getPod();
  				$array[$pod->GetID()][$race->GetID()] = $result;
			}
	  		if ($_REQUEST['team']){
		  		$team = new Team($_REQUEST['team']);
		  		$gui->addcontent("<h3>Race History for ".$team->GetName()."</h3>");
	  			
		  		if (sizeof ($results_array) <= 0) 
		  		{ 
		  			$gui->addContent ("No past race results"); 
		  		}
		  		else
		  		{
	  				foreach ($array as $pod=>$info){
		  				$pod = new OwnedPod($pod);
		  				$gui->addContent ('<b>'.$pod->GetName().'</b>'.($pod->GetDeleted() ? ' - Scrap Heap' : '').'<br />');
		  				$gui->addContent ("&nbsp;&nbsp;&nbsp<small><a href=\"".$base_url."list_active.php?View_pod=1&pod_id=".$pod->getID()."\">Ship Stats</a></small><br/>");
		  				foreach ($info as $race=>$reg){
			  				$race = new Race($race);
		  					$gui->addContent ("&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp Won ".number_format($reg->getWinnings())." credits in <a href=\"".$base_url."schedule.php?race_id=".$race->getID()."\">".$race->getName()."</a> [<a href=\"".$base_url."list_active.php?View_result=1&result_id=".$reg->getID()."\">View Details</a>]<br>");
	  					}
	  					$gui->addcontent('<p>');
		  			}
		  		}  
	  		} elseif ($_REQUEST['pod']){
		  		$pod = new OwnedPod($_REQUEST['pod']);

  				$gui->addContent ('<b>'.$pod->GetName().'</b>'.($pod->GetDeleted() ? ' - Scrap Heap' : '').'<br />');
  				$gui->addContent ("&nbsp;&nbsp;&nbsp<small><a href=\"".$base_url."list_active.php?View_pod=1&pod_id=".$pod->getID()."\">Ship Stats</a></small><br/>");
  				foreach ($array[$pod->GetID()] as $race=>$reg){
	  				$race = new Race($race);
  					$gui->addContent ("&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp Won ".number_format($reg->getWinnings())." credits in <a href=\"".$base_url."schedule.php?race_id=".$race->getID()."\">".$race->getName()."</a> [<a href=\"".$base_url."list_active.php?View_result=1&result_id=".$reg->getID()."\">View Details</a>]<br>");
				}
			}
  			
	}
	elseif (isset($_REQUEST['View_result']))
  		{
  			$result = new RaceResult ($_REQUEST['result_id']);
  			$reg = $result->getRegistration();
  			$race = $reg->getRace();
  			$course = $race->getCourse();
  			$gui->addContent ("Race: ".$race->getName()."<br>");
  			$gui->addContent ("Course: ".$course->getName()."<br>");
  			$gui->addContent ("Total Pods: ".sizeof($race->listRaceRegistrations(1))."<br>");
  			$gui->addContent ("Place: ".$result->getPlace()."<br>");					
  			$gui->addContent ("Winnings: ".number_format($result->getWinnings())." credits<br>");					
  			$gui->addContent ("<h3>Comments</h3>");
  			$comments_array = $reg->getComments();
  			for ($i = 0; $i < sizeof ($comments_array); $i++)
  			{
  				$gui->addContent ($comments_array[$i]."<br>");
  			}				
  			$gui->setTitle ("Race Results");
  			$gui->outputGui ();
  			exit();
  		}		
      elseif (isset($_REQUEST['View_team']))
	{
		$team = new Team($_REQUEST['team_id']);
		$leader = $team->GetLeader();
		$gui->addContent ("<table cellspacing=0 cellpadding=0 border=0><tr><td><h3>".$team->GetName().' - [</h3></td><td><a href="'.$base_url.'list_active.php?Previous&team='.$team->GetID()."\">View Race Results</a></td><td><h3>]</h3></td></tr></table>\r\n");
    $gui->addContent ("<table><tr><td>");
    if (strlen($team->GetImage()) > 0)
			$gui->addContent ("<img src=\"".$team->GetImage()."\" height=\"50\" width=\"50\" alt=\"\" border=\"0\">");
		else
			$gui->addContent ("<img src=\"".$base_url."images/default.png\" height=\"50\" width=\"50\" alt=\"\" border=\"0\">");
    $gui->addContent ("</td><td>");
		$gui->addContent ("Lead by <a href=\"http://holonet.thebhg.org/index.php?module=roster&page=hunter&id=".$leader->GetID()."\" tarGet=\"_blank\">".$leader->GetName()."</a><br>\r\n");
		$gui->addContent ("Slogan: ");
		if (strlen($team->GetSlogan()) <= 0)
			$gui->addContent ("No Slogan<br>\r\n");
		else
			$gui->addContent ("<i>".htmlspecialchars($team->GetSlogan())."</i><br>\r\n");
		$gui->addContent ("Website: ");
		if (strlen($team->GetUrl()) <= 0)
			$gui->addContent ("No Website<br>\r\n");
		else
			$gui->addContent ("<a href=\"".$team->GetUrl()."\" tarGet=\"_blank\">".$team->GetUrl()."</a><br>\r\n");
		$gui->addContent ("Credits: ".number_format($team->GetCredits())." Credits<br>\r\n");
		$gui->addContent ("</td></tr></table>");
    $gui->addContent ("<p>Team Members\r\n");
		$members = $team->listMembers();
		foreach ($members as $member) {
			$person = $member->GetBhgId();
			$gui->addContent ("<br>&nbsp;&nbsp;&nbsp;<a href=\"http://holonet.thebhg.org/index.php?module=roster&page=hunter&id=".$person->GetID()."\" tarGet=\"_blank\">".$person->GetName()."</a>\r\n");
			$gui->addContent ("<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Donated ".number_format($member->GetDonations())." Credits (".$member->GetContrib()." of Listed Contributions)\r\n");
			$gui->addContent ("<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recieved ".number_format($member->GetRecieved())." Credits (".$member->GetReturn()." Return)\r\n");
			unset ($person);
		}
		$gui->addContent ("</p>\r\n<p>Team Pods<br>\r\n");
		$pods = $team->listPods(1);
		if (sizeof ($pods) <= 0) { $gui->addContent ("&nbsp;&nbsp;&nbsp;No pods<br>\r\n"); }

		foreach ($pods as $pod)	{
			$pod_type = $pod->GetType();
			$gui->addContent ("&nbsp;&nbsp;&nbsp;<a href=\"".$base_url."list_active.php?View_pod=1&amp;pod_id=".$pod->GetID()."\">".$pod->GetName()."</a>".
			($pod->GetDeleted() ? ' Scrap Heap ' : '')."<br>\r\n");
			unset ($pod_type);
		}
		$gui->addContent ("</p>Current Races<br>\r\n");	
		$races = $team->listRaceRegistrations(1);
		if (sizeof ($races) <= 0) { $gui->addContent ("&nbsp;&nbsp;&nbsp;No races<br>\r\n"); }
		foreach ($races as $race_reg)
		{
			$race = $race_reg->GetRace();
			$pod = $race_reg->GetPod();
			$gui->addContent ("&nbsp;&nbsp;&nbsp;\"<a href=\"".$base_url."list_active.php?View_pod=1&amp;pod_id=".$pod->GetID()."\">".$pod->GetName()."</a>\" in <a href=\"".$base_url."schedule.php?race_id=".$race->GetID()."\">".$race->GetName()."</a><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;House Odds: ".$race_reg->GetHouseOdds(1)."<br>\r\n");
			unset ($pod);
			unset ($race);
		}
		$gui->addContent ("<p align=\"center\"><a href=\"".$base_url."list_active.php\">Return to team listings</a></p>\r\n");
	}
	else
	{
		$gui->addContent ("<h2 align=\"center\">Competing Teams</h2>\r\n<p align=\"center\">\r\n");
		$teams = $podracer->listTeams ();
		$gui->addContent ("<table width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n");
		$rows = ((int)(sizeof ($teams) / 5)) + (pow((sizeof ($teams) % 5), 1));		
		for ($j = 0; $j < $rows; $j++)
		{
			$table_str .= "  <tr>\r\n";
			$table_str .= "    <td width=\"20%\">&nbsp;</td>\r\n";
			$table_str .= "    <td width=\"20%\" align=\"center\">%replace".((5 * $j))."%</td>\r\n";
			$table_str .= "    <td width=\"20%\">&nbsp;</td>\r\n";
			$table_str .= "    <td width=\"20%\" align=\"center\">%replace".((5 * $j) + 1)."%</td>\r\n";
			$table_str .= "    <td width=\"20%\">&nbsp;</td>\r\n";
			$table_str .= "  </tr>\r\n";
			$table_str .= "  <tr>\r\n";
			$table_str .= "    <td width=\"20%\" align=\"center\">%replace".((5 * $j) + 2)."%</td>\r\n";
			$table_str .= "    <td width=\"20%\">&nbsp;</td>\r\n";
			$table_str .= "    <td width=\"20%\" align=\"center\">%replace".((5 * $j) + 3)."%</td>\r\n";
			$table_str .= "    <td width=\"20%\">&nbsp;</td>\r\n";
			$table_str .= "    <td width=\"20%\" align=\"center\">%replace".((5 * $j) + 4)."%</td>\r\n";
			$table_str .= "  </tr>\r\n";
		}
		$table_str .= "</table>\r\n";
		for ($i = (sizeof ($teams) - 1); $i >= 0; $i--)
		{			
			$team = $teams [$i];
			$replace_str = "<p><a href=\"".$base_url."list_active.php?View_team=1&amp;team_id=".$team->GetID()."\">";
			if (strlen($team->GetImage()) > 0)
				$replace_str .= "<img src=\"".$team->GetImage()."\" height=\"50\" width=\"50\" alt=\"\" border=\"0\"><br>";
			else
				$replace_str .= "<img src=\"".$base_url."images/default.png\" height=\"50\" width=\"50\" alt=\"\" border=\"0\"><br>";
			$replace_str .=	$team->GetName()."</a></p>";
			$table_str = eregi_replace ("%replace".$i."%", $replace_str, $table_str);
			unset ($team);
		}
		$table_str = preg_replace ('/%replace(.*?)%/', '', $table_str);
		$gui->addContent ($table_str);
		$gui->addContent ("</p>\r\n");
	}
	$gui->setTitle ("Competing Teams");
	$gui->outputGui ();
?>