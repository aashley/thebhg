<?php
$atn = $arena->SurvivalGrade($_REQUEST['id']);

function title() {
    global $atn;

    return 'AMS Tracking Network :: Survival Mission :: Mission Grade :: ' . $atn->GetName();
}

function output() {
    global $atn, $arena;

    arena_header();

    echo '<a name="stats"></a>';
    $table = new Table('', true);
    $table->StartRow();
    $table->AddHeader('Survival Mission Grade', 2);
    $table->EndRow();
    $table->AddRow('Name:', $atn->GetName());
    $table->AddRow('Description:', $atn->GetDesc());
    $table->AddRow('Times Received', $atn->GetUsed());
    $table->EndTable();

    arena_footer();
}
?>