<?php

function title() {
    global $hunter;

    return 'AMS Tracking Network :: Survival Mission :: Missions';
}

function output() {
    global $arena;

    arena_header();

    echo '<a name="stats"></a>';
    $table = new Table('', true);
    $table->StartRow();
    $table->AddHeader('Survival Missions', 3);
    $table->EndRow();
    $table->AddRow('Mission ID', 'Issued To', 'Links');

    foreach($arena->SurvivalContracts() as $value){
        $hunter = $value->GetHunter();
        $table->AddRow('Contract '.$value->GetContractID(), 
        '<a href="' . internal_link('atn_general', array('id'=>$hunter->GetID())). '">' . $hunter->GetName() . '</a>', 
        '<a href="' . internal_link('atn_survival_contract', array('id'=>$value->GetID())) . '">ATN Stats</a> | '.$value->ArenaLink());
    }

    $table->EndTable();

    arena_footer();
}
?>