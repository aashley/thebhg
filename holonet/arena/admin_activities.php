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
	global $arena, $auth_data;
	
	arena_header();
	
	//Write the current activities
	$current = $arena->Search(array('table'=>'ams_activities', 'search'=>array('date_deleted'=>'0')), 'order'=>array('name'));
	
	if (count($current)){
		$table = new Table('Current Activities', true);
		
		$table->StartRow();
		$table->AddHeader('Activty');
		$table->AddHeader('Description');
		$table->AddHeader('&nbsp;');
		$table->EndRow();
		
		foreach ($current as $obj){
			$table->AddRow($obj->Get(name), $obj->Get(desc, true), ($obj->Get(date_deleted) ? 'Deleted' : ''));
		}
		
		$table->EndTable();
		
		hr();
	}
	
	admin_footer($auth_data);
}
?>