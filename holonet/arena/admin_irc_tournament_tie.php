<?php
function title() {
    return 'Administration :: IRC Arena Tournament :: Tie';
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
    
	    if ($at->Tie($at->CurrentRound(), $_REQUEST['id'])){
	        echo "Tie declared.";
	    } else {
	        NEC(112);
	    }
	    
	    $at->NewRound();
	    
    }
	    
    admin_footer($auth_data);

}
?>
