<?php
function title() {
    return 'Administration';
}

function auth($person) {
    global $auth_data, $pleb, $roster;

    $auth_data = get_auth_data($person);
    $pleb = $roster->GetPerson($person->GetID());
    return $auth_data;
}

function output() {
    global $auth_data, $sheet_db, $page, $roster;

    arena_header();

    echo 'Welcome to Arena Management System Administration. To the right is a list of all the management options currently available to you.';

    admin_footer($auth_data);
}
?>
