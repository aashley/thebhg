<?php

function title() {
    global $hunter;

    return 'AMS Tracking Network :: Starfield Arena :: Matches';
}

function output() {
    global $arena;

    arena_header();

    echo '<a name="stats"></a>';
    $table = new Table();
    $table->StartRow();
    $table->AddHeader('Starfield Arena Matches', 3);
    $table->EndRow();
    $table->AddRow('Match ID', 'Name', 'Links');

    foreach($arena->StarfieldMatches() as $value){
        $table->AddRow('Match '.$value->GetMatchID(), $value->GetName(), '<a href="' . internal_link('atn_starfield_match', array('id'=>$value->GetID())) . '">ATN Stats</a> | '.$value->ArenaLink());
    }

    $table->EndTable();

    arena_footer();
}
?>