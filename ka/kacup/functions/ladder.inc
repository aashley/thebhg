<?php

function output(){
	global $ka;
	
	$ladder = new Ladder();

	$kac = $ka->KACbySeason($_REQUEST['season']);
	
	add_menu(array('KAC '.roman($kac->GetID())=>'kac/stats.php?flag=kac&season='.$_REQUEST['season']));
	
	$ladder->GenerateLadder($_REQUEST['season']);
	
}

?>