<?php
function title() {
    return 'Administration :: Arena Tournament :: Randomize Brackets';
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
    
    $at = new Tournament();

    if ($at->Randomize()){
        echo "Brackets randomized.";
    } else {
        echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 33';
    }
    
    $at->NewRound();
    
    admin_footer($auth_data);

}
?>
