<?php

function title() {
	
	return 'Character Sheets :: List of Hunters';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['sheet'];
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet;
    
    arena_header();

    if ($_REQUEST['delb']){
	    $sheet->DeleteBlank();
	    echo 'Blanks Deleted';
    } else {
	    echo '<a href="'.internal_link($page, array('delb'=>1)).'">Clean Out Blank Sheets</a>';
    }
    
    hr();
    
    $form = new Form('admin_sheet');
    $form->table->StartRow();
    $form->table->AddHeader('Character Sheets', 7);
    $form->table->EndRow();

    $sheets = array();
    
    foreach ($sheet->SheetHolders(1) as $data){
	    $sheets[$data->Status('SYSTEM')][] = $data;
    }
    
    krsort($sheets);
    
    $form->table->StartRow();
    $form->table->AddCell('<right><input type="submit" value="Go"></right>', 7);
    $form->table->EndRow();
    
    $form->table->AddRow('Hunter Name', 'Date Submitted', 'Status', 'Edit Ban Till', 'Edit', 'View/Approve/Deny', 'Kill');
    
    foreach ($sheets as $sheeted){
	    foreach ($sheeted as $character){
	    
		    if ($character->Status('SYSTEM') == 5 || $character->Status('SYSTEM') == 6){
			    $status = '<b>'.$character->Status('HUMAN').'</b>';
		    } else {
			    $status = $character->Status('HUMAN');
		    }
		    
		    $table->AddRow('<a href="' . internal_link('atn_general', array('id'=>$character->GetID())) . '">' . $character->GetName() . '</a>', 
		    $character->LastEdit(), $status, $character->GetBan('HUMAN'), '<input type="radio" name="id" value="'.$character->GetID().'">', 
		    '<input type="radio" name="view" value="'.$character->GetID().'">', '<a href="'
		    .internal_link('admin_kill', array('id'=>$character->GetID())).'">Kill Sheet</a>');
	    }
    }
    
    $form->table->EndForm();
    admin_footer($auth_data);
}
?>