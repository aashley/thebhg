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
		    $table->AddHeader('Character Sheets', 7);
		    $table->EndRow();

		    $sheets = array();
		    
		    foreach ($sheet->SheetHolders(1) as $data){
			    $sheets[$data->Status('SYSTEM')][] = $data;
		    }
		    
		    krsort($sheets);
		    $table->AddRow('Hunter Name', 'Date Submitted', 'Status', 'Edit Ban Till', '&nbsp;', '&nbsp;', '&nbsp;');
		    
		    foreach ($sheets as $sheeted){
			    foreach ($sheeted as $character){
			    
				    if ($character->Status('SYSTEM') == 5 || $character->Status('SYSTEM') == 6){
					    $status = '<b>'.$character->Status('HUMAN').'</b>';
				    } else {
					    $status = $character->Status('HUMAN');
				    }
				    
				    $table->AddRow('<a href="' . internal_link('atn_general', array('id'=>$character->GetID())) . '">' . $character->GetName() . '</a>', 
				    $character->LastEdit(), $status, $character->GetBan('HUMAN'),
				    '<a href="' . internal_link('admin_sheet', array('id'=>$character->GetID())).'">Edit</a>', '<a href="' . 
				    internal_link('admin_sheet', array('id'=>$character->GetID(), 'view'=>1)).'">View for Approval</a>', '<a href="' . 
				    internal_link('admin_kill', array('id'=>$character->GetID())).'">Kill Sheet</a>');
			    }
		    }
		    
		    $table->EndTable();
	    }
	    admin_footer($auth_data);
	    return;
    }
    
    if ($_REQUEST['id']){
		$character = new Character($_REQUEST['id']);

	    if ($character->InProgress() || $character->PendingApproval()){
			$getvalue = 'pending';
		} else {
			$getvalue = 'values';
		}
	    
		$value_set = $character->GetSheetValues($getvalue);
		
		if ($character->IsNew()){
			if (!$character->NewSheet()){
				NEC(161);
				admin_footer($auth_data);
				return;
			} else {
				$sheet->RegistrarTrack('new');
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
					$sheet->RegistrarTrack('bp');
				}
				echo 'Purchased '.$_REQUEST['points'].' bonus points';
				admin_footer($auth_data);
	    		return;
			}
			
		if (isset($_REQUEST['save'])){
					    	
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