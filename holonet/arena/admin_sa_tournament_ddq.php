<?php
function title() {
    return 'Administration :: Starfield Arena Tournament :: Double Disqualification';
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
    
	    if ($at->DoubleDQ($at->CurrentRound(), $_REQUEST['id'])){
	        echo "DDQ declared.";
	    } else {
	        NEC(203);
	    }
	    
	    $at->NewRound();
	    
    }
    
    admin_footer($auth_data);

}
?>
