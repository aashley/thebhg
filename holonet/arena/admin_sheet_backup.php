<?php

function title() {
	
	$return = '';
	
	if (isset($_REQUEST['id'])){
		$person = new Person($_REQUEST['id']);
    	$return .= $person->GetName().'\'s ';
	} 
	
	$return .= 'Character Sheet :: Backup Utility';
	
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

    $character = new Character($hunter->GetID());
    
    $values = array();

    if (isset($_REQEUST['submit'])){
	    echo $character->Backup($_REQEUST['save'], $_REQUEST['sheet']);
	    hr();		     
    }
    
    if ($_REQUEST['view']){
	    
	    $form = new Form($page);
	    $form->AddSectionTitle('Backup Resource');
	    $form->AddTextBox('Save name:', 'save');
	    $form->AddHidden('sheet', $_REQUEST['sheet']);
	    $form->AddSubmitButton('submit', 'Save Sheet');
	    $form->EndForm();
	    
	    hr();
	    
	    $character->ParseSheet($_REQUEST['sheet']);
    } else {    
	    if ($character->HasValue('values')){
		    $values['My Approved Sheet'] = 'values';
	    }
	    if ($character->HasValue('pending')){
		    $values['My Editing Sheet'] = 'pending';
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
    }
	
	admin_footer($auth_data);

}
?>