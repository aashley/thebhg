<?php

function title() {
    return 'AMS Challenge Network :: IRC Arena Tournament :: Signup';
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

    $at = new IRCTournament();

    if ($at->Signup($hunter->GetID())){
	    
	    echo "Signed up successfully.";
	    
    } else {
	    
	    echo "Error signing up. If you have already signed up, then why you're here, I don't know. But please go away. Otherwise, contact the OV/AJ ASAP.";
	    
    }

    arena_footer();

}
?>
