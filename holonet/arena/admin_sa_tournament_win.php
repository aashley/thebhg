<?php
function title() {
    return 'Administration :: Starfield Arena Tournament :: Declare Winner';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['star'];
}

function output() {
    global $arena, $hunter, $roster, $auth_data;

    arena_header();
    
    $at = new SATournament();

    if (isset($_REQUEST['id'])){
    
	    if ($at->Win($_REQUEST['id'], $at->CurrentRound(), $_REQUEST['bracket'])){
	        echo "Winner declared.";
	    } else {
	        NEC(205);
	    }
	    
	    $at->NewRound();
	    
    }
    
    admin_footer($auth_data);

}
?>
