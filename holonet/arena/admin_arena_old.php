<?php

function title() {
    return 'Administration :: Arena :: Add Old Match';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['arena'];
}

function output() {
    global $arena, $hunter, $roster, $page, $auth_data, $sheet;

    arena_header();

    $ladder = new Ladder();

    $i = 1;
    $wtypes = $ladder->WeaponTypes();
    $locations = $ladder->Locations();
    $types = $ladder->Rules();
    
    if (isset($_REQUEST['submit'])){
	    
	    $control = new Control();

    	if ($_REQUEST['person1'] != $_REQUEST['person2']) {
            $local = explode("_", $_REQUEST['location']);

            $new = $control->OldMatch($_REQUEST['rules'], $local[0], $local[1], $_REQUEST['posts'],
            $_REQUEST['num_weapon'], $_REQUEST['person1'], $_REQUEST['person2'], $_REQUEST['type_weapon'], $_REQUEST['name'], 
            parse_date_box('start'), parse_date_box('end'), $_REQUEST['mbid'], $_REQUEST['dojo']);
            
            echo 'Match Added Successfully.';
            
            if ($new){               
                $form = new Form('admin_arena_complete');
                
                $form->AddHidden('id', $control->LastInsert());
                $form->table->StartRow();
                $form->table->AddCell('Use XP Awarding', 2);
                $form->table->EndRow();
                $form->AddRadioButton('No', 'add_xp', 0, true);
                $form->AddRadioButton('Yes', 'add_xp', '1');
	
			    $form->AddSubmitButton('', 'Complete Insert >>');
			    $form->EndForm();
                
            }
            else {
                NEC(72);
            }
            
        } else {
	        echo "Please hit back and fix the hunters, as you have put the same hunter for both challenger and challengee.";
        }
	    
    } 
    else {

	    $form = new Form($page);
	    
	    $form->AddTextBox('Message Board ID', 'mbid', '', 10);
	
	    for ($i = 1; $i <= 2; $i++){
		    $form->AddTextBox('BHG ID', 'person'.$i, '', 5);
		}
	    
	    $form->AddTextBox('Match Name', 'name', '', 50);
	
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
	
	    $form->AddCheckBox('Is Dojo Match:', 'dojo', 1);
	    
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
	    
	    $form->AddDateBox('Match Start', 'start');
	    $form->AddDateBox('Match End', 'end');
	
	    $form->AddSubmitButton('submit', 'Challenge');
	    $form->EndForm();
    }

    admin_footer($auth_data);

}
?>
