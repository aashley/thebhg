<?php
function title() {
    return 'Administration :: Starfield Arena Tournament :: Randomize Brackets';
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

    if ($at->Randomize()){
        echo "Brackets randomized.";
    } else {
        NEC(199);
    }
    
    $at->NewRound();
    
    admin_footer($auth_data);

}
?>
