<?php

function title() {
    return 'Administration :: Character Sheet :: Equation Variables';
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
	    
	    if ($sheet->NewVaraible($_REQUEST['skill'], $_REQUEST['stat'], $_REQUEST['mod'])){
		    echo 'New Variable Added successfully!';
	    } else {
		    echo 'Error.';
	    }
	    
	    hr();
    }
    
    $form = new Form($page);
    $form->AddSectionTitle('Character Sheet Equations');
    
    $skill = '';
    
    if (isset($_REQUEST['skill'])){
	    $skill = $_REQUEST['skill'];
    }
    
    $form->StartSelect('Skill', 'skill', $skill);
    
    foreach ($sheet->GetSkills() as $value){
	    $form->AddOption($value->GetID(), $value->GetName());
    }
    
    $form->EndSelect();
    
    $form->StartSelect('Statribute', 'stat');
    
    foreach ($sheet->GetStats() as $value){
	    $form->AddOption($value->GetID(), $value->GetName());
    }
    
    $form->EndSelect();
    
    $form->AddTextBox('Modifier', 'mod', '', 5);
    $form->AddSubmitButton('submit', 'Add Variable');
    
    $form->EndForm();
    
    admin_footer($auth_data);
}
?>