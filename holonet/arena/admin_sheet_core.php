<?php

function title() {
	return 'Character Sheet :: CORE Sheets';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return true;
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet;
    
    arena_header();
    
    $character = new Character($hunter->GetID());
    
    $saves = $character->GetCores();

    if (!$_REQUEST['sheet'] && !$_REQUEST['new'] && !$_REQUEST['view'] && !$_REQUEST['save']){
	    echo '<a href="'.internal_link($page, array('new'=>1)).'">Make new CORE Sheet</a>.';
		hr();
	    
	    if (count($saves)){
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('My CORE Submissions', 7);
		    $table->EndRow();
		    
		    $table->AddRow('Save Name', 'Date', 'Approved', 'Pending Approval', '&nbsp', '&nbsp', '&nbsp');
		    
		    foreach ($saves as $data){
			    $table->AddRow('<a href="'.internal_link($page, array('view'=>1, 'sheet'=>$data['id'])).'">'.$character->GetName('cores', $data['id'], 'id').'</a>', $data['date'], ($data['app'] ? 'Yes' : 'No'), ($data['pending'] ? 'Yes' : 'No'),
			    	'<a href="'.internal_link($page, array('sheet'=>$data['id'])).'">Load to Edit</a>', 
			    	($data['share'] ? '' : '<a href="'.internal_link($page, array('save'=>1, 'delete'=>1, 'sheet'=>$data['id'])).'">Delete</a>'), 
			    	($data['share'] ? '' : '<a href="'.internal_link($page, array('save'=>1, 'submit'=>1, 'sheet'=>$data['id'])).'">Submit for Approval</a>'));
		    }
		    
		    $table->EndTable();
	    }
    } else {
		$value_set = $character->GetSheetValues('cores', $_REQUEST['sheet'], 'id');
		
		if (isset($_REQUEST['save'])){
			if ($auth_data['sheet'] && !$_REQUEST['submit']){
				if ($_REQUEST['delete']){
					$character->DeleteCore($_REQUEST['sheet']);
				}
				if ($_REQUEST['approve']){
					echo $character->ApproveCore($_REQUEST['sheet']);
				} else {
					echo $character->DenyCore($_REQUEST['sheet'], $_REQUEST['reason']);
				}
			} else {
				echo $character->SubmitCore($_REQUEST['core']);
			}
		} elseif (isset($_REQUEST['view'])){
			if (isset($_REQUEST['process'])){
				echo $character->SaveCore($_REQUEST['stat'], $_REQUEST['expr'], $_REQUEST['pers'], $_REQUEST['sheet']);
				hr();
				$_REQUEST['sheet'] = $character->LastID;
			}
			
			$character->ParseSheet('cores', $_REQUEST['sheet'], 'id');
		    
		    hr();
		    
		    if ($auth_data['sheet']){
			    $form = new Form($page);	
			    $form->AddHidden('sheet', $_REQUEST['sheet']);    	
			    $form->AddHidden('save', 1);
			    $form->AddTextArea('Reason (for denial): ', 'reason');
			    $form->table->StartRow();
			    $form->table->AddCell('<input type="submit" name="deny" Value="Deny CORE"> || <input type="submit" name="approve" Value="Approve CORE">', 2);
			    $form->table->EndRow();
		    	$form->EndForm();
	    	} else {
		    	$form = new Form($page);	
			    $form->AddHidden('sheet', $_REQUEST['sheet']);    	
			    $form->table->AddRow('<input type="submit" name="save" Value="Submit CORE">');
		    	$form->EndForm();
	    	}
		} else {
			
			$table = new Table();
			$table->StartRow();
			$table->AddHeader('Points to Distribute', 2);
			$table->EndRow();
			$table->AddRow('Statribute Points: ', $sheet->StatributePoints());
			$table->AddRow('Expertise Points: ', $sheet->ExpertisePoints());
			$table->EndTable();
			
			hr();
		    
	    	$form = new Form($page);
	    	
	    	foreach($sheet->GetStats(12) as $stat){
		    	if ($stat->IsInt()){
			    	$value = 0;
			    	if (array_key_exists($stat->GetID(), $value_set)){
				    	$value = $value_set[$stat->GetID()];
			    	}
		    		$form->AddTextBox($stat->GetName().' (<a href="'.internal_link('desc', array('id'=>$stat->GetID())).'">Description</a>)', "pers[".$stat->GetID()."]", $value, 5);
	    		} else {
		    		$value = '';
			    	if (array_key_exists($stat->GetID(), $value_set)){
				    	$value = $value_set[$stat->GetID()];
			    	}
		    		$form->AddTextBox($stat->GetName().' (<a href="'.internal_link('desc', array('id'=>$stat->GetID())).'">Description</a>)', "pers[".$stat->GetID()."]", stripslashes($value));
	    		}
	    	}
	    	
	    	for ($i = 1; $i <= 6; $i++){
		    	$field = new Field($i);
			    $form->AddSectionTitle($field->GetName());
		    	foreach($sheet->GetStats($i) as $stat){
			    	if ($i <= 2){
				    	$prefix = 'stat';
			    	} else {
				    	$prefix = 'expr';
			    	}
			    	$value = 0;
			    	if (array_key_exists($stat->GetID(), $value_set)){
				    	$value = $value_set[$stat->GetID()];
			    	}
				    $form->AddTextBox($stat->GetName().' (<a href="'.internal_link('desc', array('id'=>$stat->GetID())).'">Description</a>)', $prefix."[".$stat->GetID()."]", $value, 5);
		    	}
	    	}
	    	for ($i = 10; $i <= 11; $i++){
		    	$field = new Field($i);
			    $form->AddSectionTitle($field->GetName());
		    	foreach($sheet->GetStats($i) as $stat){
			    	if ($stat->IsInt()){
				    	$value = 0;
				    	if (array_key_exists($stat->GetID(), $value_set)){
					    	$value = $value_set[$stat->GetID()];
				    	}
			    		$form->AddTextBox($stat->GetName().' (<a href="'.internal_link('desc', array('id'=>$stat->GetID())).'">Description</a>)', "pers[".$stat->GetID()."]", $value, 5);
		    		} else {
			    		$value = '';
				    	if (array_key_exists($stat->GetID(), $value_set)){
					    	$value = $value_set[$stat->GetID()];
				    	}
			    		$form->AddTextArea($stat->GetName().' (<a href="'.internal_link('desc', array('id'=>$stat->GetID())).'">Description</a>)', "pers[".$stat->GetID()."]", stripslashes($value));
		    		}
		    	}
	    	}
	    	$form->AddHidden('process', 1);
	    	$form->AddHidden('sheet', $_REQUEST['sheet']);
	    	$form->AddSubmitButton('view', 'Check Sheet');
	    	$form->EndForm();
		}		    	
	}
	
	admin_footer($auth_data);

}
?>