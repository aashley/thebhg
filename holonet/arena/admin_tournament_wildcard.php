<?php
function title() {
    return 'Administration :: Arena Tournament :: Add Wildcard';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $hunter, $roster, $auth_data, $page;

    arena_header();
    
    $at = new Tournament();

    if (isset($_REQUEST['submit'])) {
	    if ($at->Wildcard($_REQUEST['bhg_id'])){
	        echo "Wildcard added.";
	    } else {
	        echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 106';
	    }
    } else {
	    $form = new Form($page);
        $form->StartSelect('Hunter:', 'bhg_id');
        hunter_dropdown($form);
        $form->EndSelect();
        $form->AddSubmitButton('submit', 'Add Wildcard');
        $form->EndForm();
	}
    
    admin_footer($auth_data);

}
?>
