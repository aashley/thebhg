<?php

function title() {
    return 'Administration :: Character Sheet :: Character Attribute Stats';
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
	    
		if ($_REQUEST['skill'] && $_REQUEST['stat']){
			echo 'Please don\'t be retarded. I told you, pick one or the other, either skill or stat.';
		} else {
			if ($_REQUEST['skill']){
				$skill = 1;
				$field = $_REQUEST['skill'];
			} else {
				$skill = 0;
				$field = $_REQUEST['stat'];
			}
		    if ($sheet->AddCAValue($_REQUEST['ca'], $skill, $field, $_REQUEST['mod'])){
			    echo 'New Variable Added successfully!';
		    } else {
			    NEC(216);
		    }
	    }
	    
	    hr();
    }
    
    $form = new Form($page);
    $form->AddSectionTitle('Character Attribute Modifiers');
    $form->table->StartRow();
    $form->table->AddCell('Note, make sure either the stat or skill is set to 0, as if both are set to a value, it will kick you back', 2);
    $form->table->EndRow();
    
    $form->StartSelect('Attribute', 'ca', $_REQUEST['ca']);
    foreach ($sheet->GetCAs() as $id=>$value){
		$form->AddOption($id, $value['name']);
    }
    $form->EndSelect();
    
    $form->StartSelect('Skill', 'skill');
    $form->AddOption(0, '');
    foreach ($sheet->GetSkills() as $value){
	    if ($sheet->Permit(2, $value->GetID(), 1)){
	    	$form->AddOption($value->GetID(), $value->GetName());
    	}
    }
    
    $form->EndSelect();
    
    $form->StartSelect('Statribute', 'stat');
    $form->AddOption(0, '');
    foreach ($sheet->GetStats() as $value){
	    if ($sheet->Permit(1, $value->GetID(), 1)){
	    	$form->AddOption($value->GetID(), $value->GetName());
    	}
    }
    
    $form->EndSelect();
    
    $form->AddTextBox('Modifier', 'mod', $_REQUEST['mod'], 5);
    $form->AddSubmitButton('submit', 'Add Variable');
    
    $form->EndForm();
    
    admin_footer($auth_data);
}
?>