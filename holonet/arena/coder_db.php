<?php
function title() {
    return 'Coder Resources :: System';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['coder'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $contract;

    arena_header();

    $coder = new Coder();
    
    $core = new Core();
    
    $shell = new Shell(5, 'arena_ladder_match');
    
    echo $shell->GetValue('match_id');
    
    $solo = $shell->BuildShell(6, 'arena_solo_contracts');
    
    echo '<br />'.$shell->GetValue('match_id');
    echo '<br />'.$solo->GetValue('mb_id');

    admin_footer($auth_data);
}
?>