<?php
if (isset($_REQUEST['id'])){
	$hunter = new Person($_REQUEST['id']);
}

function title() {
    global $hunter;

    $return = 'AMS Tracking Network';
    
    if (is_object($hunter)){
	    $return .= ' :: Experience History :: ' . $hunter->GetName();
    }
    
    return $return;
}

function output() {
    global $arena, $hunter, $sheet, $roster;

    arena_header();
    
    if (is_object($hunter)){
    
	    $character = new Character($hunter->GetID());
	    
	    echo '<a href="'.internal_link('atn_general', array('id'=>$hunter->GetID())).'">Back to '.$hunter->GetName().'\'s General Tracking</a>';
	    
	    $character->WriteXPEvents();
	    
	    hr();
	    
	    $character->WritePointEvents();
	    
    }
    
    arena_footer();
}
?>