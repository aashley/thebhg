<?php

function title() {
    global $hunter;

    return 'AMS Tracking Network :: Survival Mission :: Mission Ladder';
}

function output() {
    global $arena, $roster;

    arena_header();

    $table = new Table('', true);
    $table->StartRow();
    $table->AddHeader('Survival Mission Ladder', 3);
    $table->EndRow();
    $table->AddRow('Place', 'Name');

    $keys = array_keys($arena->SurvivalLadder());
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