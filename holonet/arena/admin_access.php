<?php

function title(){
	return 'Administration :: Coder Access :: Module Access';
}

function auth($person) {
	global $auth_data, $hunter, $roster;

	$auth_data = get_auth_data($person);
	$hunter = $roster->GetPerson($person->GetID());
	return $auth_data['coder'];
}

function output(){
	global $arena, $auth_data, $page, $roster;
	
	arena_header();
	
	$show = true;
	$sql = 'ams_access';
	
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
				$type = $obj->Get(activity);
				$aide = $obj->Get(aide);
				$list = $obj->Get('list');
			}
			break;
		}
		
		if (!$show){
			echo '<p><a href="'.internal_link($page).'">View All</a>';
			hr();
		}
	} elseif ($_REQUEST['csop']){
		$obj = new Obj('ams_cs', $_REQUEST['ida'], 'holonet');
		switch ($_REQUEST['csop']){
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
				$ida = $obj->Get(id);
				$aidea = $obj->Get(aide);
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
	} elseif ($_REQUEST['cs']){
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
			$table->AddHeader('Position');
			$table->AddHeader('Event');
			$table->AddHeader('List');
			$table->AddHeader('&nbsp;');
			$table->AddHeader('&nbsp;');
			$table->EndRow();
			
			foreach ($current as $obj){
				$type = new Obj('ams_activities', $obj->Get(activity), 'holonet');
				$list = new Obj('ams_list_types', $obj->Get('list'), 'holonet');
				if ($obj->Get(aide) < 0){
					$aide = $obj->Get(aide)*-1;
					$posi = new Position($aide);
					$position = $posi->GetName();
				} else {
					$posi = new Obj('ams_aide_types', $obj->Get(aide), 'holonet');
					$position = $posi->Get(name);
				}
				$table->AddRow($position, $type->Get(name), $list->Get(name), ($obj->Get(date_deleted) ? '<a href="'.internal_link($page, array('op'=>'ud', 'id'=>$obj->Get(id))).'">Undelete</a>' : 
				'<a href="'.internal_link($page, array('op'=>'de', 'id'=>$obj->Get(id))).'">Delete</a>'), 
				'<a href="'.internal_link($page, array('op'=>'ed', 'id'=>$obj->Get(id))).'">Edit</a>');
				$last_type = $obj->Get(type);
			}
			
			$table->EndTable();
			
			hr();
			
			$table = new Table('Character Sheet Access', true);
			
			$table->StartRow();
			$table->AddHeader('Position');
			$table->AddHeader('&nbsp;');
			$table->AddHeader('&nbsp;');
			$table->EndRow();
			
			$current = $arena->Search(array('table'=>'ams_cs', 'order'=>array('aide'=>'ASC')));
			
			foreach ($current as $obj){
				$posi = new Obj('ams_aide_types', $obj->Get(aide), 'holonet');
				$position = $posi->Get(name);
				$table->AddRow($position, ($obj->Get(date_deleted) ? '<a href="'.internal_link($page, array('csop'=>'ud', 'ida'=>$obj->Get(id))).'">Undelete</a>' : 
				'<a href="'.internal_link($page, array('csop'=>'de', 'ida'=>$obj->Get(id))).'">Delete</a>'), 
				'<a href="'.internal_link($page, array('csop'=>'ed', 'ida'=>$obj->Get(id))).'">Edit</a>');
				$last_type = $obj->Get(type);
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
		
		$search = $arena->Search(array('table'=>'ams_aide_types', 'search'=>array('date_deleted'=>'0'), 'order'=>array('name'=>'ASC')));
		
		$form->StartSelect('Aide', 'data[values][]', $aide);
		echo '<optgroup label="Arena Aides">';
		foreach ($search as $obj){
			$form->AddOption($obj->Get(id), $obj->Get(name));
		}
		echo '</optgroup>';
		echo '<optgroup label="BHG Positions">';
		foreach ($roster->GetPositions() as $obj){
			$form->AddOption('-'.$obj->GetID(), $obj->GetName());
		}
		echo '</optgroup>';
		$search = $arena->Search(array('table'=>'ams_activities', 'search'=>array('date_deleted'=>'0'), 'order'=>array('name'=>'ASC')));
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'aide');
		
		$form->StartSelect('Event', 'data[values][]', $type);
		$form->AddOption(0, 'None');
		foreach ($search as $obj){
			$form->AddOption($obj->Get(id), $obj->Get(name));
		}
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'activity');
		
		$search = $arena->Search(array('table'=>'ams_list_types', 'search'=>array('date_deleted'=>'0'), 'order'=>array('name'=>'ASC')));
		$form->StartSelect('Member Lists', 'data[values][]', $list);
		$form->AddOption(0, 'None');
		foreach ($search as $obj){
			$form->AddOption($obj->Get(id), $obj->Get(name));
		}
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'list');
		
		$form->AddSubmitButton('submit', 'Process');
		$form->EndForm();
		
		hr();
		
		$search = $arena->Search(array('table'=>'ams_aide_types', 'search'=>array('date_deleted'=>'0'), 'order'=>array('name'=>'ASC')));
		
		$form = new Form($page);
		($_REQUEST['csop'] ? $form->AddHidden('csop', 'ed') : '');
		$form->AddHidden('ida', $ida);
		$form->AddHidden('stage', '2');
		$form->AddHidden('data[table]', 'ams_cs');
		$form->AddSectionTitle('Character Sheet Access');
		$form->StartSelect('Aide', 'data[values][]', $aidea);
		foreach ($search as $obj){
			$form->AddOption($obj->Get(id), $obj->Get(name));
		}
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'aide');
		
		$form->AddSubmitButton('cs', 'Submit');
		$form->EndForm();
	}
	
	admin_footer($auth_data);
}
?>