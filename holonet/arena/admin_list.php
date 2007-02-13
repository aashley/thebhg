<?php

if ($_REQUEST['id']){
	$list = new Obj('ams_list_types', $_REQUEST['id'], 'holonet');
	if ($list->Get('date_deleted')){
		$list = 0;
	}
}

function title(){
	global $list;
	return 'Administration :: List Management'.(is_object($list) ? ($list->Get('name') ? ' :: '.$list->Get('name') : '') : '');
}

function auth($person) {
	global $auth_data, $hunter, $roster;

	$auth_data = get_auth_data($person);
	$hunter = $roster->GetPerson($person->GetID());
	return $auth_data['list'];
}

function output(){
	global $arena, $auth_data, $page, $roster, $list, $lists;
	arena_header();
	
	$show = true;
	$sql = 'ams_lists';
	
	if ((is_object($list) ? (in_array($list->Get('id'), $auth_data['lists'])) : 0)){
		if ($_REQUEST['op']){
			$obj = new Obj($sql, $_REQUEST['go'], 'holonet');
			switch ($_REQUEST['op']){			
				case 'de':
				$obj->Edit(array('date_deleted'=>time()));
				$show = false;
				break;
			}
			
			if (!$show){
				echo '<p><a href="'.internal_link($page, array('id'=>$_REQUEST['id'])).'">View All</a>';
				hr();
			}
		} elseif ($_REQUEST['submit']){
			$_REQUEST['data']['values'][] = $_REQUEST['bhg_id'];
			if ($arena->NewRow($_REQUEST['data'])){
				echo 'Addition performed.';
			} else {
				echo 'Error encountered.';
			}
			
			echo '<p><a href="'.internal_link($page, array('id'=>$_REQUEST['id'])).'">View All</a>';
			hr();
		} else {
			//Write the current activities
			$current = $arena->Search(array('table'=>$sql, 'search'=>array('list'=>$_REQUEST['id'], 'date_deleted'=>'0')));
			
			if (count($current)){
				$table = new Table('', true);
				
				$table->StartRow();
				$table->AddHeader('Hunter');
				$table->AddHeader('&nbsp;');
				$table->EndRow();
				
				foreach ($current as $obj){
					$hunter = new Person($obj->Get('bhg_id'));
					$table->AddRow($hunter->GetName(), '<a href="'.internal_link($page, array('op'=>'de', 'go'=>$obj->Get('id'), 'id'=>$_REQUEST['id'])).'">Remove</a>');
					$last_type = $obj->Get('type');
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
			$form->AddHidden('id', $_REQUEST['id']);
			
			include_once 'search.php';
			
			$form->AddHidden('data[values][]', $_REQUEST['id']);
			$form->AddHidden('data[fields][]', 'list');
			
			$form->AddHidden('data[fields][]', 'bhg_id');
			
			$form->AddSubmitButton('submit', 'Process');
			$form->EndForm();
		}
	} else {
		echo 'You are not cleared to modify this list.';
	}
	
	admin_footer($auth_data);
}
?>
