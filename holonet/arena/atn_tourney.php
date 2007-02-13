<?php
if (isset($_REQUEST['act'])){
	$activity = new Obj('ams_activities', $_REQUEST['act'], 'holonet');

	if (!$activity->Get('name')){
		$activity = false;
	} else {
		$type = new Obj('ams_types', $activity->Get('type'), 'holonet');
	}
}

function title() {
    global $hunter, $activity;

    $return = 'AMS Tracking Network :: '.(is_object($activity) ? $activity->Get('name').' ' : '').'Tournament';
    
    return $return;
}

function output() {
    global $arena, $hunter, $sheet, $roster, $activity;

    arena_header();

    if (is_object($activity)){
	    $at = new Tournament($activity->Get('id'), $_REQUEST['season']);
	    
	    $at->GenerateTournament($_REQUEST['season']);
    }
    
    arena_footer();
}
?>
