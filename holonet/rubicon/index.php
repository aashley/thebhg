<?php
function title() {
    return 'Index';
}

function auth($person) {
	
	$GLOBALS['login'] = $person;
	
    return true;
}

function output() {

	echo 'hello world';
   
}
?>
