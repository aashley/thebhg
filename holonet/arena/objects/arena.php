<?

$include = array('arena_core', 'tournament', 'character', 'field', 'npc_utilities', 'object', 'parse_npc', 'sheet_module', 'skill', 'statribute');

foreach ($include as $page){
	$page = $page.'.php';
	echo $page;
	if (file_exists('arena/objects/'.$page)){
		echo ' got in.';
		include_once $page;
	}
	echo '<br />';
}

?>