<?php

function title() {
    return 'Administration :: Character Sheet :: Add Character Attribute';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['sheet'];
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet;

    arena_header();
    
    if (isset($_REQUEST['submit'])){
	    if ($sheet->NewCSCA($_REQUEST['name'], $_REQUEST['desc'])){
		    echo 'New Character Attribute Added Successfully!';
	    } else {
		    NEC(215);
	    }
	    
	    hr();
    }
    
    $form = new Form($page);
    $form->AddSectionTitle('Character Sheet Character Attribute');
    
    $form->AddTextBox('Name', 'name');
    $form->AddTextArea('Description', 'desc');
    $form->AddSubmitButton('submit', 'Add Attribute');
    
    $form->EndForm();
    
    admin_footer($auth_data);
}
?>