<?php
if (isset($_REQUEST['id'])){
	$div = $roster->GetDivision($_REQUEST['id']);
}

function title() {
    global $div;

    $return = 'AMS Tracking Network';
    
    if (is_object($div)){
	    $return .= ' :: Division :: '.$div->GetName();
    }
    
    return $return;
}

function output() {
    global $div, $arena;

    arena_header();

    if (is_object($div)){
    
	    $table = new Table('', true);
	
	    $table->StartRow();
	    $table->AddHeader('Position');
	    $table->AddHeader('Rank');
	    $table->AddHeader('Name');
	    $table->EndRow();
	
	    if ($div->GetMemberCount()) {
	        echo $div->GetMemberCount();
	        print_r($div->GetMembers());
	    }
	
	    $table->EndTable();
	    
    }

    arena_footer();
}
?>