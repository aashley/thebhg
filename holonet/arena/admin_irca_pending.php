<?php
function title() {
    return 'Administration :: IRC Arena :: Ungraded Matches';
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

    $irca = new IRCA();
    $pending = $irca->Ungraded();

    if (count($pending)) {
        $table = new Table('Ungraded Matches', true);
        $table->StartRow();
        $table->AddHeader('Challenger');
        $table->AddHeader('Challengee');
        $table->AddHeader('Match Type');
        $table->AddHeader('Location');
        $table->AddHeader('Weapon Type');
        $table->AddHeader('Num. of Weapons');
        $table->AddHeader('Actions');
        $table->AddHeader('&nbsp;', 2);
        $table->EndRow();
        foreach($pending as $value) {
            $type = $value->GetType();
            $combatants = $value->GetContenders();
            $weapon = $value->GetWeaponType();
            $location = $value->GetLocation();
            $challenger = $combatants[0];
            $challengee = $combatants[1];

            $table->StartRow();
            $table->AddCell('<a href="' . internal_link('hunter', array('id'=>$challenger->GetID()), 'roster') . '">' . $challenger->GetName() . '</a>');
            $table->AddCell('<a href="' . internal_link('hunter', array('id'=>$challengee->GetID()), 'roster') . '">' . $challengee->GetName() . '</a>');
            $table->AddCell($type->GetName());
            $table->AddCell($location->GetName());
            $table->AddCell($weapon->GetWeapon());
            $table->AddCell($value->GetWeapons());
            $table->AddCell($value->GetActions());
            $table->AddCell('<a href="' . internal_link('admin_irca_remove', array('id'=>$value->GetID())) . '">Remove</a>');
            $table->AddCell('<a href="' . internal_link('admin_irca_complete', array('id'=>$value->GetID())) . '">Complete</a>');
            $table->EndRow();
        }
        $table->EndTable();
    }
    else {
        echo 'No ungraded matches.';
    }

    admin_footer($auth_data);
}
?>