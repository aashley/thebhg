<?php
function title() {
    return 'Administration :: Arena :: Weapons Type Editor';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;

    arena_header();

    $ladder = new Ladder();
    if (isset($_REQUEST['id'])){
    	$type = new WeaponType($_REQUEST['id']);
	}

    if (isset($_REQUEST['edit'])){
		
	    $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Data');
        $form->table->AddHeader('Value');
        $form->table->EndRow();

        $form->AddHidden('id', $_REQUEST['id']);
        $form->AddTextBox('Weapon:', 'weapon', $type->GetWeapon(), 10);

        $form->AddSubmitButton('submit', 'Edit Weapon Type');
        $form->EndForm();
        
        hr();
        
        $form = new Form($page);
        $form->AddHidden('id', $_REQUEST['id']);
        $form->table->AddRow('<input type="submit" name="delete" value="Delete Weapon Type">', '<input type="submit" name="undelete" value="Undelete Weapon Type">');
        $form->EndForm();
	        
    }
    elseif (isset($_REQUEST['submit'])) {
		$new = $type->SetWeapon($_REQUEST['weapon']);
		if ($new){
			echo "Weapon Type Changed.";
		} else {
			echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 80';
		}
    }
    elseif (isset($_REQUEST['new'])) {
		$new = $ladder->NewWeapon($_REQUEST['weapon']);
		if ($new){
			echo "Successfully added new weapon type.";
		} else {
			echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 83';
        }
    }
    elseif (isset($_REQUEST['delete'])) {
        if ($type->Delete()) {
            echo "Deleted successfully.";
        } else {
	        echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 81';
        }
    }
    elseif (isset($_REQUEST['undelete'])) {
        if ($type->Undelete()) {
            echo "Undeleted successfully.";
        } else {
	        echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 82';
        }
    }
    else {
        $form = new Form($page);
        $form->StartSelect('Type:', 'id');
        foreach ($ladder->AllTypes() as $value) {
            $form->AddOption($value->GetID(), $value->GetWeapon());
        }
        $form->EndSelect();
        $form->AddSubmitButton('edit', 'Edit Weapon Type');
        $form->EndForm();
        
        hr();
        
        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Data');
        $form->table->AddHeader('Value');
        $form->table->EndRow();

        $form->AddTextBox('Weapon Type:', 'weapon', '', 10);

        $form->AddSubmitButton('new', 'Add New Weapon Type');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>