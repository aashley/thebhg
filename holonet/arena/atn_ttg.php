<?php

function title() {

    return 'AMS Tracking Network :: Twilight Gauntlet :: Members';
}

function output() {
    global $arena;

    arena_header();
    
    $ttg = new TTG();

    $table = new Table('', true);

    $table->StartRow();
    $table->AddHeader('Hunter Name');
    $table->EndRow();

    foreach ($ttg->GetMembers() as $hunter) {
        $table->StartRow();
        $table->AddCell('<a href="' . internal_link('atn_general', array('id'=>$hunter->GetID())) . '">' . html_escape($hunter->GetName()) . '</a>');
        $table->EndRow();
    }

    $table->EndTable();

    arena_footer();
}
?>