<?php
$prefix = 'hn_';

function title() {
	return 'Administration :: Pending Credits';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return ($auth_data['underlord'] || $auth_data['judicator']);
}

function output() {
	global $auth_data, $pleb, $roster, $page, $prefix;

	roster_header();

	$pos = $pleb->GetPosition();
	
	if ($_REQUEST['submit']) {
    
		$hold_ids = array();
    
    $reason_ids = $_REQUEST['reasons'];

    // If its not the Judicator
		if ($pos->GetID() != 6) {
      
			foreach ($_REQUEST['action'] as $cid=>$approval) {
        
				if ($approval == "approve") {
          
					$pleb = $roster->GetPerson($_REQUEST['id'][$cid]);
          
					$pleb->AddCredits($_REQUEST['credits'][$cid]);
          
				} elseif ($approval == "hold") {
          
					$hold_ids[] = $cid;

          $sql = "SELECT * FROM {$prefix}pending_credits WHERE id=$cid";
          
					$credit_result = mysql_query($sql, $roster->roster_db) 
            or printf("Error Loading Credit Award.<br>ERROR: %s<br>SQL %s<BR>", 
                mysql_error($roster->roster_db),
                $sql);
          
					if (in_array(mysql_result($credit_result, 0, "reason"), 
                       $reason_ids)) {
            
            array_splice($reason_ids, 
                         array_search(mysql_result($credit_result, 0, "reason"),
                                      $reason_ids), 
                         1);
            
					}
          
				}
        
			}
      
			$reason_ids = implode(",", $reason_ids);
      
      $sql = "DELETE FROM {$prefix}pending_reasons WHERE id IN ($reason_ids)";
      
			mysql_query($sql, $roster->roster_db) 
        or printf("Error Deleteing Reasons.<br>ERROR: %s<br>SQL: %s<br>", 
            mysql_error($roster->roster_db),
            $sql);

      $sql = "DELETE FROM {$prefix}pending_credits "
            ."WHERE reason IN ($reason_ids)" 
            .(count($hold_ids) 
                ? (" AND id NOT IN (" . implode(",", $hold_ids)) 
                : "");
      
			mysql_query($sql, $roster->roster_db) 
        or printf("Error Deleting Credits.<br>ERROR: %s<br>SQL: %s<br>", 
            mysql_error($roster->roster_db));
      
			echo "Pending awards successfully approved and/or denied.<br><br>\n";
      
		}	else {
      // We are the Judicator so do things different
      
			foreach ($_REQUEST['action'] as $cid=>$approval) {
        
				if ($approval == "deny") {

          $sql = "DELETE FROM {$prefix}pending_credits "
                ."WHERE id=" . $_REQUEST['id'][$cid];
          
					mysql_query($sql, $roster->roster_db) 
            or printf("Error Deleting Credit Request."
                ."<BR>ERROR: %s<br>SQL: %s<BR>", 
                mysql_error($roster->roster_db),
                $sql);
          
				}	elseif ($approval == "hold") {
          
					$hold_ids[] = $cid;

          $sql = "SELECT * FROM {$prefix}pending_credits WHERE id=$cid";
          
					$credit_result = mysql_query($sql, $roster->roster_db) 
            or printf("Error Loading Credit Reason.<BR>ERROR: %s<br>"
                ."SQL: %s<BR>", 
                mysql_error($roster->roster_db),
                $sql);
          
					if (in_array(mysql_result($credit_result, 0, "reason"), 
                       $reason_ids)) {
            
						array_splice($reason_ids, 
                         array_search(mysql_result($credit_result, 0, "reason"),
                                      $reason_ids), 
                         1);
            
					}
          
				}
        
			}
      
			$reason_ids = implode(",", $reason_ids);

      $sql = "UPDATE {$prefix}pending_reasons "
            ."SET jud_pending=0 "
            ."WHERE id IN ($reason_ids)";
      
			mysql_query($sql, $roster->roster_db) 
        or printf("Error Approving Reasons.<BR>ERROR: %s<br>SQL: %s<BR>", 
            mysql_error($roster->roster_db),
            $sql);
      
			echo "Pending awards successfully approved and/or denied, and are now "
        ."awaiting final approval from the Underlord.<br><br>\n";
      
		}
    
	}

  $sql = "SELECT * FROM {$prefix}pending_reasons " 
    . ($pos->GetID() == 6 
        ? "WHERE jud_pending=1 " 
        : "WHERE jud_pending=0 ") 
    . "ORDER BY reason ASC";
  
	$pending_reasons = mysql_query($sql, $roster->roster_db) 
    or printf("Error Loading Credit Reasons.<BR>ERROR: %s<br>SQL: %s<br>", 
        mysql_error($roster->roster_db),
        $sql);
  
	if (mysql_num_rows($pending_reasons) == 0) {
    
		echo "There are no pending credit awards.";
    
	} else {
    
		$form = new Form($page);
    
		while ($reason = mysql_fetch_array($pending_reasons)) {
      
			$form->AddHidden('reasons[]', $reason['id']);

      $sql = "SELECT * FROM {$prefix}pending_credits "
        ."WHERE reason={$reason['id']}";
      
			$pending_credits = mysql_query($sql, $roster->roster_db) 
        or printf("Error Loading Credits.<BR>ERROR: %s<br>SQL: %s<br>", 
            mysql_error($roster->roster_db),
            $sql);
      
			if (mysql_num_rows($pending_credits)) {
        
				$awarder = $roster->GetPerson($reason['person']);
        
				$form->table->StartRow();
				$form->table->AddHeader(stripslashes($reason['reason']) 
                                . ' (From ' . $awarder->GetName() . ')', 3);
				$form->table->EndRow();

				$form->table->StartRow();
				$form->table->AddHeader('Person');
				$form->table->AddHeader('Action');
				$form->table->AddHeader('Credits');
				$form->table->EndRow();

				while ($credit = mysql_fetch_array($pending_credits)) {
        
					$credit_id = $credit['id'];
          
					$awardee = $roster->GetPerson($credit['person']);
          
					$form->AddHidden("id[$credit_id]", $credit['person']);
					$form->table->StartRow();
					$form->table->AddCell($awardee->GetName());
					$form->table->AddCell("<select name=\"action[$credit_id]\">"
            ."<option value=\"approve\">Approve</option>"
            ."<option value=\"deny\">Deny</option>"
            ."<option value=\"hold\">Hold</option>"
            ."</select>");
  				$form->table->AddCell("<input type=\"text\" "
              ."name=\"credits[$credit_id]\" "
              ."value=\"" . $credit["credits"] . "\">");
					$form->table->EndRow();
          
					$form->table->StartRow();
					$form->table->AddCell('&nbsp;', 3);
					$form->table->EndRow();
          
				}
        
			}
      
		}
    
		$form->table->StartRow();
		$form->table->AddCell('&nbsp;', 2);
		$form->table->AddCell('<input type="submit" name="submit" value="Award Credits">');
		$form->table->EndRow();
		$form->EndForm();
	}

	admin_footer($auth_data);
  
}
?>
