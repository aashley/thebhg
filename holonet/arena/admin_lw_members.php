<?php
function title() {
    return 'Administration :: Lone Wolf Missions :: Edit Members';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['solo'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;
    
    arena_header();

    $lw = new LW_Solo();
    
	if (isset($_REQUEST['grant'])) {
        if ($lw->NewMember($_REQUEST['bhg_id'])) {
	        echo 'Lone Wolf Added.';
        } else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 60';
        }
    } 
    elseif (isset($_REQUEST['remove'])) {
        if ($lw->DeleteMember($_REQUEST['bhg_id'])) {
	        echo 'Lone Wolf Removed.';
        } else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 61';
        }
    }
    else {
	    
	    echo "<b>Remove Member</b><br />";
	    
        $form = new Form($page);
        $form->StartSelect('Members:', 'bhg_id');
        foreach ($lw->Members() as $val) {
	        $value = new Person($val);
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddSubmitButton('remove', 'Remove Member Status');
        $form->EndForm();
        
        hr();
        
        echo "<b>Declare New Member</b><br />";
        
        $form = new Form($page);
        $form->StartSelect('Hunters:', 'bhg_id');
    		hunter_dropdown($form);
        $form->EndSelect();
        $form->AddSubmitButton('grant', 'Grant Member Status');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>