<?php

function title() {
    return 'Administration :: IRC Arena :: Add Ladder Faceoff';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['irca'];
}

function output() {
    global $arena, $hunter, $roster, $page, $auth_data, $sheet;

    arena_header();

    $ladder = new IRCA();

    $ladder_proper = new IRCADetails();
    $keys = array_keys($ladder_proper->Build());
    $person = array();
    
    for ($i = 0; $i < 2; $i++){
	    $value = $keys[$i];
	    $person[$i] = $roster->GetPerson($value);
    }
    
    $person1 = $person[0];
    $person2 = $person[1];
    
    $i = 1;
    $wtypes = $ladder->WeaponTypes();
    $locations = $ladder->Locations();
    $types = $ladder->Rules();
	    
    $control = new IRCAControl();

	if ($_REQUEST['submit']) {
        $local = explode("_", $_REQUEST['location']);

        $vs = $person1->GetName().' vs '.$person2->GetName();
        
        $new = $control->OldMatch($_REQUEST['rules'], $local[0], $local[1], $_REQUEST['num_weapon'], $person1->GetID(), $person2->GetID(), 
        		$_REQUEST['type_weapon'], $_REQUEST['posts'], 'IRCA Ladder Faceoff: '.$vs, 0, 0, 0, 0);
        
        if ($new){               
            echo 'Match Added Successfully.';                
        }
        else {
            NEC(211);
        }
	    
    } 
    else {
	    $form = new Form($page);
	
	    $form->StartSelect('Number of Weapons:', 'num_weapon');
	    while ($i <= 5) {
	        $form->AddOption($i, $i);
	        $i++;
	    }
	    $i = 3;
	    $form->EndSelect();
	    $form->StartSelect('Weapon Type:', 'type_weapon');
	    foreach($wtypes as $value) {
	        $form->AddOption($value->GetID(), $value->GetWeapon());
	    }
	    $form->EndSelect();
	
	    $form->StartSelect('Location:', 'location', $locations[array_rand($locations)]);
	    foreach ($locations as $lid=>$lname) {
	        $form->AddOption($lid, $lname);
	    }
	    $form->EndSelect();
	    
	    $form->StartSelect('Rules:', 'rules');
	    foreach($types as $value) {
	        $form->AddOption($value->GetID(), $value->GetName());
	    }
	    $form->EndSelect();
	    
	    $form->StartSelect('Number of Posts:', 'posts');
	    while ($i <= 5) {
	        $form->AddOption($i, $i);
	        $i++;
	    }
	    $form->EndSelect();
	
	    $form->AddSubmitButton('submit', 'Set Challenge');
	    $form->EndForm();
    }

    admin_footer($auth_data);

}
?>
