<?php

$include = array('arena_core', 'tournament', 'sheet_module', 'character', 'field', 'npc_utilities', 'object', 'parse_npc', 'skill', 'statribute');

foreach ($include as $pages){
	$pages = $pages.'.php';
	//echo $pages;
	if (file_exists('arena/objects/'.$pages)){
		//echo ' got in.';
		include_once $pages;
	}
	//echo '<br />';
}

?>