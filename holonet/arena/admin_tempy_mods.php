<?php
function title() {
    return 'Administration :: Tempestuous Group :: Edit Moderators';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['tempy_mod'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;
    
    arena_header();

    $tempy = new Tempy();
    $mods = $tempy->Mods();
    $members = $tempy->BaseMembers();
    $posi = '';
    
    if (isset($_REQUEST['bhg_id'])){
    	$edited = new Person($_REQUEST['bhg_id']);
    	$posi = $edited->GetPosition();
	}
    
	if (is_object($posi)){
		if ($posi->GetID() == 9 || $posi->GetID() == 29){
		    echo "You can't edit the moderator status of the OV/AJ.";
		    return false;
	    }
    }
	
    if (isset($_REQUEST['edit'])) {
        if ($tempy->UpdateMod($_REQUEST['bhg_id'], $_REQUEST['status'])) {
	        echo 'Tempestuous Moderator Status Edited.';
        } else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 44';
        }
    }
    elseif (isset($_REQUEST['grant'])) {
        if ($tempy->UpdateMod($_REQUEST['bhg_id'], 1)) {
	        echo 'Tempestuous Moderator Status Granted.';
        } else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 44';
        }
    } 
    elseif (isset($_REQUEST['remove'])) {
        if ($tempy->UpdateMod($_REQUEST['bhg_id'], 0)) {
	        echo 'Tempestuous Moderator Status Removed.';
        } else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 44';
        }
    }
    elseif (isset($_REQUEST['bhg_id'])){
	    if ($_REQUEST['bhg_id'] == $hunter->GetID()){
	    	echo "You can't remove your own mod status.";
    	}
    } 
    else {
	    
	    echo "<b>Remove Moderator</b><br />";
	    
        $form = new Form($page);
        $form->StartSelect('Moderator:', 'bhg_id');
        foreach ($mods as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddSubmitButton('remove', 'Remove Moderator Status');
        $form->EndForm();
        
        hr();
        
        echo "<b>Edit Moderator Status</b><br />";
        
        $form = new Form($page);
        $form->StartSelect('Moderator:', 'bhg_id');
        foreach ($mods as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        
        $form->AddRadioButton('Mark As Active', 'status', 1);
        $form->AddRadioButton('Mark As Inactive', 'status', 2);
        
        $form->AddSubmitButton('edit', 'Change Moderator Status');
        $form->EndForm();
        
        hr();
        
        echo "<b>Declare New Moderator</b><br />";
        
        $form = new Form($page);
        $form->StartSelect('Members:', 'bhg_id');
        foreach ($members as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddSubmitButton('grant', 'Grant Moderator Status');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>