<?php

function title(){
	return 'Administration :: Overseer Utilities :: System Activities';
}

function auth($person) {
	global $auth_data, $hunter, $roster;

	$auth_data = get_auth_data($person);
	$hunter = $roster->GetPerson($person->GetID());
	return $auth_data['overseer'];
}

function output(){
	global $arena;
	//Write the current activities
	$current = $arena->Search(array('table'=>'ams_activities', 'search'=>array('date_deleted'=>'0')));
	
	print_r($current);
}
?>