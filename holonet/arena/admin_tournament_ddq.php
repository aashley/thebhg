<?php
function title() {
    return 'Administration :: Arena Tournament :: Double Disqualification';
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
    
    $at = new Tournament();

    if (isset($_REQUEST['id'])){
    
	    if ($at->DoubleDQ($at->CurrentRound(), $_REQUEST['id'])){
	        echo "DDQ declared.";
	    } else {
	        echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 35';
	    }
	    
	    $at->NewRound();
	    
    }
    
    admin_footer($auth_data);

}
?>
