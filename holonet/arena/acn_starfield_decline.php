<?php
function title() {
    return 'AMS Challenge Network :: Starfield Arena :: Decline Challenge';
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

    if (isset($_REQUEST['id'])){
    
	    $match = new StarfieldMatch($_REQUEST['id']);
	
	    if ($match->Decline()){
	        echo "Match declined!";
	    } else {
	        NEC(10);
	    }
	    
    }

    arena_footer();

}
?>
