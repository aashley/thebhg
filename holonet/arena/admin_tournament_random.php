<?php
function title() {
    return 'Administration :: Arena Tournament :: Randomize Brackets';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['arena'];
}

function output() {
    global $arena, $hunter, $roster, $auth_data;

    arena_header();
    
    $at = new Tournament();

    if ($at->Randomize()){
        echo "Brackets randomized.";
    } else {
        NEC(33);
    }
    
    $at->NewRound();
    
    admin_footer($auth_data);

}
?>
