<?php

function title() {
    return 'Administration :: Coder Utilities :: Modify a Sheet Modification';
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
	    if ($sheet->UpdateSheetMod($_REQEUST['mod'], $_REQUEST['name'], $_REQUEST['desc'], $fields)){
		    echo 'Modifcation Updated Successfully!';
	    } else {
		    NEC(214);
	    }
    } elseif ($_REQUEST['next']) {
	    $form = new Form($page);
	    $form->AddSectionTitle('Character Sheet Modifications');
	    
	    $form->AddHidden('mod', $_REQUEST['mod']);
	    
	    $mod = $sheet->BuildModEdit($_REQUEST['mod']);
	    $fields = array_flip($mod['fields']);
	    
	    $form->AddTextBox('Name', 'name', $mod['name']);
	    $form->AddTextArea('Description', 'desc', $mod['desc']);
	    $form->AddSectionTitle('Set Field Order (Mark 0 to not include)');
	    foreach ($sheet->GetFields() as $field){
		    $form->AddTextBox($field->GetName(), 'field['.$field->GetID().']', $fields[$field->GetID()], 5);
	    }
	    $form->AddSubmitButton('submit', 'Add Modification');
	    
	    $form->EndForm();
    } else {
	    $form = new Form($page);
	    $form->AddSectionTitle('Character Sheet Modifications');
	    
	    if (count($sheet->AllMods())){
		    $form->StartSelect('Modification Name:', 'mod');
		    foreach ($sheet->AllMods() as $mod){
			    $form->AddOption($mod['id'], $mod['name']);
		    }
		    $form->EndSelect();
		    $form->AddSubmitButton('next', 'Edit Modification');
	    }	    
	    
	    $form->EndForm();
    
    admin_footer($auth_data);
}
?>