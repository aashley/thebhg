<?php
function title() {
    return 'Administration :: Arena Tournament :: Add Wildcard';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['aide'];
}

function output() {
    global $arena, $hunter, $roster, $auth_data, $page, $sheet, $roster;

    arena_header();
    
    $at = new Tournament();

    if (isset($_REQUEST['submit'])) {
	    if ($at->Wildcard($_REQUEST['bhg_id'])){
	        echo "Wildcard added.";
	    } else {
	        echo 'Error';
	    }
    } else {
	    $form = new Form($page);
        include_once 'search.php';
        $form->AddSubmitButton('submit', 'Add Wildcard');
        $form->EndForm();
	}
    
    admin_footer($auth_data);

}
?>
