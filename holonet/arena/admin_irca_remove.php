<?php
function title() {
    return 'Administration :: IRC Arena :: Remove Match';
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
    
    if (isset($_REQUEST['id'])){
	    $match = new IRCAMatch($_REQUEST['id']);
	
	    if ($match->Remove()){
	        echo "Match removed!";
	    } else {
	        echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 68';
	    }
    }
    
    admin_footer($auth_data);

}
?>
