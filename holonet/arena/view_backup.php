<?php
$character = $sheet->GetBackup($_REQUEST['sheet']);
$saves = $character->GetBackups();

function title() {
	global $saves;
	
	$return = '';
	
	if (is_object($character)){
    	$return .= $character->GetName().'\'s ';
	} 
	
	$return .= 'Character Sheet :: View Backup :: '.$saves[$_REQUEST['sheet']]['name'];
	
	return $return;
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet, $saves, $character;
    
    arena_header();
    
    $character->ParseSheet('backups', $_REQUEST['sheet'], 'id');

	arena_footer();

}
?>