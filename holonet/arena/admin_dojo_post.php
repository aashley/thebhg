<?php
function title() {
    return 'Administration :: Dojo of Shadows :: Match Poster';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['dojo'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;

    arena_header();

    $ladder = new ladder();
    if (isset($_REQUEST['match_id'])){
    	$match = new Match($_REQUEST['match_id']);
	}

    if (isset($_REQUEST['next'])) {
	    
	    if ($match->IsDojo()){	    
	        $type = $match->GetType();
	        $location = $match->GetLocation();
	        $weapon = $match->GetWeaponType();
	        $challenger = $match->GetChallenger();
	        $challengee = $match->GetChallengee();
	
	        echo "<b>Subject Line</b>: ".$match->GetName()."<br /><br />";
	
			echo "Data You'll Need to Construct Opener:<br /><br />"
	        ."Location: ".$location->GetName()." <br />Number of Weapons: ".$match->GetWeapons()." <br />Type of Weapons: ".$weapon->GetWeapon().
	        " <br />Post Limit: ".$match->GetPosts()." <br />Rules: ".$type->GetRules();
	
	        hr();
	
	        $form = new Form($page);
	        $form->AddHidden('match_id', $_REQUEST['match_id']);
	        $form->table->StartRow();
	        $form->table->AddHeader('Enter Message Board ID', 2);
	        $form->table->EndRow();
	        $form->AddTextBox('Topic Number:', 'mbid');
	
	        $form->AddSubmitButton('submit', 'Complete Process');
	        $form->EndForm();
        } else {
	        echo 'Not a Dojo Match.';
        }

    }
    elseif (isset($_REQUEST['submit'])) {
	    
	    if ($match->IsDojo()){	 
	        if ($match->StartMatch($_REQUEST['mbid'])){
	            echo "Match process completed.";
	        } else {
	            NEC(71);
	        }
	    } else {
	        echo 'Not a Dojo Match.';
        }

    }
    else {	    
	    if (count($ladder->PendingDojo())){	    
	        $form = new Form($page);
	        $form->StartSelect('Match:', 'match_id');
	        foreach ($ladder->PendingDojo() as $value) {
	            $form->AddOption($value->GetID(), $value->GetName());
	        }
	        $form->EndSelect();
	        $form->AddSubmitButton('next', 'Next >>');
	        $form->EndForm();	        
        } else {	        
	        echo "No Pending Matches.";	        
        }
    }

    admin_footer($auth_data);
}
?>