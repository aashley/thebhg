<?php
if (isset($_REQUEST['id'])){
	$atn = $arena->SurvivalType($_REQUEST['id']);
}

function title() {
    global $atn;

    $return = 'AMS Tracking Network :: Survival Mission';
    
    if (is_object($atn)){
	    $return .= ' :: Mission Type :: ' . $atn->GetName();
    }
    
    return $return;
}

function output() {
    global $atn, $arena;

    arena_header();

    if (is_object($atn)){
	    $table = new Table('', true);
	    $table->StartRow();
	    $table->AddHeader('Survival Mission Contract Type', 2);
	    $table->EndRow();
	    $table->AddRow('Name:', $atn->GetName());
	    $table->AddRow('Description:', $atn->GetDesc());
	    $table->AddRow('Times Used', $atn->GetUsed());
	    $table->EndTable();
    }

    arena_footer();
}
?>