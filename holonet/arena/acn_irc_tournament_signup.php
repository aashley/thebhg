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
    global $arena, $hunter, $roster, $page, $auth_data;

    arena_header();

    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';

    echo "By clicking the below link, you will enter yourself into the current roster for the next IRC Arena Tournament. Once you are entered, you can not"
    	." be removed, so please, <b>do not click on the link which says 'Sign me up' if you do not intend to sign up</b>.";
    
    hr();

    echo '<a href="' . internal_link('acn_irc_tournament_confirm') . '">Sign me up!</a>';

    arena_footer();

}
?>
