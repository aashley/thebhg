<?php

function title() {
    global $hunter;

    return 'AMS Tracking Network :: IRC Arena :: Matches';
}

function output() {
    global $arena;

    arena_header();

    echo '<a name="stats"></a>';
    $table = new Table('', true);
    $table->StartRow();
    $table->AddHeader('IRC Arena Matches', 3);
    $table->EndRow();
    $table->AddRow('Match ID', 'Name', 'Links');

    foreach($arena->IRCAMatches() as $value){
        $table->AddRow('Match '.$value->GetMatchID(), $value->GetName(), '<a href="' . internal_link('atn_irca_match', array('id'=>$value->GetID())) . '">ATN Stats</a>');
    }

    $table->EndTable();

    arena_footer();
}
?>