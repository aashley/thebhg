<?php

function title() {
    return 'DNA';
}

function output() {
    global $arena, $hunter, $roster, $auth_data, $sheet, $citadel, $page;

    arena_header();
	
    $character = new Character($_REQUEST['who']);
    print_r($character);    
	$character->DNA();

    arena_footer();

}
?>
