<?php

function title() {
	
	$return = '';
	
	if (isset($_REQUEST['id'])){
		$person = new Person($_REQUEST['id']);
    	$return .= $person->GetName().'\'s ';
	} 
	
	$return .= 'Character Sheet';
	
	return $return;
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return true;
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet;
    
    arena_header();

    if (isset($_REQUEST['id'])){
    
	    if ($_REQUEST['id'] != $hunter->GetID() && !$auth_data['sheet']){
		    echo 'You do not have permission to edit this sheet.';
		    admin_footer($auth_data);
		    return;
	    }	    
	    
    }
    
    if (!isset($_REQUEST['id'])){
	    if (!$auth_data['sheet']){
		    echo 'Hunter Variable required to proceed.';
	    } else {
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('Character Sheets', 6);
		    $table->EndRow();

		    $table->AddRow('Hunter Name', 'Date Submitted', 'Status', '&nbsp;', '&nbsp;', '&nbsp;');
		    
		    foreach ($sheet->SheetHolders() as $character){
			    
			    if ($character->Status('SYSTEM') == 4){
				    $status = '<b>'.$character->Status('HUMAN').'</b>';
			    } else {
				    $status = $character->Status('HUMAN');
			    }
			    
			    $table->AddRow('<a href="' . internal_link('atn_general', array('id'=>$character->GetID())) . '">' . $character->GetName() . '</a>', 
			    $character->LastEdit(), $status, 
			    '<a href="' . internal_link('admin_sheet', array('id'=>$character->GetID())).'">Edit</a>', '<a href="' . 
			    internal_link('admin_sheet', array('id'=>$character->GetID(), 'view'=>1)).'">View for Approval</a>', '<a href="' . 
			    internal_link('admin_kill', array('id'=>$character->GetID())).'">Kill Sheet</a>');
		    }
		    
		    $table->EndTable();
	    }
	    admin_footer($auth_data);
	    return;
    }
    
	    $character = new Character($_REQUEST['id']);

	    if ($character->InProgress() || $character->PendingApproval()){
			$getvalue = 'pending';
		} else {
			$getvalue = 'values';
		}
	    
		$value_set = $character->GetSheetValues($getvalue);
		
		if ($character->IsNew()){
			if (!$character->NewSheet()){
				echo 'Could not create a new sheet. Report this to the Overseer.';
				admin_footer($auth_data);
				return;
			}
		}
		
		$can_edit = false;
		
		if ($character->Editable() || $_REQUEST['approve'] || $auth_data['sheet']){
			$can_edit = true;
		}
		
		if ($can_edit){			
			
			if (isset($_REQUEST['buypoint'])){
				for ($i = 1; $i <= $_REQUEST['points']; $i++){
					$character->BuyPoint();
				}
				echo 'Purchased '.$_REQUEST['points'].' bonus points';
				admin_footer($auth_data);
	    		return;
			}
			
			if (isset($_REQUEST['save'])){
				if ($auth_data['sheet']){
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
				    $form->AddHidden('id', $_REQUEST['id']);    	
				    $form->AddHidden('save', 1);
				    $form->AddTextArea('Reason (for denial): ', 'reason');
				    $form->table->StartRow();
				    $form->table->AddCell('<input type="submit" name="deny" Value="Deny Sheet"> || <input type="submit" name="approve" Value="Approve Sheet">', 2);
				    $form->table->EndRow();
			    	$form->EndForm();
		    	} else {
			    	$form = new Form($page);	
				    $form->AddHidden('id', $_REQUEST['id']);    	
				    $form->table->AddRow('<input type="submit" name="save" Value="Submit Sheet">');
			    	$form->EndForm();
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
					$form->AddHidden('id', $_REQUEST['id']);
					$form->table->AddRow('<input type="submit" name="buypoint" value="Buy '.$tobuy.' Bonus Point'.$s.'">');
					$form->EndForm();
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
		    	
		    	for ($i = 1; $i <= 6; $i++){
			    	$field = new Field($i);
				    $form->AddSectionTitle($field->GetName());
			    	foreach($sheet->GetStats($i) as $stat){
				    	if ($i <= 2){
					    	$prefix = 'stat';
				    	} else {
					    	$prefix = 'expr';
				    	}
				    	$value = 0;
				    	if (array_key_exists($stat->GetID(), $value_set)){
					    	$value = $value_set[$stat->GetID()];
				    	}
					    $form->AddTextBox($stat->GetName().' (<a href="'.internal_link('desc', array('id'=>$stat->GetID())).'">Description</a>)', $prefix."[".$stat->GetID()."]", $value, 5);
			    	}
		    	}
		    	for ($i = 10; $i <= 11; $i++){
			    	$field = new Field($i);
				    $form->AddSectionTitle($field->GetName());
			    	foreach($sheet->GetStats($i) as $stat){
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
				    		$form->AddTextArea($stat->GetName().' (<a href="'.internal_link('desc', array('id'=>$stat->GetID())).'">Description</a>)', "pers[".$stat->GetID()."]", stripslashes($value));
			    		}
			    	}
		    	}
		    	$form->AddHidden('id', $_REQUEST['id']);
		    	$form->AddHidden('process', 1);
		    	$form->AddSubmitButton('view', 'Check Sheet');
		    	$form->EndForm();
	    	}		    	
    	} else {
	    	echo 'This form is currently pending approval';
    	}
	
	admin_footer($auth_data);

}
?>