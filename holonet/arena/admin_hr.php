<?php

function title(){
	return 'Administration :: System Management :: Human Resources';
}

function auth($person) {
	global $auth_data, $hunter, $roster;

	$auth_data = get_auth_data($person);
	$hunter = $roster->GetPerson($person->GetID());
	return $auth_data['rp'];
}

function output(){
	global $arena, $auth_data, $page, $roster;
	arena_header();
	
	$show = true;
	$sql = 'ams_aides';
	
	if ($_REQUEST['op']){
		$obj = new Obj($sql, $_REQUEST['id'], 'holonet');
		switch ($_REQUEST['op']){			
			case 'de':
			$obj->Edit(array('end_date'=>time()));
			$show = false;
			break;		
		}
		
		if (!$show){
			echo '<p><a href="'.internal_link($page).'">View All</a>';
			hr();
		}
	} elseif ($_REQUEST['submit']){
		$_REQUEST['data']['values'][] = $_REQUEST['bhg_id'];
		if ($arena->NewRow($_REQUEST['data'])){
			echo 'Addition performed.';
		} else {
			echo 'Error encountered.';
		}
		
		echo '<p><a href="'.internal_link($page).'">View All</a>';
		hr();
	} else {
		//Write the current activities
		$current = $arena->Search(array('table'=>$sql, 'search'=>array('end_date'=>'0'), 'order'=>array('aide'=>'ASC')));
		
		if (count($current)){
			$table = new Table('', true);
			
			$table->StartRow();
			$table->AddHeader('Position');
			$table->AddHeader('Hunter');
			$table->AddHeader('&nbsp;');
			$table->EndRow();
			
			foreach ($current as $obj){
				$posi = new Obj('ams_aide_types', $obj->Get('aide'), 'holonet');
				$hunter = new Person($obj->Get('bhg_id'));
				$table->AddRow($posi->Get('name'), $hunter->GetName(), '<a href="'.internal_link($page, array('op'=>'de', 'id'=>$obj->Get('id'))).'">Dismiss</a>');
				$last_type = $obj->Get('type');
			}
			
			$table->EndTable();
			
			hr();
		}
	}
	
	if ($show){
		//'Add New' Block
		$form = new Form($page);
		
		$search = $arena->Search(array('table'=>'ams_aide_types', 'search'=>array('date_deleted'=>'0'), 'order'=>array('name'=>'ASC')));
		
		$rows = array();
		
		foreach ($search as $obj){
			if (!$arena->Search(array('table'=>'ams_aides', 'search'=>array('end_date'=>'0', 'aide'=>$obj->Get('id'))), 0, 1)){
				$rows[] = $obj;
			}
		}
		
		if (count($rows)){		
			$form->AddSectionTitle(($_REQUEST['op'] ? 'Edit' : 'Add New'));
			($_REQUEST['op'] ? $form->AddHidden('op', 'ed') : '');
			$form->AddHidden('id', $id);
			$form->AddHidden('data[table]', $sql);
			$form->AddHidden('stage', '2');
			$form->StartSelect('Aide', 'data[values][]', $aide);
			foreach ($rows as $obj){
				$form->AddOption($obj->Get('id'), $obj->Get('name'));
			}
			$form->EndSelect();
			$form->AddHidden('data[fields][]', 'aide');
			
			include_once 'search.php';
			
			$form->AddHidden('data[values][]', time());
			$form->AddHidden('data[fields][]', 'start_date');
			$form->AddHidden('data[fields][]', 'bhg_id');
			
			$form->AddSubmitButton('submit', 'Process');
		} else {
			$form->AddSectionTitle('You have no open aide positions to assign people to.');
		}
		$form->EndForm();
	}
	
	admin_footer($auth_data);
}
?>
