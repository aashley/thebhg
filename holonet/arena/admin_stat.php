<?php

function title() {
    return 'Administration :: Character Sheet :: Statribute';
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
    
    $int = '';
    if (isset($_REQUEST['int'])){
	    $int = $_REQUEST['int'];
    }
    
    if (isset($_REQUEST['submit'])){
	    if ($sheet->NewStatribute($_REQUEST['name'], $_REQUEST['desc'], $int, $_REQUEST['field'])){
		    echo 'New Statribute Added Successfully!';
	    } else {
		    NEC(168);
	    }
	    
	    hr();
    }
    
    $form = new Form($page);
    $form->AddSectionTitle('Character Sheet Statributes');
    
    $form->AddTextBox('Name', 'name');

    $form->AddCheckBox('Interger Value', 'int', '1', $int); 
    
    $field = '';
    if (isset($_REQUEST['field'])){
	    $field = $_REQUEST['field'];
    }
    $form->StartSelect('Field', 'field', $field);
    $fields = array_flip($sheet->ModFields(1));
    foreach ($fields as $val){
	    $value = new Field($val);
	    $form->AddOption($value->GetID(), $value->GetName());
    }
    
    $form->EndSelect();
    
    $form->AddTextArea('Description', 'desc');
    $form->AddSubmitButton('submit', 'Add Statribute');
    
    $form->EndForm();
    
    admin_footer($auth_data);
}
?>