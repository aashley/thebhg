<?php

function title() {
    return 'AMS Challenge Network :: Twilight Gauntlet :: Challenge the Gauntlet';
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

    $ttg = new TTG();

    if ($ttg->CanChallenge($hunter->GetID())) {

            if ($ttg->Challenge($hunter->GetID())){
                echo "Challenge made successfully.";
            }
            else {
                echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 12';
            }
        }
        else {
            echo 'You already have a pending Gauntlet match in the queue. Please be patient, as it will eventually be your turn.';
        }

    arena_footer();

}
?>
