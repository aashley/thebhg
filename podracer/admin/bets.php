<?php
	
	include "../header.php";
	$gui->setTitle("Bets Admin");
	$hunter = new Login_HTTP($coder_id);
	if (in_array($hunter->getID(), $admin)){
		if ($_REQUEST['type'] == 1)	{
			if (isset($_REQUEST['Submit'])) {
				$bet = $podracer->createBet($_REQUEST['bhg_id'], $_REQUEST['pod_id'], $_REQUEST['race_id'], $_REQUEST['amount'], (isset($_REQUEST['voucher']) ? 1 : 0));
				$gui->addContent("Bet created<br><a href=\"bets.php?type=1\">Create Another Bet</a> | <a href=\"index.php\">Return to Admin</a>");
			} else {
				$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");					
				$gui->addContent("<table>");
				$divisions = $roster->GetDivisions('name');
				$options = array();
				$exclude = array(16, 0);
				foreach ($divisions as $div) {
					if (in_array($div->GetID(), $exclude)) {
						continue;
					}
					if ($div->GetMemberCount()) {
						$members = $div->GetMembers('name');
						foreach ($members as $pleb) {
							$options[] = '<option value="'.$pleb->GetID().'">'.$div->GetName() . ': ' . $pleb->GetName().'</option>';
						}
					}
				}
				$gui->addContent("<tr><td>Is A Voucher</tr></td><input type=\"checkbox\" value=\"1\" name=\"voucher\"></td></tr>\r\n");
				$gui->addContent("<tr><td>Hunter</td><td><select name=\"bhg_id\">".implode('', $options)."</select></td></tr>\r\n");
				$pods_array = $podracer->listOwnedPods();
				$gui->addContent("<tr><td>Pods</td><td><select name=\"pod_id\">");
				for ($i = 0; $i < sizeof ($pods_array); $i++)
				{
					$pod = $pods_array [$i];
					$gui->addContent("<option value=\"".$pod->getID()."\">".$pod->getName()."</option>\r\n");
					unset ($pod);
				}
				$gui->addContent("</select></td></tr>");
				$races_array = $podracer->listRaces();
				$gui->addContent("<tr><td>Race</td><td><select name=\"race_id\"><br>");
				for ($i = 0; $i < sizeof ($races_array); $i++)
				{
					$race = $races_array [$i];
					$gui->addContent("<option value=\"".$race->getID()."\">".$race->getName()."</option>\r\n");
					unset ($race);
				}
				$gui->addContent("</select></td></tr>");
				$gui->addContent("<tr><td>Amount</td><td><input type=\"text\" name=\"amount\"></td></tr>");
				$gui->addContent("</table>");
				$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">");
				$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
				$gui->addContent("</form>\r\n");
			}
		} elseif (isset($_REQUEST['selected'])) {
			if ($_REQUEST['type'] == 2) {
				if (isset($_REQUEST['Submit'])) {
					$bet = new Bet ($_REQUEST['selected']);
					$bet->setBhgid($_REQUEST['bhg_id']);
					$bet->setPod($_REQUEST['pod_id']);
					$bet->setRace($_REQUEST['race_id']);
					$bet->setAmount($_REQUEST['amount']);
					$gui->addContent("Bet edited<br><a href=\"bets.php?type=2\">Edit Another Part</a> | <a href=\"index.php\">Return to Admin</a>");
				} else {
					$bet = new Bet ($_REQUEST['selected']);
					$edit_race = $bet->getRace();
					$edit_pod = $bet->getPod();
					$edit_person = $bet->getBhgId();
					$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
					$gui->addContent("<table>");
					$divisions = $roster->GetDivisions('name');
					$options = array();
					$exclude = array(16, 0);
					foreach ($divisions as $div) {
						if (in_array($div->GetID(), $exclude)) {
							continue;
						}
						if ($div->GetMemberCount()) {
							$members = $div->GetMembers('name');
							foreach ($members as $pleb) {
								$is = $edit_person->GetID() == $pleb->GetID();
								$options[] = '<option value="'.$pleb->GetID().'"'.($is ? ' selected' : '').'>'.$div->GetName() . ': ' . $pleb->GetName().'</option>';
							}
						}
					}
					$gui->addContent("<tr><td>Is A Voucher</tr></td><input type=\"checkbox\" value=\"1\" name=\"voucher\" ".($bet->GetVoucher ? 'checked' : '')."></td></tr>\r\n");
					$gui->addContent("<tr><td>Hunter</td><td><select name=\"bhg_id\">".implode('', $options)."</select></td></tr>");
					$pods_array = $podracer->listOwnedPods();
					$gui->addContent("<tr><td>Pod</td><td><select name=\"pod_id\"><br>");
					for ($i = 0; $i < sizeof ($pods_array); $i++) {
						$pod = $pods_array [$i];
						$gui->addContent("<option value=\"".$pod->getID()."\"");
						if ($edit_pod->getID() == $pod->getID())
						{
							$gui->addContent(" selected");
						}
						$gui->addContent(">".$pod->getName()."</option>\r\n");
						unset ($pod);
					}
					$gui->addContent("</select></td></tr>");					
					$races_array = $podracer->listRaces();
					$gui->addContent("<tr><td>Race</td><td><select name=\"race_id\"><br>");
					for ($i = 0; $i < sizeof ($races_array); $i++) {
						$race = $races_array [$i];
						$gui->addContent("<option value=\"".$race->getID()."\"");
						if ($edit_race->getID() == $race->getID())
						{
							$gui->addContent(" selected");
						}
						$gui->addContent(">".$race->getName()."</option>\r\n");
						unset ($race);
					}
					$gui->addContent("</select></td></tr>");						
					$gui->addContent("<tr><td>Amount</td><td><input type=\"text\" name=\"amount\" value=\"".$bet->getAmount()."\"></td></tr>");
					$gui->addContent("</table>");
					$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">");
					$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
					$gui->addContent("<input type=\"hidden\" name=\"selected\" value=\"".$_REQUEST['selected']."\">\r\n");
					$gui->addContent("</form>\r\n");
				}
			} elseif ($_REQUEST['type'] == 3) {
				$vet = new Bet($_REQUEST['selected']);
				$vet->delete();
				$gui->addContent("Bet deleted<br><a href=\"bets.php?type=3\">Delete Another Bet</a> | <a href=\"index.php\">Return to Admin</a>");
			}
		} else {
			$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");	
			$gui->addContent("<select name=\"selected\">\r\n");
			$bets_array = $podracer->listBet();
			for ($i = 0; $i < sizeof ($bets_array); $i++)
			{
				$bet = $bets_array [$i];
				$person = $bet->getBhgid();
				$pod = $bet->getPod();
				$race = $bet->getRace();
				$gui->addContent("<option value=\"".$bet->getID()."\">".$person->getName()." with ".number_format($bet->getAmount())." Credits on \"".$pod->getName()."\" in ".$race->getName()."</option>\r\n");
				unset($race);
				unset($pod);
				unset($person);
				unset($bet);
			}		
			$gui->addContent("</select>\r\n");
			$gui->addContent("<input type=\"Submit\" name=\"Select\" value=\"Select\">");
			$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
			$gui->addContent("</form>\r\n");
		}				
		$gui->outputGui();
	} else  {
		die(login_failed());
	}
?>