<?php
if (isset($_REQUEST['id'])){
	$atn = $arena->ArenaLocation($_REQUEST['id'], $_REQUEST['table']);
}

function title() {
    global $atn;

    $return = 'AMS Tracking Network :: Arena :: Location';
    
    if (is_object($atn)){
	    $return .= ' :: ' . $atn->GetName();
    }
    
    return $return;
}

function output() {
    global $atn, $arena;

    arena_header();

    if (is_object($atn)){
	    $table = new Table('', true);
	    $table->StartRow();
	    $table->AddHeader('Arena Location', 2);
	    $table->EndRow();
	    $table->AddRow('Name: ', $atn->GetName());
	    $table->AddRow('Link: ', $atn->WriteLink());
	    $table->AddRow('Times Used: ', $atn->GetUsed());
	    $table->EndTable();
    }

    arena_footer();
}
?>