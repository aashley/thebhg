<?php
function title() {
    return 'Administration :: IRC Arena Tournament :: Delete Signup';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $hunter, $roster, $auth_data;

    arena_header();
    
    $at = new IRCTournament();

    if (isset($_REQUEST['id'])){
    
	    if ($at->DeleteSignup($_REQUEST['id'])){
	        echo "Signup Deleted.";
	    } else {
	        echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 116';
	    }
	    
    }
    
    admin_footer($auth_data);

}
?>
