<?php

$include = array('arena_core', 'tournament', 'sheet_module', 'character', 'field', 'npc_utilities', 'object', 'parse_npc', 'skill', 'statribute');

foreach ($include as $page){
	$page = $page.'.php';
	//echo $page;
	if (file_exists('arena/objects/'.$page)){
		//echo ' got in.';
		include_once $page;
	}
	//echo '<br />';
}

?>