<?php

	include "setup.php";
	
	if (isset($team_image))
	{
		$team_obj = new Team ($team_image);
		Header ("Content-type: ".$team_obj->getImage_type());
		Header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Date in the past
		Header ("Expires:  " . gmdate("D, d M Y H:i:s",mktime (date("g"), date("i"), date("s"), date("m"), date("d")+7, date("Y"))) . " GMT");
		Header ("Cache-Control: max-age=604800, s-maxage=604800, proxy-revalidate, must-revalidate");		
		echo $team_obj->getImage();
		exit();
	}
	elseif (isset($View_pod))
	{	
		$pod_obj = new Owned_pod ($pod_id);
		$pod_type_obj = $pod_obj->getType();
		$gui_obj->addContent ("<h3>".$pod_obj->getName()."</h3>\r\n");
		$gui_obj->addContent ("<table cellspacing=\"3\" cellpadding=\"3\">\r\n");
		$gui_obj->addContent ("<tr><td>Type</td><td colspan=\"2\">".$pod_type_obj->getName()."</td></tr>\r\n");
		$gui_obj->addContent ("<tr><td>Traction</td><td>".$pod_obj->getTraction(1)."</td><td>(Base ".$pod_obj->getTraction(0)." + ".($pod_obj->getTraction(1) - $pod_obj->getTraction(0))." Tweaks)</td></tr>\r\n");
		$gui_obj->addContent ("<tr><td>Turning</td><td>".$pod_obj->getTurning(1)."</td><td>(Base ".$pod_obj->getTurning(0)." + ".($pod_obj->getTurning(1) - $pod_obj->getTurning(0))." Tweaks)</td></tr>\r\n");
		$gui_obj->addContent ("<tr><td>Acceleration</td><td>".$pod_obj->getAcceleration(1)."</td><td>(Base ".$pod_obj->getAcceleration(0)." + ".($pod_obj->getAcceleration(1) - $pod_obj->getAcceleration(0))." Tweaks)</td></tr>\r\n");
		$gui_obj->addContent ("<tr><td>Top Speed</td><td>".$pod_obj->getTop_speed(1)."</td><td>(Base ".$pod_obj->getTop_speed(0)." + ".($pod_obj->getTop_speed(1) - $pod_obj->getTop_speed(0))." Tweaks)</td></tr>\r\n");
		$gui_obj->addContent ("<tr><td>Air Brake</td><td>".$pod_obj->getAir_brake(1)."</td><td>(Base ".$pod_obj->getAir_brake(0)." + ".($pod_obj->getAir_brake(1) - $pod_obj->getAir_brake(0))." Tweaks)</td></tr>\r\n");
		$gui_obj->addContent ("<tr><td>Cooling</td><td>".$pod_obj->getCooling(1)."</td><td>(Base ".$pod_obj->getCooling(0)." + ".($pod_obj->getCooling(1) - $pod_obj->getCooling(0))." Tweaks)</td></tr>\r\n");
		$gui_obj->addContent ("<tr><td>Repair</td><td>".$pod_obj->getRepair(1)."</td><td>(Base ".$pod_obj->getRepair(0)." + ".($pod_obj->getRepair(1) - $pod_obj->getRepair(0))." Tweaks)</td></tr>\r\n");
		$gui_obj->addContent ("</table><br>\r\n");
		$gui_obj->addContent ("<h3>Mods</h3>\r\n");
		$mods_array = $pod_obj->listParts();
		foreach ($mods_array as $mod_obj)
		{
			$mod_type_obj = $mod_obj->getPart();		
			$gui_obj->addContent ("<a href=\"".$base_url."junkyard.php?View_mod=1&amp;mod_id=".$mod_obj->getID()."\">".$mod_type_obj->getName()."</a> (".$podracer_obj->rework_name($mod_type_obj->getType())." +".$mod_type_obj->getIncrease().")<br>\r\n");
		}
		if (sizeof($mods_array) <= 0) { $gui_obj->addContent ("No modifications<br>\r\n"); }	
		$gui_obj->addContent ("<br><a href=\"".$base_url."list_active.php\">Return to team listings</a><br>\r\n");
	}
	elseif (isset($View_team))
	{
		$team_obj = new Team ($team_id);
		$leader_obj = $team_obj->getLeader();
		$gui_obj->addContent ("<h3>".$team_obj->getName()."</h3>\r\n");
    $gui_obj->addContent ("<table><tr><td>");
    if (strlen($team_obj->getImage_type()) > 0)
			$gui_obj->addContent ("<img src=\"".$base_url."list_active.php?team_image=".$team_obj->getID()."\" height=\"50\" width=\"50\" alt=\"\" border=\"0\">");
		else
			$gui_obj->addContent ("<img src=\"".$base_url."images/spacer.gif\" height=\"50\" width=\"50\" alt=\"\" border=\"0\">");
    $gui_obj->addContent ("</td><td>");
		$gui_obj->addContent ("Lead by <a href=\"http://holonet.thebhg.org/roster/hunter.php?id=".$leader_obj->getID()."\" target=\"_blank\">".$leader_obj->getName()."</a><br>\r\n");
		$gui_obj->addContent ("Slogan: ");
		if (strlen($team_obj->getSlogan()) <= 0)
			$gui_obj->addContent ("No Slogan<br>\r\n");
		else
			$gui_obj->addContent ("<i>".htmlspecialchars($team_obj->getSlogan())."</i><br>\r\n");
		$gui_obj->addContent ("Website: ");
		if (strlen($team_obj->getUrl()) <= 0)
			$gui_obj->addContent ("No Website<br>\r\n");
		else
			$gui_obj->addContent ("<a href=\"".$team_obj->getUrl()."\" target=\"_blank\">".$team_obj->getUrl()."</a><br>\r\n");
		$gui_obj->addContent ("Credits: ".number_format($team_obj->getCredits())." Credits<br>\r\n");
		$gui_obj->addContent ("</td></tr></table>");
    $gui_obj->addContent ("<p>Team Members\r\n");
		$members_array = $team_obj->listMembers ();
		foreach ($members_array as $member_obj)
		{
			$person_obj = $member_obj->getBhg_id();
			$gui_obj->addContent ("<br>&nbsp;&nbsp;&nbsp;<a href=\"http://holonet.thebhg.org/roster/hunter.php?id=".$person_obj->getID()."\" target=\"_blank\">".$person_obj->getName()."</a>\r\n");
			$gui_obj->addContent ("<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Donated ".number_format($member_obj->getDonations())." Credits\r\n");
			$gui_obj->addContent ("<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recieved ".number_format($member_obj->getRecieved())." Credits\r\n");
			unset ($person_obj);
		}
		$gui_obj->addContent ("</p>\r\n<p>Team Pods<br>\r\n");
		$pods_array = $team_obj->listPods ();
		if (sizeof ($pods_array) <= 0) { $gui_obj->addContent ("&nbsp;&nbsp;&nbsp;No pods<br>\r\n"); }
		foreach ($pods_array as $pod_obj)
		{
			$pod_type_obj = $pod_obj->getType();
			$gui_obj->addContent ("&nbsp;&nbsp;&nbsp;<a href=\"".$base_url."list_active.php?View_pod=1&amp;pod_id=".$pod_obj->getID()."\">".$pod_obj->getName()."</a><br>\r\n");
			unset ($pod_type_obj);
		}
		$gui_obj->addContent ("</p>Current Races<br>\r\n");	
		$races_array = $team_obj->listRace_registrations(1);
		if (sizeof ($races_array) <= 0) { $gui_obj->addContent ("&nbsp;&nbsp;&nbsp;No races<br>\r\n"); }
		foreach ($races_array as $race_reg_obj)
		{
			$race_obj = $race_reg_obj->getRace();
			$pod_obj = $race_reg_obj->getPod();
			$gui_obj->addContent ("&nbsp;&nbsp;&nbsp;\"<a href=\"".$base_url."list_active.php?View_pod=1&amp;pod_id=".$pod_obj->getID()."\">".$pod_obj->getName()."</a>\" in <a href=\"".$base_url."schedule.php?race_id=".$race_obj->getID()."\">".$race_obj->getName()."</a><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;House Odds: 1 / ".$race_reg_obj->getHouse_odds()."<br>\r\n");
			unset ($pod_obj);
			unset ($race_obj);
		}
		$gui_obj->addContent ("<p align=\"center\"><a href=\"".$base_url."list_active.php\">Return to team listings</a></p>\r\n");
	}
	else
	{
		$gui_obj->addContent ("<h2 align=\"center\">Competing Teams</h2>\r\n<p align=\"center\">\r\n");
		$teams_array = $podracer_obj->listTeams ();
		$gui_obj->addContent ("<table width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n");
		$rows = ((int)(sizeof ($teams_array) / 5)) + (pow((sizeof ($teams_array) % 5), 1));		
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
		for ($i = (sizeof ($teams_array) - 1); $i >= 0; $i--)
		{			
			$team_obj = $teams_array [$i];
			$replace_str = "<p><a href=\"".$base_url."list_active.php?View_team=1&amp;team_id=".$team_obj->getID()."\">";
			if (strlen($team_obj->getImage_type()) > 0)
				$replace_str .= "<img src=\"".$base_url."list_active.php?team_image=".$team_obj->getID()."\" height=\"50\" width=\"50\" alt=\"\" border=\"0\"><br>";
			else
				$replace_str .= "<img src=\"".$base_url."images/spacer.gif\" height=\"50\" width=\"50\" alt=\"\" border=\"0\"><br>";
			$replace_str .=	$team_obj->getName()."</a></p>";
			$table_str = eregi_replace ("%replace".$i."%", $replace_str, $table_str);
			unset ($team_obj);
		}
		$table_str = preg_replace ('/%replace(.*?)%/', '', $table_str);
		$gui_obj->addContent ($table_str);
		$gui_obj->addContent ("</p>\r\n");
	}
	$gui_obj->setTitle ("Competing Teams");
	$gui_obj->outputGui ();
?>