<?php

function title() {
    return 'Administration :: Character Sheet :: Modify Sheet Field Order';
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
	    $fields = array();
	    foreach ($_REQUEST['field'] as $id=>$inc){
		    if ($inc){
			    $fields[$inc] = $id;
		    }
	    }
	    ksort($fields);
		reset($fields);
	    if ($sheet->UpdateSheetMod($_REQUEST['mod'], $_REQUEST['name'], $_REQUEST['desc'], $fields)){
		    echo 'Modifcation Updated Successfully!';
	    }
    } else {
	    $form = new Form($page);
	    $form->AddSectionTitle('Character Sheet Modifications');
	    
	    $form->AddHidden('mod', 1);
	    
	    $mod = $sheet->BuildModEdit(1);
	    if (is_array($mod['fields'])){
	    	$fields = array_flip($mod['fields']);
    	} else {
	    	$fields = array();
    	}
	    
	    $form->AddHidden('name', $mod['name']);
	    $form->AddHidden('desc', $mod['desc']);
	    $form->AddSectionTitle('Set Field Order (Mark 0 to not include)');
	    foreach ($sheet->GetFields() as $field){
		    $form->AddTextBox($field->GetName(), 'field['.$field->GetID().']', $fields[$field->GetID()], 5);
	    }
	    $form->AddSubmitButton('submit', 'Submit Modification');
	    
	    $form->EndForm();
    }
    
    admin_footer($auth_data);
}
?>