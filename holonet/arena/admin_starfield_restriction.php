<?php
function title() {
    return 'Administration :: Starfield Arena :: Match Restriction Editor';
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
    	$type = new Restriction($_REQUEST['id']);
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

        $form->AddSubmitButton('submit', 'Edit Restriction');
        $form->EndForm();
        
        hr();
        
        $form = new Form($page);
        $form->AddHidden('id', $_REQUEST['id']);
        $form->table->AddRow('<input type="submit" name="delete" value="Delete Restriction">', '<input type="submit" name="undelete" value="Undelete Restriction">');
        $form->EndForm();
	        
    }
    elseif (isset($_REQUEST['submit'])) {
		$new = $type->Edit($_REQUEST['name'], $_REQUEST['description']);
		echo $new;
    }
    elseif (isset($_REQUEST['new'])) {
		$new = $starfield->NewRestriction($_REQUEST['name'], $_REQUEST['description']);
		if ($new){
			echo "Successfully added new restriction.";
		} else {
			echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 100';
        }
    }
    elseif (isset($_REQUEST['delete'])) {
        if ($type->Delete()) {
            echo "Deleted successfully.";
        } else {
	        echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 102';
        }
    }
    elseif (isset($_REQUEST['undelete'])) {
        if ($type->Undelete()) {
            echo "Undeleted successfully.";
        } else {
	        echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 103';
        }
    }
    else {
        $form = new Form($page);
        $form->StartSelect('Restriction:', 'id');
        foreach ($starfield->AllRestrictions() as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddSubmitButton('edit', 'Edit Restriction');
        $form->EndForm();
        
        hr();
        
        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Data');
        $form->table->AddHeader('Value');
        $form->table->EndRow();

        $form->AddTextBox('Name:', 'name', '', 10);
        $form->AddTextArea('Description:', 'description');

        $form->AddSubmitButton('new', 'Add New Restriction');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>