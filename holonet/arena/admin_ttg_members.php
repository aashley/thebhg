<?php
function title() {
    return 'Administration :: Twilight Gauntlet :: Edit Members';
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

    $ttg = new TTG();
    
	if (isset($_REQUEST['bhg_id'])){ 
		if ($_REQUEST['bhg_id'] == $hunter->GetID()){
		    echo "You can't edit the moderator status of the OV/AJ.";
		    return false;
	    }
    } 
    
    if (isset($_REQUEST['grant'])) {
        if ($ttg->InsertMember($_REQUEST['bhg_id'])) {
	        echo 'Gauntlet Member Added.';
        } else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 23';
        }
    } 
    elseif (isset($_REQUEST['remove'])) {
        if ($ttg->DeleteMember($_REQUEST['bhg_id'])) {
	        echo 'Gauntlet Member Removed.';
        } else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 24';
        }
    }
    else {
	    
	    echo "<b>Remove Member</b><br />";
	    
        $form = new Form($page);
        $form->StartSelect('Members:', 'bhg_id');
        foreach ($ttg->GetMembers() as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddSubmitButton('remove', 'Remove Member Status');
        $form->EndForm();
        
        if ($ttg->CanAdd()){
	        hr();
	        
	        echo "<b>Declare New Member</b><br />";
	        
	        $form = new Form($page);
	        $form->StartSelect('Hunters:', 'bhg_id');
	    		hunter_dropdown($form);
	        $form->EndSelect();
	        $form->AddSubmitButton('grant', 'Grant Member Status');
	        $form->EndForm();
        }
    }

    admin_footer($auth_data);
}
?>