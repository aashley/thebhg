<?php
function title() {
    return 'Administration :: IRC Arena Tournament :: Rounds';
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
    
    echo "Click on a Hunter's name to declare them the winner of the match. <br /><br /><h2>Be cautious when clicking, as it may cause a new round to be created.</h2>";
    
    hr();
    
    $at = new IRCTournament();

    $table = new Table('Round '.$at->CurrentRound(), true);
    
    $at->AdminRound($table);
    
    $table->EndTable();
    
    admin_footer($auth_data);

}
?>
