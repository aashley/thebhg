<?php
function title() {
    return 'Administration :: Starfield Arena :: Match Setting Editor';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['star'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;

    arena_header();

    $starfield = new Starfield();
    if (isset($_REQUEST['id'])){
    	$type = new Setting($_REQUEST['id']);
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

        $form->AddSubmitButton('submit', 'Edit Setting');
        $form->EndForm();
        
        hr();
        
        $form = new Form($page);
        $form->AddHidden('id', $_REQUEST['id']);
        $form->table->AddRow('<input type="submit" name="delete" value="Delete Setting">', '<input type="submit" name="undelete" value="Undelete Setting">');
        $form->EndForm();
	        
    }
    elseif (isset($_REQUEST['submit'])) {
		$new = $type->Edit($_REQUEST['name'], $_REQUEST['description']);
		echo $new;
    }
    elseif (isset($_REQUEST['new'])) {
		$new = $starfield->NewSetting($_REQUEST['name'], $_REQUEST['description']);
		if ($new){
			echo "Successfully added new setting.";
		} else {
			NEC(96);
        }
    }
    elseif (isset($_REQUEST['delete'])) {
        if ($type->Delete()) {
            echo "Deleted successfully.";
        } else {
	        NEC(98);
        }
    }
    elseif (isset($_REQUEST['undelete'])) {
        if ($type->Undelete()) {
            echo "Undeleted successfully.";
        } else {
	        NEC(99);
        }
    }
    else {
        $form = new Form($page);
        $form->StartSelect('Setting:', 'id');
        foreach ($starfield->AllSettings() as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddSubmitButton('edit', 'Edit Setting');
        $form->EndForm();
        
        hr();
        
        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Data');
        $form->table->AddHeader('Value');
        $form->table->EndRow();

        $form->AddTextBox('Name:', 'name', '', 10);
        $form->AddTextArea('Description:', 'description');

        $form->AddSubmitButton('new', 'Add New Setting');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>