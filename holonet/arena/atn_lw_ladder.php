<?php

function title() {
    global $hunter;

    return 'AMS Tracking Network :: Lone Wolf Mission :: Contract Ladder';
}

function output() {
    global $arena, $roster;

    arena_header();

    echo '<a name="stats"></a>';
    $table = new Table('', true);
    $table->StartRow();
    $table->AddHeader('Lone Wolf Contract Ladder', 3);
    $table->EndRow();
    $table->AddRow('Place', 'Name');

    $keys = array_keys($arena->LWLadder());
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