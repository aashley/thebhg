<?php
function title() {
    return 'Administration :: Survival Missions :: Contract Grade Editor';
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
    	$type = new SurvivalGrade($_REQUEST['id']);
	}

    if (isset($_REQUEST['edit'])){
		
	    $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Data');
        $form->table->AddHeader('Value');
        $form->table->EndRow();

        $form->AddHidden('id', $_REQUEST['id']);
        $form->AddTextBox('Name:', 'name', $type->GetName(), 10);
        $form->AddTextBox('Points:', 'points', $type->GetPoints());
        $form->AddTextArea('Description:', 'description', $type->GetDesc());

        $form->AddSubmitButton('submit', 'Edit Grade');
        $form->EndForm();
        
        hr();
        
        $form = new Form($page);
        $form->AddHidden('id', $_REQUEST['id']);
        $form->table->AddRow('<input type="submit" name="delete" value="Delete Grade">', '<input type="submit" name="undelete" value="Undelete Grade">');
        $form->EndForm();
	        
    }
    elseif (isset($_REQUEST['submit'])) {
		$new = $type->Edit($_REQUEST['name'], $_REQUEST['description'], $_REQUEST['points']);
		echo $new;
    }
    elseif (isset($_REQUEST['new'])) {
		$new = $solo->NewGrade($_REQUEST['name'], $_REQUEST['description'], $_REQUEST['points']);
		if ($new){
			echo "Successfully added new grade.";
		} else {
			NEC(181);
        }
    }
    elseif (isset($_REQUEST['delete'])) {
        if ($type->Delete()) {
            echo "Deleted successfully.";
        } else {
	        NEC(182);
        }
    }
    elseif (isset($_REQUEST['undelete'])) {
        if ($type->Undelete()) {
            echo "Undeleted successfully.";
        } else {
	        NEC(183);
        }
    }
    else {
        $form = new Form($page);
        $form->StartSelect('Grade:', 'id');
        foreach ($solo->AllGrades() as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddSubmitButton('edit', 'Edit Grade');
        $form->EndForm();
        
        hr();
        
        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Data');
        $form->table->AddHeader('Value');
        $form->table->EndRow();

        $form->AddTextBox('Name:', 'name', '', 10);
        $form->AddTextBox('Points:', 'points');
        $form->AddTextArea('Description:', 'description');

        $form->AddSubmitButton('new', 'Add New Grade');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>