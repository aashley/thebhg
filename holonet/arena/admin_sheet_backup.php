<?php

function title() {
	
	$return = '';
	
	if (isset($_REQUEST['id'])){
		$person = new Person($_REQUEST['id']);
    	$return .= $person->GetName().'\'s ';
	} 
	
	$return .= 'Character Sheet :: Sheet Saves and Backups';
	
	return $return;
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
    
    $character = new Saves($hunter->GetID());
    
    $values = array();
    $show = true;
    
    if (isset($_REQUEST['submit'])){
	    $go = true;
	    if ($_REQUEST['sheet'] == 'records'){
		    if (in_array($_REQUEST['saveid'], $character->GetSaveFunctions())){
			    $go = true;
		    } else {
			    $go = false;
		    }
	    }
	    if ($go){
	    	echo $character->Backup($_REQUEST['save'], $_REQUEST['sheet'], $_REQUEST['saveid']);
    	} else {
	    	echo 'This is not your save ID. Please stop trying to hack my Holonet.';
    	}
	    hr();		     
    }
    
    if (isset($_REQUEST['goload'])){
	    if ($character->IsNew()){
			if (!$character->NewSheet()){
				NEC(161);
				admin_footer($auth_data);
				return;
			} else {
				$sheet->RegistrarTrack('new');
			}
		}
	    if ($_REQUEST['okay'] == 'core'){
		    echo $character->LoadCore($_REQUEST['sheet']);
	    } elseif ($_REQUEST['okay'] == 'saves'){
		    echo $character->LoadSaveFunction($_REQUEST['sheet']);
	    } else {
	    	echo $character->LoadBackup($_REQUEST['sheet']);
    	}
	    hr();
    }
    
    if (isset($_REQUEST['delete'])){
	    if ($character->ValidLoad($_REQUEST['sheet'], 1)){
		    if ($_REQUEST['confirm']){
			    echo $character->DeleteBackup($_REQUEST['sheet']);
			    hr();		
		    } else {
			    $form = new Form($page);
			    $form->AddHidden('sheet', $_REQUEST['sheet']);
			    $form->AddHidden('confirm', 1);
			    echo '<input type="submit" name="delete" value="Confirm Delete">';
			    $form->EndForm();
			    $show = false;
		    }
	    }
    }
    
    if (isset($_REQUEST['delshare'])){
	    if ($character->ValidLoad($_REQUEST['sheet'], 1)){
		    echo $character->RemoveShare($_REQUEST['hunt'], $_REQUEST['sheet']);
		    hr();		
	    }
    }
    
    if (isset($_REQUEST['share'])){
	    if ($character->ValidLoad($_REQUEST['sheet'], 1)){
		    if ($_REQUEST['bhg_id']){
			    echo $character->Share($_REQUEST['bhg_id'], $_REQUEST['sheet']);
			    hr();		
		    } else {
			    $form = new Form($page);
			    $form->AddSectionTitle('Choose Hunter');
			    $form->AddHidden('sheet', $_REQUEST['sheet']);
			    include_once 'search.php';
			    $form->AddSubmitButton('share', 'Share Sheet');
			    $form->EndForm();
			    $show = false;
		    }
	    }
    }
    
    if ($show){
	    if (isset($_REQUEST['load'])){
	    
		    if ($character->ValidLoad($_REQUEST['sheet']) || $_REQUEST['prompt'] == 'core' || $_REQUEST['prompt'] == 'saves'){
		    
			    if ($_REQUEST['prompt'] == 'saves'){
				    $load = 'records';
				    $name = 'Auto-Save';
			    } elseif ($_REQUEST['prompt'] == 'core'){
				    $load = 'cores';
				    $name = 'CORE';
			    } else {
				    $load = 'backups';
				    $name = 'Backup';
			    }
			    
			    if ($character->EditBan('SYSTEM') < time()){
			    
				    $form = new Form($page);
				    
				    $form->AddHidden('sheet', $_REQUEST['sheet']);
				    $form->AddHidden('okay', $_REQUEST['prompt']);
				    $form->table->StartRow();
				    $form->table->AddHeader('Upload Backup');
				    $form->table->EndRow();
				    $form->table->AddRow('<input type="submit" value="Load '.$name.' as Edit Sheet" name="goload">');
				    
				    $form->EndForm();
				    hr();
			    }
			    
			    $character->ParseSheet($load, $_REQUEST['sheet'], 'id', true);
		    } else {
			    echo 'This is an invlaid load. You can only load your own Backup sheets.';
		    }
		    
	    } elseif (isset($_REQUEST['view'])){
		    
		    $show = true;
		    
		    if ($_REQUEST['sheet'] == 'records'){
			    $show = false;
			    $form = new Form($page);
			    $form->StartSelect('Choose Save', 'saveid');
			    foreach ($character->GetSaveFunctions() as $sheet){
				    $form->AddOption($sheet['id'], 'Save '.$sheet['id']);
			    }
			    $form->EndSelect();
			    $form->AddHidden('sheet', $_REQUEST['sheet']);
			    $form->AddSubmitButton('view', 'View Sheet');
			    $form->EndForm();
		    }
		    
		    $id = 0;
		    
		    if ($_REQUEST['saveid']){
			    if (in_array($_REQUEST['saveid'], array_keys($character->GetSaveFunctions()))){
				    $id = $_REQUEST['saveid'];
				    $show = true;
			    }
		    }
		    
		    if ($show){
			    $form = new Form($page);
			    $form->AddSectionTitle('Backup Resource');
			    $form->AddTextBox('Save name:', 'save');
			    $form->AddHidden('sheet', $_REQUEST['sheet']);
			    $form->AddHidden('saveid', $_REQUEST['saveid']);
			    $form->AddSubmitButton('submit', 'Save Sheet');
			    $form->EndForm();
		    
			    hr();
			    
			    $character->ParseSheet($_REQUEST['sheet'], $id);
		    }
	    } else {    
		    if (!$character->IsNew()){
			    if ($character->HasValue('values')){
				    $values['My Approved Sheet'] = 'values';
			    }
			    if ($character->HasValue('pending')){
				    $values['My Editing Sheet'] = 'pending';
			    }
			    if (count($character->GetSaveFunctions())){
				    $values['Auto-Saved Sheet'] = 'records';
			    }
		    }
		    
		    if (count($values)){
			    $form = new Form($page);
			    $form->AddSectionTitle('Save a Sheet Backup');
			    $form->StartSelect('Sheet to Save', 'sheet');
			    foreach ($values as $name=>$value){
				    $form->AddOption($value, $name);
			    }
			    $form->EndSelect();
			    $form->AddSubmitButton('view', 'View This Sheet');
			    $form->EndForm();
		    } else {
			    echo 'You have no sheets to backup.';
		    }
		    
		    $saves = $character->GetBackups();
		    
		    if (count($saves)){
			    hr();
			    $table = new Table('', true);
			    $table->StartRow();
			    $table->AddHeader('Sheet Backups', 5);
			    $table->EndRow();
			    
					$table->StartRow();
					$table->AddHeader('Save Name');
					$table->AddHeader('Date');
					$table->AddHeader('&nbsp;');
					$table->AddHeader('&nbsp;');
					$table->AddHeader('&nbsp;');
					$table->EndRow();
			    
			    foreach ($saves as $data){
				    $table->AddRow($data['name'], $data['date'], 
				    	'<a href="'.internal_link($page, array('load'=>1, 'sheet'=>$data['id'])).'">Load Sheet</a>', 
				    	($data['share'] ? '' : '<a href="'.internal_link($page, array('delete'=>1, 'sheet'=>$data['id'])).'">Delete</a>'), 
				    	($data['share'] ? '' : '<a href="'.internal_link($page, array('share'=>1, 'sheet'=>$data['id'])).'">Share</a>'));
			    }
			    
			    $table->EndTable();
		    }
		    
		    $shares = $character->MyShares();
		    
		    if (count($shares)){
			    hr();
			    $table = new Table('', true);
			    $table->StartRow();
			    $table->AddHeader('Shared Sheets', 5);
			    $table->EndRow();
			    
					$table->StartRow();
					$table->AddHeader('Sheet');
					$table->AddHeader('Person');
					$table->AddHeader('&nbsp;');
					$table->EndRow();
			    
			    foreach ($shares as $data){
				    $hunt = new Person($data['hunter']);
				    $table->AddRow($data['name'], '<a href="'.internal_link('atn_general', array('id'=>$data['hunter'])).'">'.$hunt->GetName().'</a>',
				    '<a href="'.internal_link($page, array('delshare'=>1, 'sheet'=>$data['id'], 'hunt'=>$data['hunter'])).'">Delete Share</a>');
			    }
			    
			    $table->EndTable();
		    }
		    
		    $saves = $character->GetSaveFunctions(20);
		    
		    if (count($saves)){		    
		    	hr();
			    $table = new Table('', true);
			    $table->StartRow();
			    $table->AddHeader('Last 20 Auto-Saves', 5);
			    $table->EndRow();
			    
					$table->StartRow();
					$table->AddHeader('Save ID');
					$table->AddHeader('Date');
					$table->AddHeader('&nbsp');
					$table->EndRow();
			    
			    foreach ($saves as $data){
				    $table->AddRow($data['id'], $data['date'], 
				    	'<a href="'.internal_link($page, array('load'=>1, 'sheet'=>$data['id'], 'prompt'=>'saves')).'">Load Sheet</a>');
			    }
			    
			    $table->EndTable();
		    }
	    }
    }
	
	admin_footer($auth_data);

}
?>
