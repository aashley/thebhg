<?php

function title() {
    return 'Administration :: Character Sheet :: Skills';
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
	    if ($sheet->NewSkill($_REQUEST['name'], $_REQUEST['desc'], $_REQUEST['field'])){
		    echo 'New Skill Added Successfully!';
	    } else {
		    NEC(157);
	    }
	    
	    hr();
    }
    
    $form = new Form($page);
    $form->AddSectionTitle('Character Sheet Skills');
    
    $form->AddTextBox('Name', 'name');
    
    $field = '';
    
    if (isset($_REQUEST['field'])){
	    $field = $_REQUEST['field'];
    }
    
    $form->StartSelect('Field', 'field', $field);
    
    foreach ($sheet->GetFields() as $value){
	    $form->AddOption($value->GetID(), $value->GetName());
    }
    
    $form->EndSelect();
    
    $form->AddTextArea('Description', 'desc');
    $form->AddSubmitButton('submit', 'Add Skill');
    
    $form->EndForm();
    
    admin_footer($auth_data);
}
?>