<?php

function title(){
	return 'Administration :: Coder Access :: Rules and Grades';
}

function auth($person) {
	global $auth_data, $hunter, $roster;

	$auth_data = get_auth_data($person);
	$hunter = $roster->GetPerson($person->GetID());
	return $auth_data['coder'];
}

function output(){
	global $arena, $auth_data, $page, $mb;
	
	arena_header();
	
	$show = true;
	$sql = 'ams_specifics';
	
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
				$name = $obj->Get('name');
				$id = $obj->Get('id');
				$desc = $obj->Get('description');
				$type = $obj->Get('type');
				$rules = $obj->Get('rules');
				$points = $obj->Get('points');
				$medal = $obj->Get('medal');
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
		$current = $arena->Search(array('table'=>$sql, 'order'=>array('type'=>'ASC')));
		
		if (count($current)){
			$table = new Table('', true);
			
			$table->StartRow();
			$table->AddHeader('Name');
			$table->AddHeader('Description');
			$table->AddHeader('Rules');
			$table->AddHeader('Points');
			$table->AddHeader('&nbsp;');
			$table->AddHeader('&nbsp;');
			$table->EndRow();
			
			foreach ($current as $obj){
				$shows = ($_REQUEST['show'] == $obj->Get('type'));
				if ($last_type != $obj->Get('type')){
					$type = new Obj('ams_specifics_types', $obj->Get('type'), 'holonet');
					$table->StartRow();
					$table->AddHeader('Type: '.$type->Get('name').($shows ? ' (<a href="'.internal_link($page).'">Hide</a>)' 
					: ' (<a href="'.internal_link($page, array('show'=>$type->Get('id'))).'">Show</a>)'), 6);
					$table->EndRow();
				}
				if ($shows){
					$table->AddRow($obj->Get('name'), $obj->Get('description', 1), $obj->Get('rules', 1), $obj->Get('points', 0, 0, 1), ($obj->Get('date_deleted') ? '<a href="'.internal_link($page, array('op'=>'ud', 'id'=>$obj->Get('id'))).'">Undelete</a>' : 
					'<a href="'.internal_link($page, array('op'=>'de', 'id'=>$obj->Get('id'))).'">Delete</a>'), 
					'<a href="'.internal_link($page, array('op'=>'ed', 'id'=>$obj->Get('id'))).'">Edit</a>');
				}
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
		$form->AddHidden('stage', '2');
		$form->AddTextBox('Name', 'data[values][]', $name);
		$form->AddHidden('data[fields][]', 'name');
		
		$form->AddTextBox('Points', 'data[values][]', $points);
		$form->AddHidden('data[fields][]', 'points');
		
		$form->AddTextArea('Description', 'data[values][]', $desc);
		$form->AddHidden('data[fields][]', 'description');
		
		$form->AddTextArea('Rules', 'data[values][]', $rules);
		$form->AddHidden('data[fields][]', 'rules');
		
		$form->StartSelect('Use Medal for First', 'data[values][]', $medal);
		$form->AddOption(0, 'No');    
	    $mb_cat = $mb->GetMedalCategories();
		foreach ($mb_cat as $cat) {
			$mb_gp = $cat->GetMedalGroups();
			foreach ($mb_gp as $group) {
				$form->AddOption($group->GetID(), $group->GetName());
			}
		}
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'medal');
		
		$search = $arena->Search(array('table'=>'ams_specifics_types', 'search'=>array('date_deleted'=>'0'), 'order'=>array('name'=>'ASC')));
		
		$form->StartSelect('Type', 'data[values][]', $type);
		foreach ($search as $obj){
			$form->AddOption($obj->Get('id'), $obj->Get('name'));
		}
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'type');
		
		$form->AddSubmitButton('submit', 'Process');
		$form->EndForm();
	}
	
	admin_footer($auth_data);
}
?>