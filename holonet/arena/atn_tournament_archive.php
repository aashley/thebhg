<?php

function title() {
    global $hunter;

    return 'AMS Tracking Network :: Arena Tournament';
}

function output() {
    global $arena;

    arena_header();
    
    $at = new Tournament();
    
    $table = new Table('', true);
    
    $table->StartRow();
    $table->AddHeader('Archived Tournament Seasons');
    $table->EndRow();
    
    foreach ($at->Seasons() as $value){
	    $table->AddRow('<a href="' . internal_link('atn_tournament', array('id'=>$value)) . '"> Season ' . $value . '</a>');
    }
    
    $table->EndTable();

    arena_footer();
}
?>