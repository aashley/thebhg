<?php
$prefix = 'hn_';

function title() {
	return 'Administration :: Pending Medals';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return ($auth_data['underlord'] || $auth_data['judicator']);
}

function next_medal($person, $group) {
	global $mb;

	$mg = $mb->GetMedalGroup($group);
	if ($mg->GetDisplayType() != 0) {
		echo 'Numeric medal, leaving immediately.<br>';
		$medals = $mg->GetMedals();
		return $medals[0];
	}
	
	$medals = $person->GetMedals();
	if (count($medals)) {
		$orders = array();
		$group_medals = $mg->GetMedals();
		foreach ($group_medals as $medal) {
			$orders[$medal->GetOrder()] = 0;
		}
		foreach ($medals as $am) {
			$medal = $am->GetMedal();
			$mgroup = $medal->GetGroup();
			if ($mgroup->GetID() == $group) {
				$orders[$medal->GetOrder()]++;
			}
		}
		ksort($orders);
		$last = 0;
		foreach ($orders as $key=>$o) {
			if ($o < $last) {
				$order = $key;
				break;
			}
			$last = $o;
		}
		if (empty($order)) {
			$order = min(array_keys($orders));
		}
		
		$medals = $mg->GetMedals();
		foreach ($medals as $medal) {
			if ($medal->GetOrder() == $order) {
				return $medal;
			}
		}
		return $medals[0];
	}
	else {
		$medals = $mg->GetMedals();
		return $medals[0];
	}
}

function output() {
	global $auth_data, $pleb, $prefix, $roster, $mb, $page;

	roster_header();

	$pos = $pleb->GetPosition();
	
	if ($_REQUEST['submit']) {
    
		$hold_ids = array();
    
		if ($pos->GetID() != 10) {
      
			foreach ($_REQUEST['action'] as $cid=>$approval) {
        
				if ($approval == "approve") {
          
					$next = next_medal($roster->GetPerson($_REQUEST['id'][$cid]), 
                             $_REQUEST['group'][$cid]);
          
          if ($mb->AwardMedal($roster->GetPerson($_REQUEST['id'][$cid]), 
                              $roster->GetPerson($_REQUEST['awarder'][$cid]), 
                              $next, 
                              $_REQUEST['reason'][$cid])) {
            
						echo 'Medal awarded successfully.<br>';
            
					}	else {
            
						echo 'Error awarding medal: ' . $mb->Error() . '<br>';
            
					}
          
				}	elseif ($approval == "hold") {
          
					echo 'Holding medal.<br>';
					$hold_ids[] = $cid;
          
				}	else {
          
          echo 'Denying medal.<br>';
          
				}
        
			}

      $sql = "DELETE FROM {$prefix}pending_medals" 
        .(count($hold_ids) 
          ? (" WHERE id NOT IN (" . implode(",", $hold_ids) . ")") 
          : "");
      
			mysql_query($sql, $roster->roster_db) 
        or printf("Error: %s<br>", mysql_error($roster->roster_db));
        
			echo "Pending medal awards successfully approved and/or denied.<br><br>\n";
      
		}	else {
      
			foreach ($_REQUEST['action'] as $cid=>$approval) {
        
				if ($approval == "deny") {
          
					mysql_query("DELETE FROM {$prefix}pending_medals "
                     ."WHERE id=" . $cid, $roster->roster_db) 
            or printf("Error: %s<br>", mysql_error($roster->roster_db));
            
				}	elseif ($approval == "hold") {
          
					$hold_ids[] = $cid;
          
				}
        
			}
      $viewed = array_keys($_REQUEST['action']);
			mysql_query("UPDATE {$prefix}pending_medals "
                 ."SET jud_pending=0 " 
                 .'WHERE id IN (' . implode(',', $viewed) . ') '
                 .(count($hold_ids) 
                    ? (" AND id NOT IN (" . implode(',', $hold_ids) . ")") 
                    : ""), $roster->roster_db) 
        or printf("Error: %s<br>", mysql_error($roster->roster_db));
        
			echo "Pending medal awards successfully approved and/or denied, "
        ."and are now awaiting final approval from the Underlord.<br><br>\n";
        
		}
    
	}
  
	$pending_reasons = 
    mysql_query("SELECT * "
               ."FROM {$prefix}pending_medals " 
               .($pos->GetID() == 10 
                 ? "WHERE jud_pending=1 " 
                 : "WHERE jud_pending=0 "), 
               $roster->roster_db) 
    or printf("Error: %s<br>", mysql_error($roster->roster_db));
  
	if (mysql_num_rows($pending_reasons) == 0) {
		echo "There are no pending medal awards.";
	}
	else {
		$form = new Form($page);
		$form->table->StartRow();
		$form->table->AddHeader('Awarder');
		$form->table->AddHeader('Recipient');
		$form->table->AddHeader('Medal');
		$form->table->AddHeader('Reason');
		$form->table->AddHeader('Action');
		$form->table->EndRow();
		while ($reason = mysql_fetch_array($pending_reasons)) {
			$form->AddHidden('awarder[' . $reason['id'] . ']', $reason['awarder']);
			$form->AddHidden('id[' . $reason['id'] . ']', $reason['person']);
			$form->AddHidden('group[' . $reason['id'] . ']', $reason['medal']);
			$form->AddHidden('reason[' . $reason['id'] . ']', $reason['reason']);
			$awarder = $roster->GetPerson($reason['awarder']);
			$recip = $roster->GetPerson($reason['person']);
			$medal = $mb->GetMedalGroup($reason['medal']);
			$form->table->StartRow();
			$form->table->AddCell($awarder->GetName());
			$form->table->AddCell($recip->GetName());
			$form->table->AddCell($medal->GetName());
			$form->table->AddCell(html_escape(stripslashes($reason['reason'])));
			$form->table->AddCell("<select name=\"action[{$reason['id']}]\"><option value=\"approve\">Approve</option><option value=\"deny\">Deny</option><option value=\"hold\">Hold</option></select>");
			$form->table->EndRow();
		}
		$form->table->StartRow();
		$form->table->AddCell("<center><input type=\"submit\" name=\"submit\" value=\"Award Medals\"></center>", 5);
		$form->table->EndRow();
		$form->EndForm();
	}

	admin_footer($auth_data);
}
?>
