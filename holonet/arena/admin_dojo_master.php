<?php
function title() {
    return 'Administration :: Dojo of Shadows :: Assign a New Master';
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
    
    if (isset($_REQUEST['submit'])) {
		if ($ladder->NewMaster($_REQUEST['bhg_id'])) {
            echo 'New Master Declared.';
        }
        else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 104';
        }
    }
    else {
        $form = new Form($page);
        $form->StartSelect('Hunter:', 'bhg_id');
        hunter_dropdown($form);
        $form->EndSelect();
        $form->AddSubmitButton('submit', 'Make New Dojo Master');
        $form->EndForm(); 
    }

    admin_footer($auth_data);
}
?>