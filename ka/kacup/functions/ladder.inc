<?php

function output(){
	global $ka;
	
	$ladder = new Ladder();

	add_menu(array('KAC '.roman($_REQUEST['season'])=>'kac/stats.php?flag=kac&season='.$_REQUEST['season']));
	
	$ladder->GenerateLadder($_REQUEST['season']);
	
}

?>