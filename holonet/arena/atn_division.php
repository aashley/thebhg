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
	        foreach ($div->GetMembers() as $hunter) {
	            $posi = $hunter->GetPosition();
	            $rank = $hunter->GetRank();
	
	            $table->StartRow();
	            $table->AddCell($posi->GetName());
	            $table->AddCell($rank->GetName());
	            $table->AddCell('<a href="' . internal_link('atn_general', array('id'=>$hunter->GetID())) . '">' . html_escape($hunter->GetName()) . '</a>');
	            $table->EndRow();
	        }
	    }
	
	    $table->EndTable();
	    
    }

    arena_footer();
}
?>