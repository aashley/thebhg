<?php
function title() {
    return 'Administration :: IRC Arena Tournament :: Declare Winner';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['irc'];
}

function output() {
    global $arena, $hunter, $roster, $auth_data;

    arena_header();
    
    $at = new IRCTournament();

    if (isset($_REQUEST['id'])){
    
	    if ($at->Win($_REQUEST['id'], $at->CurrentRound(), $_REQUEST['bracket'])){
	        echo "Winner declared.";
	    } else {
	        NEC(110);
	    }
	    
	    $at->NewRound();
	    
    }
    
    admin_footer($auth_data);

}
?>
