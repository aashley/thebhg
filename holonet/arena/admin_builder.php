<?php

function title(){
	return 'Administration :: Coder Access :: Event Specifics';
}

function auth($person) {
	global $auth_data, $hunter, $roster;

	$auth_data = get_auth_data($person);
	$hunter = $roster->GetPerson($person->GetID());
	return $auth_data['coder'];
}

function output(){
	global $arena, $auth_data, $page;
	
	arena_header();
	
	$show = true;
	$sql = 'ams_event_builds';
	
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
				$id = $obj->Get(id);
				$activity = $obj->Get(activity);
				$type = $obj->Get(resource);
				$grade = $obj->Get(grade);
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
		$current = $arena->Search(array('table'=>$sql, 'order'=>array('activity'=>'ASC')));
		
		if (count($current)){
			$table = new Table('', true);
			
			$table->StartRow();
			$table->AddHeader('Resource');
			$table->AddHeader('For Grading');
			$table->AddHeader('&nbsp;');
			$table->AddHeader('&nbsp;');
			$table->EndRow();
			
			foreach ($current as $obj){
				$shows = ($_REQUEST['show'] == $obj->Get(activity));
				if ($last_type != $obj->Get(activity)){
					$type = new Obj('ams_activities', $obj->Get(activity), 'holonet');
					$table->StartRow();
					$table->AddHeader('Activity: '.$type->Get(name).($shows ? ' (<a href="'.internal_link($page).'">Hide</a>)' 
					: ' (<a href="'.internal_link($page, array('show'=>$type->Get(id))).'">Show</a>)'), 6);
					$table->EndRow();
				}
				if ($shows){
					$type = new Obj('ams_specifics_types', $obj->Get(resource), 'holonet');
					$table->AddRow($type->Get(name), ($obj->Get(grade) ? 'Yes' : 'No'), 
					($obj->Get(date_deleted) ? '<a href="'.internal_link($page, array('op'=>'ud', 'id'=>$obj->Get(id))).'">Undelete</a>' : 
					'<a href="'.internal_link($page, array('op'=>'de', 'id'=>$obj->Get(id))).'">Delete</a>'), 
					'<a href="'.internal_link($page, array('op'=>'ed', 'id'=>$obj->Get(id))).'">Edit</a>');
				}
				$last_type = $obj->Get(activity);
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
		
		$search = $arena->Search(array('table'=>'ams_activities', 'search'=>array('date_deleted'=>'0'), 'order'=>array('name'=>'ASC')));
		
		$form->StartSelect('Resource', 'data[values][]', $activity);
		foreach ($search as $obj){
			$form->AddOption($obj->Get(id), $obj->Get(name));
		}
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'activity');
		
		$search = $arena->Search(array('table'=>'ams_specifics_types', 'search'=>array('date_deleted'=>'0'), 'order'=>array('name'=>'ASC')));
		
		$form->StartSelect('Resource', 'data[values][]', $type);
		foreach ($search as $obj){
			$form->AddOption($obj->Get(id), $obj->Get(name));
		}
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'resource');
		
		$form->StartSelect('Use as Grade', 'data[values][]', $type);
		$form->AddOption(0, 'No');
		$form->AddOption(1, 'Yes');
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'grade');
		
		$form->AddSubmitButton('submit', 'Process');
		$form->EndForm();
	}
	
	admin_footer($auth_data);
}
?>