<?php
function title() {
    return 'Administration :: Arena :: Pending Challenges';
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
    $pending = $ladder->Pending();

    if (count($pending)) {
        $table = new Table('Pending Challenges', true);
	    $table->StartRow();
	    $table->AddHeader('Challenger');
	    $table->AddHeader('Challengee');
	    $table->AddHeader('Match Type');
	    $table->AddHeader('Location');
	    $table->AddHeader('Weapon Type');
	    $table->AddHeader('Num. of Weapons');
	    $table->AddHeader('Posts');
	    //$table->AddHeader('Gauntlet Match');
	    $table->AddHeader('&nbsp;', 2);
	    $table->EndRow();
	    foreach($pending as $value) {
	        $type = $value->GetType();
	        $challenger = $value->GetChallenger();
	        $challengee = $value->GetChallengee();
	        $weapon = $value->GetWeaponType();
	        $location = $value->GetLocation();
	        /*$gauntlet = 'No';
	        
	        if ($value->IsTTG()){
	            $gauntlet = 'Yes';
	        }*/
	        
	        $table->StartRow();
	        $table->AddCell('<a href="' . internal_link('atn_general', array('id'=>$challenger->GetID())) . '">' . $challenger->GetName() . '</a>');
	        $table->AddCell('<a href="' . internal_link('atn_general', array('id'=>$challengee->GetID())) . '">' . $challengee->GetName() . '</a>');
	        $table->AddCell($type->GetName());
	        $table->AddCell($location->GetName());
	        $table->AddCell($weapon->GetWeapon());
	        $table->AddCell($value->GetWeapons());
	        $table->AddCell($value->GetPosts());
		    //$table->AddCell($gauntlet);
	        $table->AddCell('<a href="' . internal_link('admin_arena_complete', array('id'=>$value->GetID())) . '">Complete</a>');
	        $table->AddCell('<a href="' . internal_link('admin_arena_remove', array('id'=>$value->GetID())) . '">Remove</a>');
	        $table->EndRow();
	    }
	    $table->EndTable();
    }
    else {
        echo 'No challenges pending.';
    }

    admin_footer($auth_data);
}
?>