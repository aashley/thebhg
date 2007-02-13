<?php

function title() {
    return 'Administration :: Strategist Utilities :: Manage CS Backups';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['overseer'];
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet;
    
    arena_header();

    $character = new Saves($hunter->GetID());
    
    $values = array();
    $show = true;
    
    if (isset($_REQUEST['submit'])){
	    echo $character->Backup($_REQUEST['save'], $_REQUEST['sheet']);
	    hr();		     
    }
    
    if ($_REQUEST['goload']){
	    echo $character->LoadBackup($_REQUEST['sheet']);
	    hr();
    }
    
    if (isset($_REQUEST['delete'])){
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
    
    if (isset($_REQUEST['delshare'])){
	    echo $character->RemoveShare($_REQUEST['hunt'], $_REQUEST['sheet']);
	    hr();		
    }
    
    if (isset($_REQUEST['share'])){
	    if ($_REQUEST['bhg_id']){
		    echo $character->Share($_REQUEST['bhg_id'], $_REQUEST['sheet']);
		    hr();		
	    } else {
		    $form = new Form($page);
		    $form->AddSectionTitle('Choose Hunter');
		    $form->AddHidden('sheet', $_REQUEST['sheet']);

			if ($_REQUEST['submit']){
				$form->AddHidden('bhg_id', $_REQUEST['bhg_id']);
			} else {
		        include_once 'search.php';
			}
		    $form->AddSubmitButton('share', 'Share Sheet');
		    $form->EndForm();
		    $show = false;
	    }
    }
    
    if ($show){
	    $saves = $sheet->GetBackups();
	    
	    if (count($saves)){
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('Sheet Backups', 5);
		    $table->EndRow();
		    
		    $table->AddRow('Save Name', 'Date', '&nbsp', '&nbsp', '&nbsp');
		    
		    foreach ($saves as $data){
			    $table->AddRow($data['name'], $data['date'], 
			    	'<a href="'.internal_link($page, array('view'=>1, 'sheet'=>$data['id'])).'">View Sheet</a>', 
			    	'<a href="'.internal_link($page, array('delete'=>1, 'sheet'=>$data['id'])).'">Delete</a>', 
			    	'<a href="'.internal_link($page, array('share'=>1, 'sheet'=>$data['id'])).'">Share</a>');
		    }
		    
		    $table->EndTable();
	    }
	    
	    $shares = $sheet->GetShares();
	    
	    if (count($shares)){
		    hr();
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('Shared Sheets', 5);
		    $table->EndRow();
		    
		    $table->AddRow('Sheet', 'Person', 'Shared With', '&nbsp');
		    
		    foreach ($shares as $data){
			    $hunt = new Person($data['hunter']);
			    $with = new Person($data['with']);
			    $table->AddRow($data['name'], '<a href="'.internal_link('atn_general', array('id'=>$data['hunter'])).'">'.$hunt->GetName().'</a>', 
			    '<a href="'.internal_link('atn_general', array('id'=>$with->GetID())).'">'.$with->GetName().'</a>',
			    '<a href="'.internal_link($page, array('delshare'=>1, 'sheet'=>$data['id'], 'hunt'=>$data['hunter'])).'">Delete Share</a>');
		    }
		    
		    $table->EndTable();
	    }
    }
    
    if ($_REQUEST['view']){
	    hr();
	    $character = $sheet->GetBackup($_REQUEST['sheet']);
		$saves = $character->GetBackups();
	    $character->ParseSheet('backups', $_REQUEST['sheet'], 'id');
    }
	
	admin_footer($auth_data);

}
?>
