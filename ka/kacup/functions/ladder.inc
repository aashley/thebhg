<?php

function output(){
	global $ka;
	
	$ladder = new Ladder($_REQUEST['season']);
	
	if ($_REQUEST['season']){
		$use = $_REQUEST['season'];
	} else {
		$use = $ladder->CurrentSeason();
	}
	
	$kac = $ka->KACbySeason($use);
	
	$ladder->GenerateLadder($kac->GetSeasonID(), roman($kac->GetID()));
	
	add_menu(array('KAC '.roman($kac->GetID())=>'kac/stats.php?flag=kac&season='.$_REQUEST['season']));
	
	
	
}

?>