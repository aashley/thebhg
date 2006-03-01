<?php

	include_once 'header.php';
	$hunter = new Login_HTTP($coder_id);
	$team_member = $podracer->findTeamMember($hunter->getID());
	if (is_object($team_member)){
		$team = $team_member->getTeam();
	} else {
		$team = new Team(0);
	}
	
	if (isset($_REQUEST['Submit']))	{
		$race = new Race($_REQUEST['race_id']);
		$bets = $podracer->ListBets($hunter->GetID());
		$go = true;
		foreach ($bets as $bet){
			$racae = $bet->GetRace();
			if ($racae->GetID() == $_REQUEST['race_id']){
				$go = false;
			}
		}
		if ($go) {
			if (isset($_REQUEST['Final'])) {
				$_REQUEST['amount'] = str_replace(",", "", $_REQUEST['amount']);
				$racid = array();
				foreach ($bets as $qbet){
					$racae = $qbet->GetRace();
					$racid[] = $racae->GetID();
				}
				$vouchers = array();
				foreach ($podracer->ListUpcomingRaces() as $raace) {
					if ((time() >= $raace->WriteRegDate()) && (time() <= $raace->writeDate())){
						if (!in_array($raace->GetID(), $racid)){
							$pods = $race->ListPods();
							foreach ($pods as $pod){
								$tem = $pod->GetTeam();
								if ($tem->GetID() == $team->GetID()){
									$vouchers[$raace->GetID()] = 1;
								}
							}
						}
					}
				}
				if ($_REQUEST['voucher'] && count($vouchers)){
					$_REQUEST['amount'] += 1000000;
				}
				if ($_REQUEST['amount'] > 5000000){
					$_REQUEST['amount'] = 5000000;
				}
				if ($_REQUEST['amount'] < 0){
					$_REQUEST['amount'] = 0;
				}
				$pod = new OwnedPod($_REQUEST['pod_id']);
				$gui->addContent (number_format($_REQUEST['amount'])." Credits successfully placed on \"".$pod->GetName()."\" in ".$race->GetName());
				$pod = new OwnedPod($_REQUEST['pod_id']);
				$podracer->CreateBet($hunter->GetID(), $_REQUEST['pod_id'], $_REQUEST['race_id'], $_REQUEST['amount'], ((isset($_REQUEST['voucher']) && count($vouchers)) ? 1 : 0));
				$go = true;
				if ($_REQUEST['voucher'] && count($vouchers)){
					if ($_REQUEST['amount'] == 2000000){
						$go = false;
					} else {
						$spend = $_REQUEST['amount'] - 1000000;
					}
				} else {
					$spend = $_REQUEST['amount'];
				}
				if ($go){
					$hunter->MakePurchase($spend, 'Lyarna Podracer Circuit', 'Betting Ticket');
				}
			} else {
				$gui->addContent ("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"GET\">\r\n");
				$gui->addContent ("<h3>Select Pod ".$race->GetName()."</h3>");
				$gui->addContent ("<table>");
				$gui->addContent ("<tr><td>Pod</td><td><select name=\"pod_id\">");
				foreach ($race->ListRaceRegistrations() as $reg) {
					$pod = $reg->GetPod();
					$team = $pod->GetTeam();
					$difference = $reg->GetHouseOdds(1);
					$gui->addContent ("<option value=\"".$pod->GetID()."\"");
					if ($_REQUEST['pod_id'] == $pod->GetID()) {
						$gui->addContent (" selected");
					}
						$gui->addContent (">".$difference.": \"".$pod->GetName()."\" owned by ".$team->GetName()."</option>");
				}
				$gui->addContent ("</select></td></tr>");
				$racid = array();
				foreach ($bets as $bet){
					$race = $bet->GetRace();
					$racid[] = $race->GetID();
				}
				$vouchers = array();
				foreach ($podracer->ListUpcomingRaces() as $raace) {
					if ((time() >= $race->WriteRegDate()) && (time() <= $race->writeDate())){
						if (!in_array($raace->GetID(), $racid)){
							$pods = $race->ListPods();
							foreach ($pods as $pod){
								$tem = $pod->GetTeam();
								if ($tem->GetID() == $team->GetID()){
									$vouchers[$raace->GetID()] = 1;
								}
							}
						}
					}
				}
				if (isset($_REQUEST['voucher']) && count($vouchers)){
					$gui->addContent ("<tr><td colspan=2><small>Enter the amount ABOVE the 1,000,000 you wish to bet.</small></td></tr>");
					$gui->addContent ("<input type=\"hidden\" name=\"voucher\" value=\"voucher\">");
					$gui->addContent ("<input type=\"hidden\" name=\"amount\" value=\"2000000\">");
				}
				$gui->addContent ("<tr><td>Amount</td><td><input type=\"text\" name=\"amount\"></td></tr>");
				$gui->addContent ("<tr><td colspan=2><small>Any bets greater than 5,000,000 will be reduced to 5,000,000</small></td></tr>");
				$gui->addContent ("</table>");
				$gui->addContent ("<input type=\"Submit\" name=\"Final\" value=\"Submit\">");
				$gui->addContent ("<input type=\"hidden\" name=\"Submit\" value=\"Submit\">");
				$gui->addContent ("<input type=\"hidden\" name=\"race_id\" value=\"".$_REQUEST['race_id']."\">");
				$gui->addContent ("</form>");
			}
		} else {
			$gui->addContent ("You have already placed a bet in this race. If you want to change the pod or amount, remove your old bet and then create a new bet.");
		}
	} elseif (isset($_REQUEST['Remove']))	{
		$bet = new Bet($_REQUEST['bet_id']);
		if (!$bet->GetDeleted()){
			$bet->Delete();
			if ($bet->GetVoucher()){
				$left = $bet->GetAmount() - 1000000;
				if ($left > 0){
					$hunter->MakeSale(($left * .85), 'Lyarna Podracer Circuit', 'Betting Ticket');
				}
			} else {
				$hunter->MakeSale(($bet->GetAmount() * .85), 'Lyarna Podracer Circuit', 'Betting Ticket');
			}
			$gui->addContent ("Bet removed successfully.");
		} else {
			$gui->addContent ("This bet doesn't exist.");
		}
		$gui->addContent ("<p><a href=\"".$base_url."bets.php\">Return to bets page</a></p>");
	} else {
		$races = array();
		$bets = $podracer->ListBets($hunter->GetID());
		$racid = array();
		foreach ($bets as $bet){
			$race = $bet->GetRace();
			$racid[] = $race->GetID();
		}
		$vouchers = array();
		foreach ($podracer->ListUpcomingRaces() as $race) {
			if ((time() >= $race->WriteRegDate()) && (time() <= $race->writeDate())){
				if (!in_array($race->GetID(), $racid)){
					$pods = $race->ListPods();
					foreach ($pods as $pod){
						$tem = $pod->GetTeam();
						if ($tem->GetID() == $team->GetID()){
							$vouchers[$race->GetID()] = 1;
						}
					}
					$races[] = $race;
				}
			}
		}
		if (count($races)){
			$gui->addContent ("<h3>Races currently available for bet placement</h3>");
			$gui->addContent ("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"POST\">\r\n");
			if (count($vouchers)){
				$gui->addContent("You have ".count($vouchers)." Race Voucher(s), valued at 1,000,000 each to bet with.<br />");
			}
			$gui->addContent ("<select name=\"race_id\">");
			foreach ($races as $race) {
				$gui->addContent ("<option value=\"".$race->GetID()."\">".$race->GetName()."</option>");
			}
			$gui->addContent ("</select>");
			if (count($vouchers)){
				$gui->addContent("<br /><input type=\"submit\" name=\"voucher\" value=\"Use Voucher\"><br />");
				$gui->addContent("<input type=\"hidden\" name=\"Submit\" value=\"Submit\">");
			}
				
			$gui->addContent(" <input type=\"Submit\" name=\"Submit\" value=\"Bet Normally\">");
			$gui->addContent ("</form>");
		} else {
			$gui->addContent ("<h3>No Races to Bet On</h3>");
		}
		$bets = $podracer->ListBets($hunter->GetID());
		if (count($bets)){
			$gui->addContent ("<h3>Current Bets</h3>");
			$bets = $podracer->ListBets($hunter->GetID());
			foreach ($bets as $bet) {
				$pod = $bet->GetPod();
				$race = $bet->GetRace();
				$team = $pod->GetTeam();
				$gui->addContent ("&nbsp;&nbsp;&nbsp;".number_format($bet->GetAmount())." Credits on \"<a href=\"".$base_url."list_active.php?View_pod=1&amp;pod_id=".$pod->GetID()."\">".$pod->GetName()."</a>\" owned by <a href=\"".$base_url."list_active.php?View_team=1&amp;team_id=".$team->GetID()."\">".$team->GetName()."</a> in <a href=\"".$base_url."schedule.php?race_id=".$race->GetID()."\">".$race->GetName()."</a> [<a href=\"".$base_url."bets.php?Remove=1&amp;bet_id=".$bet->GetID()."\">Remove</a>]<br>");
				unset ($team);
				unset ($race);
				unset ($pod);
			}
		}
	}
	$gui->setTitle ("Betting Central");
	$gui->outputGui ();
	
?>