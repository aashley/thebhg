<?php

function title() {
    return 'AMS Challenge Network :: Arena Tournament :: Signup';
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

    $at = new Tournament();

    if ($at->Signup($hunter->GetID())){
	    
	    echo "Signed up successfully.";
	    
    } else {
	    
	    echo $at->denied;
	    
    }

    arena_footer();

}
?>
