<?php
function title() {
    return 'AMS Challenge Network :: Arena :: Accept Challenge';
}

function auth($person) {
    global $hunter, $roster, $auth_data;
    
    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    $div = $person->GetDivision();
    return ($div->GetID() != 0 && $div->GetID() != 16);
}

function output() {
    global $arena, $hunter, $roster;

    arena_header();

    if (isset($_REQUEST['id'])) {
    
	    $match = new Match($_REQUEST['id']);
	
	    if ($match->Accept()){
	        echo "Match accepted! Notification has been sent to the Overseer and Adjunct.";
	    } else {
	        echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 1';
	    }	   
	    
    } 

    arena_footer();

}
?>
