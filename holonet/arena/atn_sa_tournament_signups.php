<?php

function title() {
    global $hunter;

    return 'AMS Tracking Network :: Starfield Arena Tournament :: Signups';
}

function output() {
    global $arena;

    arena_header();
    
    $at = new SATournament();

    echo '<a name="stats"></a>';
    $table = new Table('', true);
    $table->StartRow();
    $table->AddHeader('Signups for Season '.$at->CurrentSeason());
    $table->EndRow();
    
    foreach($at->GetHunters() as $value){
        $table->AddRow('<a href="' . internal_link('atn_general', array('id'=>$value->GetID())) . '">' . $value->GetName() . '</a>');
    }

    $table->EndTable();

    arena_footer();
}
?>