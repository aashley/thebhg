<?php

function title() {
	return 'General :: View All Sheets';
}

function output() {
    global $hunter, $page, $roster, $sheet;
    
    $sheets = array();
    
    arena_header();

    $form = new Form($page);
    $form->AddSectionTitle('Organize and Filter List');
    $form->StartSelect('Use: ', 'name', $_REQUEST['name']);
    	$form->AddOption('char', 'Character Name');
    	$form->AddOption('bhg', 'Roster Name');
    $form->EndSelect();
    $form->StartSelect('Kabal: ', 'kabal', $_REQUEST['kabal']);
    	$form->AddOption('all', 'All Kabals');
    	foreach ($roster->GetDivisions() as $kabal){
	    	if ($kabal->GetID() != 9 && $kabal->GetID() != 16) {
	    		$form->AddOption($kabal->GetID(), $kabal->GetName());
    		}
    	}
    $form->EndSelect();
    $form->StartSelect('Order By: ', 'order', $_REQUEST['order']);
    	$form->AddOption('name', 'Name');
    	$form->AddOption('sub', 'Submitted');
    	$form->AddOption('stat', 'Status');
    $form->EndSelect();
    $form->StartSelect('From: ', 'list', $_REQUEST['list']);
    	$form->AddOption('az', 'A-Z | Old-Recent');
    	$form->AddOption('za', 'Z-A | Recent-Old');
    $form->EndSelect();
    $form->AddSubmitButton('submit', 'Filter and Reorganize');
    $form->EndForm();
    
    hr();
    
    $table = new Table('', true);
    $table->StartRow();
    $table->AddHeader('Character Sheets', 6);
    $table->EndRow();

    $table->AddRow('Hunter Name', 'Date Submitted', 'Status');
    
    foreach ($sheet->SheetHolders() as $character){
	    $person = new Person($character->GetID());
	    $kabal = $person->GetDivision();
	    if ($_REQUEST['name'] == 'bhg'){
	    	$name = $person->GetName();
    	} else {
	    	$name = $character->GetName();
    	}
    	
    	if ($_REQUEST['kabal'] == 10){
	    	$other = 9;
    	} else {
	    	$other = 0;
    	}
    	
    	if ($_REQUEST['kabal'] == 'all' || $_REQUEST['kabal'] == $kabal->GetID() || $other == $kabal->GetID()){
	    	if ($_REQUEST['order'] == 'sub'){
	    		$sheets[$character->cs_last_change] = $character;
    		} elseif ($_REQUEST['order'] == 'stat'){
	    		$sheets[$character->Status('HUMAN')] = $character;
    		} else {
	    		$sheets[$name] = $character;
    		}
    	}
    }
    
    if ($_REQUEST['list'] == 'za'){
	    krsort($sheets);
    } else {
	    ksort($sheets);
    }
    
    foreach ($sheets as $character){
	    $person = new Person($character->GetID());
	    $kabal = $person->GetDivision();
	    if ($_REQUEST['name'] == 'bhg'){
	    	$name = $person->GetName();
    	} else {
	    	$name = $character->GetName();
    	}
	    $table->AddRow('<a href="' . internal_link('atn_general', array('id'=>$character->GetID())) . '">' . $name . '</a>', 
	    $character->LastEdit(), $character->Status('HUMAN'));
    }
    
    $table->EndTable();
	
	arena_footer();

}
?>