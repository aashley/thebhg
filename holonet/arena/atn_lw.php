<?php

function title() {
    global $hunter;

    return 'AMS Tracking Network :: Lone Wolf Mission :: Contracts';
}

function output() {
    global $arena;

    arena_header();

    echo '<a name="stats"></a>';
    $table = new Table('', true);
    $table->StartRow();
    $table->AddHeader('Lone Wolf Mission Contracts', 3);
    $table->EndRow();
    $table->AddRow('Contract ID', 'Issued To', 'Links');

    foreach($arena->LWContracts() as $value){
        $hunter = $value->GetHunter();
        $table->AddRow('Contract '.$value->GetContractID(), 
        '<a href="' . internal_link('atn_general', array('id'=>$hunter->GetID())). '">' . $hunter->GetName() . '</a>', 
        '<a href="' . internal_link('atn_lw_contract', array('id'=>$value->GetID())) . '">ATN Stats</a> | '.$value->ArenaLink());
    }

    $table->EndTable();

    arena_footer();
}
?>