<?php
function title() {
    return 'Administration :: Tempestuous Group :: Eject Member';
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
    $members = $tempy->BaseMembers();

    if (isset($_REQUEST['submit'])) {
        if ($tempy->DeleteMember($_REQUEST['bhg_id'])) {
	        echo 'Tempestuous Member Deleted.';
        } else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 45';
        }
    }
    else {
	    
	    echo "Please note! This form will totally remove someone from the Tempy List. The only way for them to again become a member is for them to "
	    	."undergo the Jury Review process. <b>Do not use this form unless you are ejecting a member from Tempestuous!</b>";
	    	
	    hr();
	    
        $form = new Form($page);
        $form->StartSelect('Member:', 'bhg_id');
        foreach ($members as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddSubmitButton('submit', 'Eject Member');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>