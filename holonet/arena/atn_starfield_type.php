<?php
if (isset($_REQUEST['id'])){
	$atn = $arena->StarfieldType($_REQUEST['id']);
}

function title() {
    global $atn;

    $return = 'AMS Tracking Network :: Starfield Arena';
    
    if (is_object($atn)){
	    $return .= ' :: Match Type :: ' . $atn->GetName();
    }
    
    return $return;
}

function output() {
    global $atn, $arena;

    arena_header();

    if (is_object($atn)){
	    $table = new Table();
	    $table->StartRow();
	    $table->AddHeader('Starfield Arena Match Type', 2);
	    $table->EndRow();
	    $table->AddRow('Name:', $atn->GetName());
	    $table->AddRow('Description:', $atn->GetDesc());
	    $table->AddRow('Times Used', $atn->GetUsed());
	    $table->EndTable();
    }

    arena_footer();
}
?>