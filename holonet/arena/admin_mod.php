<?php

function title() {
    return 'Administration :: Coder Utilities :: Add Modification System to Sheets';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['coder'];
}

function output() {
    global $auth_data, $hunter, $page, $roster, $sheet;

    arena_header();
    
    if (isset($_REQUEST['submit'])){
	    $fields = array();
	    foreach ($_REQUEST['field'] as $id=>$inc){
		    if ($inc){
			    $fields[$inc] = $id;
		    }
	    }
	    ksort($fields);
		reset($fields);
	    if ($sheet->AddSheetMod($_REQUEST['name'], $_REQUEST['desc'], $fields)){
		    echo 'New Modifcation Added Successfully!';
	    } else {
		    NEC(213);
	    }
	    
	    hr();
    }
    
    $form = new Form($page);
    $form->AddSectionTitle('Character Sheet Modifications');
    
    $form->AddTextBox('Name', 'name');
    $form->AddTextArea('Description', 'desc');
    $form->AddSectionTitle('Set Field Order (Mark 0 to not include)');
    foreach ($sheet->GetFields() as $field){
	    $form->AddTextBox($field->GetName(), 'field['.$field->GetID().']', '', 5);
    }
    $form->AddSubmitButton('submit', 'Add Modification');
    
    $form->EndForm();
    
    admin_footer($auth_data);
}
?>