<?php

function output(){
	global $ka;
	
	$ladder = new Ladder();

	$ladder->GenerateLadder($_REQUEST['season']);
	
}

?>