<?php

function title(){
	return 'Administration :: Coder Access :: System Types';
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
				$opp = $obj->Get(opponent);
				$req = $obj->Get(request);
				$sub = $obj->Get(submit);
				$npc = $obj->Get(npc);
				$cre = $obj->Get(creature);
				$mul = $obj->Get(multiple);
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
			$table = new Table('', true);
			
			$table->StartRow();
			$table->AddHeader('Type');
			$table->AddHeader('Requires Opponent');
			$table->AddHeader('Hunter Requests');
			$table->AddHeader('Hunter Submits');
			$table->AddHeader('Uses NPCs');
			$table->AddHeader('Uses Creatures');
			$table->AddHeader('Players Added at End');
			$table->AddHeader('&nbsp;');
			$table->AddHeader('&nbsp;');
			$table->EndRow();
			
			foreach ($current as $obj){
				$table->AddRow($obj->Get(name), ($obj->Get(opponent) ? 'Yes' : 'No'), ($obj->Get(request) ? 'Yes' : 'No'), ($obj->Get(submit) ? 'Yes' : 'No'), 
				($obj->Get(npc) ? 'Yes' : 'No'), ($obj->Get(creature) ? 'Yes' : 'No'), ($obj->Get(multiple) ? 'Yes' : 'No'),
				($obj->Get(date_deleted) ? '<a href="'.internal_link($page, array('op'=>'ud', 'id'=>$obj->Get(id))).'">Undelete</a>' : 
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
		
		$form->StartSelect('Requires Opponent', 'data[values][]', $opp);
		$form->AddOption(0, 'No');
		$form->AddOption(1, 'Yes');
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'opponent');
		
		$form->StartSelect('Open to Request', 'data[values][]', $req);
		$form->AddOption(0, 'No');
		$form->AddOption(1, 'Yes');
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'request');
		
		$form->StartSelect('Hunter Submits', 'data[values][]', $sub);
		$form->AddOption(0, 'No');
		$form->AddOption(1, 'Yes');
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'submit');
		
		$form->StartSelect('Uses Creature System', 'data[values][]', $cre);
		$form->AddOption(0, 'No');
		$form->AddOption(1, 'Yes');
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'creature');
		
		$form->StartSelect('Uses Non-Player Character', 'data[values][]', $npc);
		$form->AddOption(0, 'No');
		$form->AddOption(1, 'Yes');
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'npc');
		
		$form->StartSelect('Players Added at End', 'data[values][]', $mul);
		$form->AddOption(0, 'No');
		$form->AddOption(1, 'Yes');
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'multiple');
		
		$form->AddSubmitButton('submit', 'Process');
		$form->EndForm();
	}
	
	admin_footer($auth_data);
}
?>