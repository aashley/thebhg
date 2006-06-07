<?php

include_once('roster.inc');
include_once('citadel.inc');
include_once('library.inc');
$include = array('arena_core', 'tournament', 'sheet_module', 'character', 'field', 'npc_utilities', 'object', 'parse_npc', 'skill', 'statribute', 'creature', 'auxillary');

foreach ($include as $pages){
	$pages = $pages.'.php';
	if (file_exists('objects/'.$pages)){
		include_once 'objects/'.$pages;
	}
}

$character = new Character($_REQUEST['who']); 
$character->DNA();

?>
