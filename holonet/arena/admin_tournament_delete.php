<?php
function title() {
    return 'Administration :: Arena Tournament :: Delete Signup';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['aide'];
}

function output() {
    global $arena, $hunter, $roster, $auth_data;

    arena_header();
    
    $at = new Tournament();

    if (isset($_REQUEST['id'])){
    
	    if ($at->DeleteSignup($_REQUEST['id'])){
	        echo "Signup Deleted.";
	    } else {
	        echo 'Error';
	    }
	    
    }
    
    admin_footer($auth_data);

}
?>
