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

    $table = new Table('', true);
    $table->StartRow();
    $table->AddHeader('Character Sheets', 7);
    $table->EndRow();

    $sheets = array();
    
    foreach ($sheet->GetSheets() as $data){
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
		    1,1,1,1,1);
	    }
    }
    
    $table->EndTable();
    admin_footer($auth_data);
}
?>