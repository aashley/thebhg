<?php
function title() {
    return 'Administration :: Arena :: Recent Challenges';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $contract;

    arena_header();

    $ladder = new Ladder();
    $recent = $ladder->Recent();

    $table = new Table('Pending Challenges', true);
    $table->StartRow();
    $table->AddHeader('Challenger');
    $table->AddHeader('Match Type');
    $table->AddHeader('Location');
    $table->AddHeader('Weapon Type');
    $table->AddHeader('Num. of Weapons');
    $table->AddHeader('Posts');
    $table->AddHeader('Gauntlet Match');
    $table->AddHeader('&nbsp;', 2);
    $table->EndRow();
    foreach($recent as $value) {
        $type = $value->GetType();
        $challenger = $value->GetChallenger();
        $weapon = $value->GetWeaponType();
        $location = $value->GetLocation();
        $gauntlet = 'No';
        
        if ($value->IsTTG()){
            $gauntlet = 'Yes';
        }
        
        $table->StartRow();
        $table->AddCell('<a href="' . internal_link('hunter', array('id'=>$challenger->GetID()), 'roster') . '">' . $challenger->GetName() . '</a>');
        $table->AddCell($type->GetName());
        $table->AddCell($location->GetName());
        $table->AddCell($weapon->GetWeapon());
        $table->AddCell($value->GetWeapons());
        $table->AddCell($value->GetPosts());
	    $table->AddCell($gauntlet);
        $table->AddCell('<a href="' . internal_link('acn_arena_accept', array('id'=>$value->GetID())) . '">Accept</a>');
        $table->AddCell('<a href="' . internal_link('acn_arena_decline', array('id'=>$value->GetID())) . '">Decline</a>');
        $table->EndRow();
    }
    $table->EndTable();

    admin_footer($auth_data);
}
?>