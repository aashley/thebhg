<?php

	include "header.php";
	$_REQUEST['Purchase'] = $_REQUEST['Purchase'];
	$_REQUEST['mod_id'] = $_REQUEST['mod_id'];
	$_REQUEST['pod_id'] = $_REQUEST['pod_id'];
	if (isset($_REQUEST['Purchase']))
	{
		$hunter = new Login_HTTP();
		$team_member = $podracer->findTeamMember($hunter->getID());
		if ($team_member->isLeader()){
			$team = $team_member->getTeam();
			if ((isset($_REQUEST['pod_id'])) && (!isset($_REQUEST['mod_id']))) {
				$pod = new Pod($_REQUEST['pod_id']);
				$num_avil = $pod->getNum() - count($podracer->ListOwnedPods($pod->GetID()));
				$go = true;
				if ($pod->GetCat() == 5){
					$owns = array();
					foreach ($team->ListPods() as $ood){
						$pd = $ood->GetType();
						$owns[] = $pd->GetID();
					}
					if (in_array($pod->GetID(), $owns)){
						$go = false;
					}
				}
				if ($go){
					if ($pod->getNum() == 0){ $num_avil = 1; }
					if ($pod->GetSale()){
						if ($num_avil > 0){
							if (isset($_REQUEST['Submit'])) {
								$team->removeCredits ($pod->getCost());
								$podracer->createOwnedpod ($pod->getID(), $team->getID(), $_REQUEST['pod_name']);
								$gui->addContent ("Pod, named \"".$_REQUEST['pod_name']."\", successfully purchased.");
							} else {
								if ($pod->getCost() <= $team->getCredits()) {
									$gui->addContent ("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"GET\">\r\n");
									$gui->addContent ("Name: <input type=\"text\" name=\"pod_name\">\r\n");
									$gui->addContent ("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
									$gui->addContent ("<input type=\"hidden\" name=\"Purchase\" value=\"1\">\r\n");
									$gui->addContent ("<input type=\"hidden\" name=\"pod_id\" value=\"".$_REQUEST['pod_id']."\">\r\n");
									$gui->addContent ("</form>\r\n");
								} else {
									$gui->addContent ("You do not have enough credits to purchase that pod.");
								}
							}
						} else {
							$gui->addContent ("There are no more of these pods available.");
						}
					} else {
						$gui->addContent ("This pod is not for sale");
					}
				} else {
					$gui->addContent ("You own too many of this pod already");
				}
			} elseif (isset($_REQUEST['mod_id'])) {
				$mod = new Part ($_REQUEST['mod_id']);
				if (isset($_REQUEST['Submit'])) {
					$pod = new OwnedPod($_REQUEST['pod_id']);
					$num_avil = $mod->getLimit() - count($podracer->ListOwnedParts($mod->GetID()));
					if ($mod->getLimit() == 0){ $num_avil = 1; }
					$parts = array();
					$types = array();
					$tmod = $mod->GetType();
					foreach ($pod->listParts() as $part){
						$pary = $part->GetPart();
						$tyoe = $pary->GetType();
						$parts[] = $pary->GetID();
						$types[] = $tyoe->GetID();
					}
					if (in_array($mod->GetID(), $parts)){
						$already = 1;
					}
					if ($tmod->GetID() != 10){
						if (in_array($tmod->GetID(), $types)){
							$dead = 1;
						}
					} else {
						$parts = array();
						foreach ($team->ListPods() as $pokd){
							foreach ($pokd->ListParts() as $parta){
								$pary = $parta->GetPart();
								$parts[] = $pary->GetID();
							}
						}
						if (in_array($mod->GetID(), $parts)){
							$already = 1;
						}
					}
						
					if (!$mod->GetSale()){
						$gui->addContent ("This part is not available for sale.");
					} elseif ($num_avil <= 0){
						$gui->addContent ("There are no more of these parts available.");
					} elseif ($already == 1) {
						$gui->addContent ("You already own that part.");
					} elseif ($dead == 1) {
						$gui->addContent ("You already own an unpgrade from this class.");
					} else {
						$team->removeCredits ($mod->getCost());
						$podracer->createOwnedpart ($mod->getID(), $pod->getID());
						$gui->addContent ("Part successfully install on your pod (".$pod->getName().").");
					}
				}
				else
				{
					if ($mod->getCost() <= $team->getCredits())
					{
						$gui->addContent ("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"GET\">\r\n");
						$gui->addContent ("Pod: <select name=\"pod_id\">\r\n");
						$pods_array = $team->listPods();
						foreach ($pods_array as $pod)
						{							
								$gui->addContent ("<option value=\"".$pod->getID()."\">".$pod->getName()."</option>\r\n");
						}
						$gui->addContent ("</select>\r\n");
						$gui->addContent ("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui->addContent ("<input type=\"hidden\" name=\"Purchase\" value=\"1\">\r\n");
						$gui->addContent ("<input type=\"hidden\" name=\"mod_id\" value=\"".$_REQUEST['mod_id']."\">\r\n");
						$gui->addContent ("</form>\r\n");
					}
					else
						$gui->addContent ("You do not have enough credits to purchase that modifcation.");
				}
			}
		} else {
			$gui->addContent ("Only a team leader can purchase a pod or modification.");
		}
	}
	elseif (isset($_REQUEST['View_pod']))
	{
		
		$pod = new Pod ($_REQUEST['pod_id']);
		
		$num_avil = $pod->getNum() - count($podracer->ListOwnedPods($pod->GetID()));
		if ($pod->getNum() == 0){ $num_avil = 1; }
		
		$gui->addContent ("<table width=\"100%\"><tr><td align=\"left\"><font size=\"+1\"><b>".$pod->getName()."</b></font></td></tr><tr><td align=\"right\">");
		if ($pod->GetSale() && $num_avil > 0){ $gui->addContent("<b>[</b><a href=\"".$base_url."junkyard.php?Purchase=1&amp;pod_id=".$pod->getID()."\">Purchase This Pod</a><b>]</b>"); }
		$gui->addContent ("</td></tr></table><p>".convertURL($pod->getDescription())."</p>");
		$gui->addContent ("<table cellspacing=\"3\" cellpadding=\"3\">");
		$gui->addContent ("<tr><td>Cost</td><td>".number_format($pod->getCost())." ICs</td></tr>");
		$gui->addContent ("<tr><td>Number Available</td><td>".(($pod->GetNum() != 0) ? number_format($num_avil) : 'Unlimited')."</td></tr>");
		$gui->addContent ("<tr><td>Traction</td><td>".$podracer->pmeter($pod->GetTraction())."</td></tr>");
		$gui->addContent ("<tr><td>Turning</td><td>".$podracer->pmeter($pod->getTurning())."</td></tr>");
		$gui->addContent ("<tr><td>Acceleration</td><td>".$podracer->pmeter($pod->getAcceleration())."</td></tr>");
		$gui->addContent ("<tr><td>Top Speed</td><td>".$podracer->pmeter($pod->getTopSpeed())."</td></tr>");
		$gui->addContent ("<tr><td>Air Brake</td><td>".$podracer->pmeter($pod->getAirBrake())."</td></tr>");
		$gui->addContent ("<tr><td>Cooling</td><td>".$podracer->pmeter($pod->getCooling())."</td></tr>");
		$gui->addContent ("<tr><td>Repair</td><td>".$podracer->pmeter($pod->getRepair())."</td></tr>");
		$gui->addContent ("</table>");
		$gui->addContent ("<p><a href=\"".$base_url."junkyard.php\">Return to junkyard listings</a></p>");
	}
	elseif (isset($_REQUEST['View_mod']))
	{
		$mod = new Part ($_REQUEST['mod_id']);
		
		$num_avil = $mod->getLimit() - count($podracer->ListOwnedParts($mod->GetID()));
		if ($mod->getLimit() == 0){ $num_avil = 1; }
		
		$gui->addContent ("<table width=\"100%\"><tr><td align=\"left\"><font size=\"+1\"><b>".$mod->getName()."</b></font></td></tr><tr><td align=\"right\">");
		if ($mod->GetSale() && $num_avil > 0){ $gui->addContent("<b>[</b><a href=\"".$base_url."junkyard.php?Purchase=1&amp;mod_id=".$mod->getID()."\">Purchase This Part</a><b>]</b>"); }
		
		$gui->addContent ("<tr><td colspan=\"2\">".$mod->getDescription()."</td></tr>");
		$gui->addContent ("<tr><td>Cost</td><td>".number_format($mod->getCost())." ICs</td></tr>");
		$gui->addContent ("<tr><td>Number Available</td><td>".(($mod->GetLimit() != 0) ? number_format($num_avil) : 'Unlimited')."</td></tr>");
		$gui->addContent ("<tr><td colspan=\"2\">".$mod->WriteEffects()."</td></tr>");
		$gui->addContent ("</table>");
		$gui->addContent ("<p><a href=\"".$_SERVER["PHP_SELF"]."\">Return to junkyard listings</a></p>");
	}
	elseif (isset($_REQUEST['View_pods']))
	{	
		$ar = $podracer->GetCategories();
		
		$gui->addContent ("<h2 align='center'>Pods Types - ".$ar[$_REQUEST['cat']]."</h2>");
		$pods_array = $podracer->listPods($_REQUEST['cat']);
		foreach ($pods_array as $pod){
			$gui->addContent ("<a href=\"".$base_url."junkyard.php?View_pod=1&amp;pod_id=".$pod->getID()."\">".$pod->getName()."</a><br>");
		}
	}
	elseif (isset($_REQUEST['View_mods']))
	{
		$mod = new PartType($_REQUEST['cat']);
		$gui->addContent ("<h2 align=\"center\">Modification Parts - ".$mod->GetName()."</h2>");
		$gui->addContent ("<small>".$mod->GetDescription()."</small><p>");
		foreach ($podracer->listParts($_REQUEST['cat']) as $mod) {
			$gui->addContent ("<a href=\"".$base_url."junkyard.php?View_mod=1&amp;mod_id=".$mod->getID()."\">".$mod->getName()."</a> ".$mod->WriteIncrease()."<br>");
		}
	} 
	else 
	{
		/*$gui->addContent ("<h2 align=\"center\">The Junkyard</h2>");
		$gui->AddContent ('<small>Welcome to the junkyard, boys and girls. Unlike the fancy-schmancy SSL, podracers ain\'t bought and sold in a clean'.
			', happy environment. Oh my no. Actually, come to think of it, they\' not even made out of really high quality stuff. They\'re salvage. Not gonna lie'.
			' to ya. They\'re really high quality salvage, but they are put together right here in our very own junkyard from the materials you\'re walinking on '
			.'right now! Hard to believe we\'d charge well in excess of millions of credits per pod, don\'t it? Well, I have kids to feed. So buy something, or get'.
			' out of the line, pal.</small><p>');*/
		
		$gui->addContent ("<h2 align=\"center\">Pods Types</h2>");
		foreach ($podracer->GetCategories() as $cat=>$name){
			if (count($podracer->ListPods($cat))){
				$gui->addcontent('<a href="'.$base_url.'junkyard.php?View_pods&cat='.$cat.'">'.$name.'</a> ('.count($podracer->ListPods($cat)).' Pods)<br />');
			}
		}
		
		$gui->addContent ("<h2 align=\"center\">Mods Types</h2>");
		foreach ($podracer->listPartTypes() as $name){
			if (count($podracer->listparts($name->GetID()))){
				$gui->addcontent('<a href="'.$base_url.'junkyard.php?View_mods&cat='.$name->GetID().'">'.
				ucwords($podracer->reworkName($name->GetName())).'</a> ('.count($podracer->listparts($name->GetID())).' Parts)<br />');
			}
		}
		$gui->addcontent('<br />');
	}
	$gui->setTitle ("The Junkyard");
	$gui->outputGui ();
?>
