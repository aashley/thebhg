<?php

function title(){
	return 'Administration :: Coder Access :: Event Restrictions';
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
	$sql = 'ams_restrict';
	
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
				$type = $obj->Get('list');
				$posi = $obj->Get(position);
				$rank = $obj->Get(rank);
				$divi = $obj->Get(division);
				$cour = $obj->Get(course);
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
			$table->AddHeader('Course');
			$table->AddHeader('List');
			$table->AddHeader('Position');
			$table->AddHeader('Rank');
			$table->AddHeader('Division');
			$table->AddHeader('&nbsp;');
			$table->AddHeader('&nbsp;');
			$table->EndRow();
			
			foreach ($current as $obj){
				$shows = ($_REQUEST['show'] == $obj->Get(activity));
				if ($last_type != $obj->Get(activity)){
					$type = new Obj('ams_activities', $obj->Get(activity), 'holonet');
					$table->StartRow();
					$table->AddHeader('Activity: '.$type->Get(name).($shows ? ' (<a href="'.internal_link($page).'">Hide</a>)' 
					: ' (<a href="'.internal_link($page, array('show'=>$type->Get(id))).'">Show</a>)'), 7);
					$table->EndRow();
				}
				if ($shows){
					$type = new Obj('ams_list_types', $obj->Get('list'), 'holonet');
					$posi = new Position($obj->Get(position));
					$rank = new Rank($obj->Get(rank));
					$divi = new Division($obj->Get(division));
					$cour = new Citadel_Exam($obj->Get(course));
					$table->AddRow($cour->GetAbbrev(), $type->Get(name), $posi->GetName(), $rank->GetName(), $divi->GetName(), 
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
		
		$form->StartSelect('Activity', 'data[values][]', $activity);
		$form->AddOption(0, 'None');
		foreach ($search as $obj){
			$form->AddOption($obj->Get(id), $obj->Get(name));
		}
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'activity');
		
		$citadel = new Citadel();
		
		$form->StartSelect('Course', 'data[values][]', $cour);
		$form->AddOption(0, 'None');
		foreach ($citadel->GetExams() as $obj){
			$form->AddOption($obj->GetId(), $obj->GetName());
		}
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'course');
		
		$search = $arena->Search(array('table'=>'ams_list_types', 'search'=>array('date_deleted'=>'0'), 'order'=>array('name'=>'ASC')));
		
		$form->StartSelect('Member Lists', 'data[values][]', $type);
		$form->AddOption(0, 'None');
		foreach ($search as $obj){
			$form->AddOption($obj->Get(id), $obj->Get(name));
		}
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'list');
		
		$form->StartSelect('Position', 'data[values][]', $posi);
		$form->AddOption(0, 'None');
		foreach ($roster->GetPositions() as $obj){
			$form->AddOption($obj->GetId(), $obj->GetName());
		}
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'position');
		
		$form->StartSelect('Rank', 'data[values][]', $rank);
		$form->AddOption(0, 'None');
		foreach ($roster->GetRanks() as $obj){
			$form->AddOption($obj->GetId(), $obj->GetName());
		}
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'rank');
		
		$form->StartSelect('Division', 'data[values][]', $divi);
		$form->AddOption(0, 'None');
		foreach ($roster->GetDivisions() as $obj){
			$form->AddOption($obj->GetId(), $obj->GetName());
		}
		$form->EndSelect();
		$form->AddHidden('data[fields][]', 'division');
		
		$form->AddSubmitButton('submit', 'Process');
		$form->EndForm();
	}
	
	admin_footer($auth_data);
}
?>