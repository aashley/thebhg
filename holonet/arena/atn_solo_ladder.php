<?php

function title() {
    global $hunter;

    return 'AMS Tracking Network :: Solo Mission :: Contract Ladder';
}

function output() {
    global $arena, $roster;

    arena_header();

    $table = new Table('', true);
    $table->StartRow();
    $table->AddHeader('Solo Mission Contract Ladder', 3);
    $table->EndRow();
    $table->AddRow('Place', 'Name');

    $keys = array_keys($arena->SoloLadder());
    $place = 0;

    foreach($keys as $value){
        $place++;
        $person = $roster->GetPerson($value);
        $table->AddRow($place, '<a href="' . internal_link('atn_general', array('id'=>$value)) . '">'.$person->GetName().'</a>');
    }

    $table->EndTable();

    arena_footer();
}
?>