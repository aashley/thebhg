<?php

function title() {
    return 'Administration :: Character Sheet :: Fields';
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
	    if ($sheet->NewField($_REQUEST['name'], $_REQUEST['desc'])){
		    echo 'New Field Added Successfully!';
	    } else {
		    NEC(152);
	    }
	    
	    hr();
    }
    
    $form = new Form($page);
    $form->AddSectionTitle('Character Sheet Fields');
    
    $form->AddTextBox('Name', 'name');
    $form->AddTextArea('Description', 'desc');
    $form->AddSubmitButton('submit', 'Add Field');
    
    $form->EndForm();
    
    admin_footer($auth_data);
}
?>