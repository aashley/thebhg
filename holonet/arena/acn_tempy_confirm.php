<?php

function title() {
    return 'AMS Challenge Network :: Tempestuous Group :: Petition for Enterance';
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

    $tempy = new Tempy();

    if ($tempy->CanPetition($hunter->GetID())) {

	    if (isset($_REQUEST['reason'])){
	    
            if ($tempy->Petition($hunter->GetID(), $_REQUEST['reason'])){
                echo "Petition sent successfully.";
            }
            else {
                echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 11';
            }
            
        }
    }
    else {
        echo 'You\'ve already got a petition pending.';
    }

    arena_footer();

}
?>
