<?

$include = array('arena_core', 'tournament', 'character', 'field', 'npc_utilities', 'object', 'parse_npc', 'sheet_module', 'skill', 'statribute');

foreach ($include as $page){
	$page = $page.'.php';
	if (file_exists($page)){
		include_once $page;
	}
}

?>