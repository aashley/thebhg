<?php

function title() {
    return 'AMS Challenge Network :: Challenges';
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

    $ladder = new Ladder();
    $starfield = new Starfield();
	$ttg = new TTG();
    
    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';
    
    hr();
    
    echo '<h5>The Arena</h5>';

    $challenges = $ladder->Pending($hunter->GetID());

    if (count($challenges)) {
        $table = new Table('Pending Challenges', true);
        $table->StartRow();
        $table->AddHeader('Challenger');
        $table->AddHeader('Match Type');
        $table->AddHeader('Location');
        $table->AddHeader('Weapon Type');
        $table->AddHeader('Num. of Weapons');
        $table->AddHeader('Posts');
        if (in_array($hunter->GetID(), $ttg->Members())){
	        $table->AddHeader('Gauntlet Match');
        }
        $table->AddHeader('&nbsp;', 2);
        $table->EndRow();
        foreach($challenges as $value) {
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
            if (in_array($hunter->GetID(), $ttg->Members())){
		        $table->AddCell($gauntlet);
	        }
            $table->AddCell('<a href="' . internal_link('acn_arena_accept', array('id'=>$value->GetID())) . '">Accept</a>');
            $table->AddCell('<a href="' . internal_link('acn_arena_decline', array('id'=>$value->GetID())) . '">Decline</a>');
            $table->EndRow();
        }
        $table->EndTable();
    }
    else {
        echo 'You have no challenges pending.';
    }

    hr();

    echo '<h5>Starfield Arena</h5>';

    $challenges = $starfield->Pending($hunter->GetID());

    if (count($challenges)) {
        $table = new Table('Pending Challenges', true);
        $table->StartRow();
        $table->AddHeader('Challenger');
        $table->AddHeader('Challenger Ship');
        $table->AddHeader('Your Ship');
        $table->AddHeader('Location');
        $table->AddHeader('Match Type');
        $table->AddHeader('Settings');
        $table->AddHeader('Restrictions');
        $table->AddHeader('Posts');
        $table->AddHeader('&nbsp;', 2);
        $table->EndRow();
        foreach($challenges as $value) {
            $type = $value->GetType();
            $challenger = $value->GetChallenger();
            $challengee = $value->GetChallengee();
            $location = $value->GetLocation();
            $setting = $value->GetSettings();
            $table->StartRow();
            $table->AddCell('<a href="' . internal_link('hunter', array('id'=>$challenger->GetID()), 'roster') . '">' . $challenger->GetName() . '</a>');
            $table->AddCell($challenger->GetShipLink());
            $table->AddCell($challengee->GetShipLink());
            if ($value->HasLocation()){
                $table->AddCell($location->GetName());
            } else {
                $table->AddCell($value->GetLocation());
            }
            $table->AddCell($type->GetName());
            $table->AddCell($setting->GetName());
            $table->AddCell($value->WriteRestrictions());
            $table->AddCell($value->GetPosts());
            $table->AddCell('<a href="' . internal_link('acn_starfield_accept', array('id'=>$value->GetID())) . '">Accept</a>');
            $table->AddCell('<a href="' . internal_link('acn_starfield_decline', array('id'=>$value->GetID())) . '">Decline</a>');
            $table->EndRow();
        }
        $table->EndTable();
    }
    else {
        echo 'You have no challenges pending.';
    }

    arena_footer();

}
?>
