<?php
function title() {
    return 'Administration :: IRC Arena Tournament :: Randomize Brackets';
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

    if ($at->Randomize()){
        echo "Brackets randomized.";
    } else {
        NEC(113);
    }
    
    $at->NewRound();
    
    admin_footer($auth_data);

}
?>
