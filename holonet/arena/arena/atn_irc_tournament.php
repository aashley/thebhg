<?php

function title() {
    global $hunter;

    return 'AMS Tracking Network :: IRC Arena Tournament';
}

function output() {
    global $arena;

    arena_header();
    
    $at = new IRCTournament();
    
    $season = 0;
    
    if (isset($_REQUEST['id'])){
	    $season = $_REQUEST['id'];
    }
    
    $at->GenerateTournament($season);

    arena_footer();
}
?>