<?php

function title() {
	
	$return = '';
	
	if (isset($_REQUEST['bhg_id'])){
		$person = new Person($_REQUEST['bhg_id']);
    	$return .= $person->GetName().'\'s ';
	} 
	
	$return .= 'Character Sheet';
	
	return $return;
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    if (!$_REQUEST['bhg_id']){
	    return false;
    }
    if ($_REQUEST['bhg_id'] != $hunter->GetID() && !$auth_data['sheet']){
	    return false;
    }
    return true;
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet;
    
    arena_header();
    
    if (isset($_REQUEST['bhg_id']) && $_REQUEST['kill']){
		$character = new Character($_REQUEST['bhg_id']);
	
		if (isset($_REQUEST['submit'])){
			echo $character->Kill($_REQUEST['reason']);
		} else {
			$form = new Form($page);
			$form->AddHidden('bhg_id', $_REQUEST['bhg_id']);
			$form->AddHidden('kill', 1);
			$form->AddTextArea('Reason (for denial): ', 'reason');
			echo '<center><input style="background-color: red; font-weight: bold; border: dotted" type="submit" name="submit" value="Confirm Character Assassination"><center>';
			$form->EndForm();
		}
		admin_footer($auth_data);
		return;
	}
    
    if ($_REQUEST['view'] > 1){
	    $_REQUEST['bhg_id'] = $_REQUEST['view'];
    }
    
    if ($_REQUEST['bhg_id']){
		$character = new Character($_REQUEST['bhg_id']);
		
		if ($character->IsNew()){
			if (!$character->NewSheet()){
				admin_footer($auth_data);
				return;
			}
		}
		
		if ($character->InProgress() || $character->PendingApproval()){
			$getvalue = 'pending';
		} else {
			$getvalue = 'values';
		}
	    
		$value_set = $character->GetSheetValues($getvalue);
		
		$can_edit = false;
		
		if ($character->Editable() || $_REQUEST['approve'] || $auth_data['sheet']){
			$can_edit = true;
		}
		
		if ($can_edit){
			if (isset($_REQUEST['buypoint'])){
				$points = $character->GetExperiencePoints()/350;
				if ($points >= $_REQUEST['points']){
					for ($i = 1; $i <= $_REQUEST['points']; $i++){
						$character->BuyPoint();
					}
					echo 'Purchased '.$_REQUEST['points'].' bonus points';
				} else {
					echo 'Bad monkey. No cookie.';
				}
				admin_footer($auth_data);
	    		return;
			}
			
		if (isset($_REQUEST['save'])){
			if ($auth_data['sheet']){
					if (!$_REQUEST['canedit']){
						$character->Ban(parse_date_box('edit'));
					}
					if ($_REQUEST['approve']){
						echo $character->Approve();
					} else {
						echo $character->Deny($_REQUEST['reason']);
					}
				} else {
					echo $character->SubmitSheet();
				}
			} elseif (isset($_REQUEST['view'])){
				if (isset($_REQUEST['process'])){
					echo $character->SaveSheet($_REQUEST['stat'], $_REQUEST['expr'], $_REQUEST['pers']);
					hr();
				}
				
				$character->ParseSheet('pending');
			    
			    hr();
			    
			    if ($auth_data['sheet']){
				    $form = new Form($page);	
				    $form->AddHidden('bhg_id', $_REQUEST['bhg_id']);    	
				    $form->AddHidden('save', 1);
				    $form->AddCheckBox('Can Always Edit: ', 'canedit', '1', true);
				    $time = time()+(60*60*24*7);
				    $form->AddDateBox('Can Not Edit Until: ', 'edit', $time);
				    $form->AddTextArea('Reason (for denial): ', 'reason');
				    $form->table->StartRow();
				    $form->table->AddCell('<input type="submit" name="deny" Value="Deny Sheet"> || <input type="submit" name="approve" Value="Approve Sheet">', 2);
				    $form->table->EndRow();
			    	$form->EndForm();
		    	} else {
			    	$character->UpdateCache();
			    	if ($character->HasValue('pending')){
				    	$form = new Form($page);	
					    $form->AddHidden('bhg_id', $_REQUEST['bhg_id']);    	
					    $form->table->AddRow('<input type="submit" name="save" Value="Submit Sheet">');
				    	$form->EndForm();
			    	} else {
				    	echo '<h4>You Cannot Submit a Blank Sheet for Approval!</h4>';
			    	}
		    	}
			} else {
				
				$points = $character->GetExperiencePoints()/350;			
				$tobuy = floor($points);
				
				if ($tobuy < 1){
					$tobuy = 0;
				}
				
				$s = '';
				
				if ($tobuy > 1){
					$s = 's';
				}
				
				if ($tobuy){
					$form = new Form($page);
					$form->AddHidden('points', $tobuy);
					$form->AddHidden('buypoint', 1);
					$form->AddHidden('bhg_id', $_REQUEST['bhg_id']);
					$form->table->AddRow('<input type="submit" name="buypoint" value="Buy '.$tobuy.' Bonus Point'.$s.'">');
					$form->EndForm();
					
					hr();
				}
				
				$table = new Table();
				$table->StartRow();
				$table->AddHeader('Points to Distribute', 2);
				$table->EndRow();
				$table->AddRow('Statribute Points: ', $sheet->StatributePoints());
				$table->AddRow('Expertise Points: ', $character->TotalPoints());
				$table->EndTable();
				
				hr();
			    
		    	$form = new Form($page);
		    	
		    	foreach($sheet->GetStats(12) as $stat){
			    	if ($stat->IsInt()){
				    	$value = 0;
				    	if (array_key_exists($stat->GetID(), $value_set)){
					    	$value = $value_set[$stat->GetID()];
				    	}
			    		$form->AddTextBox($stat->GetName().' (<a href="'.internal_link('desc', array('id'=>$stat->GetID())).'">Description</a>)', "pers[".$stat->GetID()."]", $value, 5);
		    		} else {
			    		$value = '';
				    	if (array_key_exists($stat->GetID(), $value_set)){
					    	$value = $value_set[$stat->GetID()];
				    	}
			    		$form->AddTextBox($stat->GetName().' (<a href="'.internal_link('desc', array('id'=>$stat->GetID())).'">Description</a>)', "pers[".$stat->GetID()."]", stripslashes($value));
		    		}
		    	}
		    	foreach ($sheet->ModFields(1) as $i){
			    	$count = 0;
			    	foreach ($sheet->GetStats($i) as $stat){
				    	if ($sheet->Permit(1, $stat->GetID(), 1)){
					    	$count++;
				    	}
			    	}
			    	if ($count){
			    		$field = new Field($i);
				    	$table->StartRow();
						$table->AddHeader($field->GetName(), 2);
						$table->EndRow();
				    	foreach($sheet->GetStats($i) as $stat){
					    	$value = '';
					    	if (array_key_exists($stat->GetID(), $value_set)){
						    	$value = $value_set[$stat->GetID()];
					    	}
					    	if ($i <= 2){
						    	$prefix = 'stat';
					    	} elseif ($i <= 6){
						    	$prefix = 'expr';
					    	} else {
						    	$prefix = 'pers';
					    	}
					    	if ($sheet->Permit(1, $stat->GetID(), 1)){
						    	if ($stat->IsInt()){
					    			$form->AddTextBox($stat->GetName().' (<a href="'.internal_link('desc', array('id'=>$stat->GetID())).'">Description</a>)', $prefix."[".$stat->GetID()."]", $value, 5);
				    			} else {
					    			$form->AddTextArea($stat->GetName().' (<a href="'.internal_link('desc', array('id'=>$stat->GetID())).'">Description</a>)', "pers[".$stat->GetID()."]", stripslashes($value));
				    			}
				    		}
				    	}
			    	}
		    	}
		    	$form->AddHidden('bhg_id', $_REQUEST['bhg_id']);
		    	$form->AddHidden('process', 1);
		    	$form->AddSubmitButton('view', 'Check Sheet');
		    	$form->EndForm();
	    	}	  	
    	} else {
	    	echo 'Can not make any edits to this sheet.';
	    	if ($character->GetBan()){
		    	echo ' You are on an Edit Ban until '.$character->GetBan('HUMAN');
	    	} else {
		    	echo ' This character is pending approval.';
	    	}
    	}
	}
	
	admin_footer($auth_data);

}
?>