<?php
$character = new Character($_REQUEST['id']);
$saves = $character->GetBackups();

function title() {
	global $saves;
	
	$return = '';
	
	if (isset($_REQUEST['id'])){
		$person = new Person($_REQUEST['id']);
    	$return .= $person->GetName().'\'s ';
	} 
	
	$return .= 'Character Sheet :: View Backup :: '.$saves[$_REQUEST['sheet']]['name'];
	
	return $return;
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet, $saves, $character;
    
    arena_header();
    
    $character->ParseSheet('backups', $_REQUEST['sheet'], 'id');

	admin_footer($auth_data);

}
?>