<?php

function title() {
    global $hunter;

    return 'AMS Tracking Network :: Arena :: Ladder';
}

function output() {
    global $arena, $roster;

    arena_header();

    echo '<a name="stats"></a>';
    $table = new Table('', true);
    $table->StartRow();
    $table->AddHeader('Arena Ladder', 3);
    $table->EndRow();
    $table->AddRow('Place', 'Name');
    
    $keys = array_keys($arena->ArenaLadder());
    $place = 0;
    
    foreach($keys as $value){
        $place++;
        $person = $roster->GetPerson($value);
        $table->AddRow($place, '<a href="' . internal_link('atn_general', array('id'=>$person->GetID())) . '">'.$person->GetName().'</a>');
    }

    $table->EndTable();

    arena_footer();
}
?>