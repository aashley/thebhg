<?php

function title() {
    return 'Administration :: Arena :: Add Old Match';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $hunter, $roster, $page, $auth_data;

    arena_header();

    $ladder = new Ladder();

    hr();

    $i = 1;
    $wtypes = $ladder->WeaponTypes();
    $locations = $ladder->Locations();
    $types = $ladder->Rules();
    
    if (isset($_REQUEST['submit'])){
	    
	    $control = new Control();

    	if ($_REQUEST['challengee'] != $_REQUEST['challenger']) {
            $local = explode("_", $_REQUEST['location']);

            $new = $control->OldMatch($_REQUEST['rules'], $local[0], $local[1], $_REQUEST['posts'],
            $_REQUEST['num_weapon'], $_REQUEST['challenger'], $_REQUEST['challengee'], $_REQUEST['type_weapon'], $_REQUEST['name'], 
            parse_date_box('start'), parse_date_box('end'), $_REQUEST['mbid']);
            
            if ($new){               
                $form = new Form('admin_arena_complete');
                
                $form->table->AddRow('Match Added Successfully.');
                $form->AddHidden('id', $control->LastInsert());
                $form->AddHidden('add_xp', '1');
	
			    $form->AddSubmitButton('', 'Complete Insert >>');
			    $form->EndForm();
                
            }
            else {
                echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 72';
            }
            
        } else {
	        echo "Please hit back and fix the hunters, as you have put the same hunter for both challenger and challengee.";
        }
	    
    } 
    else {
	    $form = new Form($page);
	    
	    $form->AddTextBox('Message Board ID', 'mbid', '', 10);
	    
	    $form->StartSelect('Challenger:', 'challenger');
	    hunter_dropdown($form);
	    $form->EndSelect();
	
	    $form->StartSelect('Challengee:', 'challengee');
	    hunter_dropdown($form);
	    $form->EndSelect();
	    
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
