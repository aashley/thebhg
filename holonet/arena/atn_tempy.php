<?php

function title() {

    return 'AMS Tracking Network :: Tempestuous Group :: Members';
}

function output() {
    global $arena;

    arena_header();
    
    $tempy = new Tempy();
    
    $members = $tempy->GetMembers();

    $table = new Table('', true);

    $table->StartRow();
    $table->AddHeader('Moderators', 2);
    $table->EndRow();
    
    $table->StartRow();
    $table->AddHeader('Hunter Name');
    $table->AddHeader('Status');
    $table->EndRow();

    foreach ($members[1] as $hunter) {
        $table->StartRow();
        $table->AddCell('<a href="' . internal_link('atn_general', array('id'=>$hunter->GetID())) . '">' . html_escape($hunter->GetName()) . '</a>');
        $table->AddCell($tempy->ModStatus($hunter->GetID()));
        $table->EndRow();
    }

    $table->EndTable();
    
    hr();
    
    $table = new Table('', true);

    $table->StartRow();
    $table->AddHeader('Members');
    $table->EndRow();

    foreach ($members[0] as $hunter) {
        $table->StartRow();
        $table->AddCell('<a href="' . internal_link('atn_general', array('id'=>$hunter->GetID())) . '">' . html_escape($hunter->GetName()) . '</a>');
        $table->EndRow();
    }

    $table->EndTable();

    arena_footer();
}
?>