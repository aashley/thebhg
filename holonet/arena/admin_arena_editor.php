<?php
function title() {
    return 'Administration :: Arena :: Match Editor';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;

    arena_header();

    $ladder = new Ladder();
    
    if (isset($_REQUEST['match_id'])){
	    $match = new Match($_REQUEST['match_id']);
	    $weapon_types = $ladder->WeaponTypes();
	    $locations = $ladder->Locations();
	    $types = $ladder->Rules();
    }

    if (isset($_REQUEST['next'])) {
        
        $type = $match->GetType();
        $weapon_type = $match->GetWeaponType();
        $location = $match->GetLocation();
        $i = 0;

        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Data');
        $form->table->AddHeader('Value');
        $form->table->EndRow();

        $form->AddTextBox('Message Board ID:', 'mb_id', $match->GetMatchID(), 10);
        $form->AddHidden('match_id', $_REQUEST['match_id']);

        $form->AddTextBox('Match Name:', 'name', $match->GetName(), 50);

        $form->StartSelect('Number of Weapons:', 'num_weapon', $match->GetWeapons());
        while ($i <= 5) {
            $form->AddOption($i, $i);
            $i++;
        }
        $form->EndSelect();

        $i = 3;

        $form->StartSelect('Weapon Type:', 'weapon_type', $weapon_type->GetID());
        foreach($weapon_types as $value) {
            $form->AddOption($value->GetID(), $value->GetWeapon());
        }
        $form->EndSelect();
        
        $form->StartSelect('Location:', 'location', $location->LocationMesh());
        foreach ($locations as $lid=>$lname) {
            $form->AddOption($lid, $lname);
        }
        $form->EndSelect();

        $form->StartSelect('Rules:', 'rules', $type->GetID());
        foreach($types as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();

        $form->StartSelect('Number of Posts:', 'posts', $match->GetPosts());
        while ($i <= 5) {
            $form->AddOption($i, $i);
            $i++;
        }
        $form->EndSelect();

        $form->AddSubmitButton('submit', 'Edit Match');
        $form->EndForm();
    }
    elseif (isset($_REQUEST['submit'])) {
        $local = explode("_", $_REQUEST['location']);
        $edit = $match->Edit($_REQUEST['name'], $local[0], $local[1], $_REQUEST['num_weapon'], $_REQUEST['weapon_type'], $_REQUEST['posts'], $_REQUEST['mb_id'], $_REQUEST['rules']);
        echo $edit;
    }
    else {
        $form = new Form($page);
        $form->StartSelect('Match:', 'match_id');
        foreach ($ladder->Unfinished() as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddSubmitButton('next', 'Next >>');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>