<?php

function title() {
    global $hunter;

    return 'AMS Tracking Network :: Arena Tournament';
}

function output() {
    global $arena;

    arena_header();
    
    $at = new Tournament();
    
    $season = 0;
    
    if (isset($_REQUEST['id'])){
	    $season = $_REQUEST['id'];
    }
    
    $at->GenerateTournament($season);

    arena_footer();
}
?>