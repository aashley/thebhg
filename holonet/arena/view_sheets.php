<?php

function title() {
	return 'General :: View All Sheets';
}

function output() {
    global $hunter, $page, $roster, $sheet;
    
    $sheets = array();
    
    arena_header();

    $table = new Table('', true);
    $table->StartRow();
    $table->AddHeader('Character Sheets', 6);
    $table->EndRow();

    $table->AddRow('Hunter Name', 'Date Submitted', 'Status');
    
    foreach ($sheet->SheetHolders() as $character){
	    $sheets[$character->GetName()] = $character;
    }
    
    ksort($sheets);
    
    foreach ($sheets as $character){
	    $table->AddRow('<a href="' . internal_link('atn_general', array('id'=>$character->GetID())) . '">' . $character->GetName() . '</a>', 
	    $character->LastEdit(), $character->Status('HUMAN'));
    }
    
    $table->EndTable();
	
	arena_footer();

}
?>