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
	global $arena, $auth_data, $page;
	
	arena_header();
	
	if ($_REQUEST['submit']){
		if ($arena->NewRow($_REQUEST['data'])){
			echo 'Addition performed.';
		} else {
			echo 'Error encountered.';
		}
		hr();
	} else {
		//Write the current activities
		$current = $arena->Search(array('table'=>'ams_activities', 'search'=>array('date_deleted'=>'0'), 'order'=>array('name'=>'ASC')));
		
		if (count($current)){
			$table = new Table('Current Activities', true);
			
			$table->StartRow();
			$table->AddHeader('Activty');
			$table->AddHeader('Description');
			$table->AddHeader('Type');
			$table->AddHeader('&nbsp;');
			$table->EndRow();
			
			foreach ($current as $obj){
				$type = new Obj('ams_types', $obj->Get(type), 'holonet');
				$table->AddRow($obj->Get(name), $obj->Get(desc, true), $type->Get(name), ($obj->Get(date_deleted) ? 'Deleted' : ''));
			}
			
			$table->EndTable();
			
			hr();
		}
	}
	
	//'Add New' Block
	$form = new Form($page);
	$form->AddSectionTitle('Add New');
	$form->AddHidden('data[table]', 'ams_activities');
	$form->AddTextBox('Name', 'data[name]');
	$form->AddTextArea('Description', 'data[desc]');
	
	$search = $arena->Search(array('table'=>'ams_types', 'search'=>array('date_deleted'=>'0'), 'order'=>array('name'=>'ASC')));
	
	$form->StartSelect('Activity Type', 'data[type]');
	foreach ($search as $obj){
		$form->AddOption($obj->Get(id), $obj->Get(name));
	}
	$form->EndSelect();
	
	$form->AddSubmitButton('submit', 'Process');
	$form->EndForm();
	
	admin_footer($auth_data);
}
?>