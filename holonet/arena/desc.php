<?php

function title() {
    return 'Character Sheet :: Statribute Description';
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet;

    arena_header();
    
    if (isset($_REQUEST['id'])){
    
	    $stat = new Statribute($_REQUEST['id']);
	    
	    echo '<h5>'.$stat->GetName().'</h5>'.$stat->GetDesc();
	    
    }
    
    arena_footer(false);
}
?>