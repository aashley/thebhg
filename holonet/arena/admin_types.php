<?php

function title(){
	return 'Administration :: Overseer Utilities :: System Types';
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
	
	$show = true;
	$sql = 'ams_types';
	
	if ($_REQUEST['op']){
		$obj = new Obj($sql, $_REQUEST['id'], 'holonet');
		switch ($_REQUEST['op']){
			case 'ud':
			$obj->Edit(array('date_deleted'=>0));
			$show = false;
			break;
			
			case 'de':
			$obj->Edit(array('date_deleted'=>time()));
			$show = false;
			break;
			
			case 'ed':
			if ($_REQUEST['stage'] == 2){
				$return = array();
				foreach ($_REQUEST['data'][fields] as $i=>$field){
					$return[$field] = $_REQUEST['data']['values'][$i];
				}
				//When PHP 5:
				//$return = array_combine($_REQUEST['data'][fields], $_REQUEST['data'][values]);
				$obj->Edit($return);
				$show = false;
			} else {
				$name = $obj->Get(name);
				$id = $obj->Get(id);
			}
			break;
		}
		
		if (!$show){
			echo '<p><a href="'.internal_link($page).'">View All</a>';
			hr();
		}
	} elseif ($_REQUEST['submit']){
		if ($arena->NewRow($_REQUEST['data'])){
			echo 'Addition performed.';
		} else {
			echo 'Error encountered.';
		}
		
		echo '<p><a href="'.internal_link($page).'">View All</a>';
		hr();
	} else {
		//Write the current activities
		$current = $arena->Search(array('table'=>$sql, 'order'=>array('name'=>'ASC')));
		
		if (count($current)){
			$table = new Table('Current Activities', true);
			
			$table->StartRow();
			$table->AddHeader('Type');
			$table->AddHeader('&nbsp;');
			$table->AddHeader('&nbsp;');
			$table->EndRow();
			
			foreach ($current as $obj){
				$table->AddRow($obj->Get(name), ($obj->Get(date_deleted) ? '<a href="'.internal_link($page, array('op'=>'ud', 'id'=>$obj->Get(id))).'">Undelete</a>' : 
				'<a href="'.internal_link($page, array('op'=>'de', 'id'=>$obj->Get(id))).'">Delete</a>'), 
				'<a href="'.internal_link($page, array('op'=>'ed', 'id'=>$obj->Get(id))).'">Edit</a>');
			}
			
			$table->EndTable();
			
			hr();
		}
	}
	
	if ($show){
		//'Add New' Block
		$form = new Form($page);
		$form->AddSectionTitle(($_REQUEST['op'] ? 'Edit' : 'Add New'));
		($_REQUEST['op'] ? $form->AddHidden('op', 'ed') : '');
		$form->AddHidden('id', $id);
		$form->AddHidden('data[table]', $sql);
		$form->AddHidden('stage', '2');
		$form->AddTextBox('Name', 'data[values][]', $name);
		$form->AddHidden('data[fields][]', 'name');
		
		$form->AddSubmitButton('submit', 'Process');
		$form->EndForm();
	}
	
	admin_footer($auth_data);
}
?>