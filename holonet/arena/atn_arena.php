<?php

function title() {
    global $hunter;

    return 'AMS Tracking Network :: Arena :: Matches';
}

function output() {
    global $arena;

    arena_header();

    echo '<a name="stats"></a>';
    $table = new Table('', true);
    $table->StartRow();
    $table->AddHeader('Arena Matches', 3);
    $table->EndRow();
    $table->AddRow('Match ID', 'Name', 'Links');

    foreach($arena->ArenaMatches() as $value){
        $table->AddRow('Match '.$value->GetMatchID(), $value->GetName(), '<a href="' . internal_link('atn_arena_match', array('id'=>$value->GetID())) . '">ATN Stats</a> | '.$value->ArenaLink());
    }

    $table->EndTable();

    arena_footer();
}
?>