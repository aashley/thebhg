<?php
function title() {
    return 'Administration :: Survival Missions :: Contract Type Editor';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['survival'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;

    arena_header();

    $solo = new Survival();
    if (isset($_REQUEST['id'])){
    	$type = new SurvivalType($_REQUEST['id']);
	}

    if (isset($_REQUEST['edit'])){
		
	    $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Data');
        $form->table->AddHeader('Value');
        $form->table->EndRow();

        $form->AddHidden('id', $_REQUEST['id']);
        $form->AddTextBox('Name:', 'name', $type->GetName(), 10);
        $form->AddTextArea('Description:', 'description', $type->GetDesc());

        $form->AddSubmitButton('submit', 'Edit Type');
        $form->EndForm();
        
        hr();
        
        $form = new Form($page);
        $form->AddHidden('id', $_REQUEST['id']);
        $form->table->AddRow('<input type="submit" name="delete" value="Delete Type">', '<input type="submit" name="undelete" value="Undelete Type">');
        $form->EndForm();
	        
    }
    elseif (isset($_REQUEST['submit'])) {
		$new = $type->Edit($_REQUEST['name'], $_REQUEST['description']);
		echo $new;
    }
    elseif (isset($_REQUEST['new'])) {
		$new = $solo->NewType($_REQUEST['name'], $_REQUEST['description']);
		if ($new){
			echo "Successfully added new type.";
		} else {
			NEC(189);
        }
    }
    elseif (isset($_REQUEST['delete'])) {
        if ($type->Delete()) {
            echo "Deleted successfully.";
        } else {
	        NEC(190);
        }
    }
    elseif (isset($_REQUEST['undelete'])) {
        if ($type->Undelete()) {
            echo "Undeleted successfully.";
        } else {
	        NEC(191);
        }
    }
    else {
        $form = new Form($page);
        $form->StartSelect('Grade:', 'id');
        foreach ($solo->AllTypes() as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddSubmitButton('edit', 'Edit Type');
        $form->EndForm();
        
        hr();
        
        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Data');
        $form->table->AddHeader('Value');
        $form->table->EndRow();

        $form->AddTextBox('Name:', 'name', '', 10);
        $form->AddTextArea('Description:', 'description');

        $form->AddSubmitButton('new', 'Add New Type');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>