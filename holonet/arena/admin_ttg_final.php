<?php
function title() {
    return 'Administration :: Twilight Gauntlet :: Choose Final Opponent';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['fin_ttg'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;
    
    arena_header();

    $ladder = new Ladder();
    $ttg = new TTG();

    $i = 1;
    $wtypes = $ladder->WeaponTypes();
    $locations = $ladder->Locations();
    $types = $ladder->Rules();
    
    $challenge = $ttg->FinalMatch($hunter->GetID());
    
    if ($challenge->GetID()){
	    
	    if (isset($_REQUEST['submit'])) {
		    
		    $control = new Control();
	
		    if ($challenge->CanStart()){
		    
		    	if ($_REQUEST['challengee'] != $hunter->GetID()+1) {
		            $local = explode("_", $_REQUEST['location']);
		            $person = new Person($_REQUEST['challengee']);
		            $name = 'Twilight Gauntlet: Final Match: '.$hunter->GetName().' vs. '.$person->GetID();
		            
		            $new = $control->OldMatch($_REQUEST['rules'], $local[0], $local[1], $_REQUEST['posts'],
		            $_REQUEST['num_weapon'], $hunter->GetID(), $_REQUEST['challengee'], $_REQUEST['type_weapon'], $_REQUEST['name'], 
		            time(), 0, $_REQUEST['mbid']);
		            
		            if ($new){              
			            
			            if ($challenge->FinalChallenge($control->LastInsert(), $_REQUEST['challengee'])){ 
		                	echo 'Final challenge made.';
	                	} else {
		                	echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 26';
	                	}    		                
		            }
		            else {
		                echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 27';
		            }
		            
		        } else {
			        echo "Please hit back and fix the hunters, as you have put the same hunter for both challenger and challengee.";
		        }
	        } else {		        
		        echo "This match not ready to be posted.";		        
	        }
    	}
	    else {
		    $form = new Form($page);
		
		    if (isset($_REQUEST['id'])){
				$id = $_REQUEST['id'];
			}
		    
		    $form->AddHidden('id', $id);
		    $form->AddHidden('posts', 2);
		    
		    $form->StartSelect('Opponent:', 'challengee');
		    foreach($ttg->GetMembers() as $value) {
		        $form->AddOption($value->GetID(), $value->GetName());
		    }
		    $form->EndSelect();
		    
		    $form->StartSelect('Number of Weapons:', 'num_weapon');
		    while ($i <= 5) {
		        $form->AddOption($i, $i);
		        $i++;
		    }
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
		
		    $form->AddSubmitButton('submit', 'Make Final Challenge');
		    $form->EndForm();
	    }
	    
    } else {
	    
	    echo "You can not choose any final match.";
	    
    } 

    admin_footer($auth_data);
}
?>