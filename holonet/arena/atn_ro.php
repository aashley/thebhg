<?php

function title() {
    global $hunter;

    return 'AMS Tracking Network :: Run-Ons :: Run-Ons';
}

function output() {
    global $arena;

    arena_header();

    echo '<a name="stats"></a>';
    $table = new Table('', true);
    $table->StartRow();
    $table->AddHeader('Run-Ons', 3);
    $table->EndRow();
    $table->AddRow('Name', 'Status', 'Links');

    $ro = new RO();
    
    foreach($ro->GetROs() as $value){
	    $table->AddRow($value->GetName(), $value->GetStatus(), '<a href="' . internal_link('atn_run_on', array('id'=>$value->GetID())) . '">ATN Stats</a> | '.$value->ArenaLink());
    }

    $table->EndTable();

    arena_footer();
}
?>