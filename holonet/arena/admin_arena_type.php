<?php
function title() {
    return 'Administration :: Arena :: Match Type Editor';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['arena'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;

    arena_header();

    $ladder = new Ladder();
    if (isset($_REQUEST['id'])){
    	$type = new Type($_REQUEST['id']);
	}

    if (isset($_REQUEST['edit'])){
		
	    $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Data');
        $form->table->AddHeader('Value');
        $form->table->EndRow();

        $form->AddHidden('id', $_REQUEST['id']);
        $form->AddTextBox('Name:', 'name', $type->GetName(), 50);
        $form->AddTextArea('Description:', 'description', $type->GetDesc());
        $form->AddTextArea('Rules:', 'rules', $type->GetRules());
        $form->AddTextBox('Fighters:', 'fighters', $type->GetFighters(), 3);

        $form->AddSubmitButton('submit', 'Edit Type');
        $form->EndForm();
        
        hr();
        
        $form = new Form($page);
        $form->AddHidden('id', $_REQUEST['id']);
        $form->table->AddRow('<input type="submit" name="delete" value="Delete Type">', '<input type="submit" name="undelete" value="Undelete Type">');
        $form->EndForm();
	        
    }
    elseif (isset($_REQUEST['submit'])) {
		$new = $type->Edit($_REQUEST['name'], $_REQUEST['description'], $_REQUEST['rules'], $_REQUEST['fighters']);
		echo $new;
    }
    elseif (isset($_REQUEST['new'])) {
		$new = $ladder->NewType($_REQUEST['name'], $_REQUEST['description'], $_REQUEST['rules'], $_REQUEST['fighters']);
		if ($new){
			echo "Successfully added new type.";
		} else {
			echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 78';
        }
    }
    elseif (isset($_REQUEST['delete'])) {
        if ($type->Delete()) {
            echo "Deleted successfully.";
        } else {
	        echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 76';
        }
    }
    elseif (isset($_REQUEST['undelete'])) {
        if ($type->Undelete()) {
            echo "Undeleted successfully.";
        } else {
	        echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 77';
        }
    }
    else {
        $form = new Form($page);
        $form->StartSelect('Type:', 'id');
        foreach ($ladder->AllRules() as $value) {
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
        
        $form->AddTextArea('Rules:', 'rules');
        
        $form->AddTextBox('Fighters:', 'fighters', 2);

        $form->AddSubmitButton('new', 'Add New Type');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>