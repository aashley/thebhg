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
    global $auth_data, $hunter, $page, $roster, $sheet, $arena;
    
    arena_header();
    
    $form = new Form('admin_sheet');
    $form->AddSectionTitle('Choose Sheet to Manage');
    include_once 'search.php';
    $form->table->startrow();
    $form->table->AddCell('<input type="submit" value="Edit Sheet">&nbsp;&nbsp;<input type="submit" name="kill" value="Kill">', 2);
    $form->table->endrow();
    $form->EndForm();
    
    if (count($sheet->Pending())){
    
	    hr();
	    
	    $table = new Table('', true);
	    $table->StartRow();
	    $table->AddHeader('Character Sheets', 7);
	    $table->EndRow();
	
	    $sheets = array();
	    
	    foreach ($sheet->Pending() as $data){
		    $data = new Character($data);
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
			    '<a href="' . internal_link('admin_sheet', array('bhg_id'=>$character->GetID())).'">Edit</a>', '<a href="' . 
			    internal_link('admin_sheet', array('bhg_id'=>$character->GetID(), 'view'=>1)).'">View for Approval</a>', '<a href="' . 
			    internal_link('admin_sheet', array('bhg_id'=>$character->GetID(), 'kill'=>1)).'">Kill Sheet</a>');
		    }
	    }
	    
	    $table->EndTable();
    }
    
    admin_footer($auth_data);
}
?>