<?php

function title() {
    return 'Administration :: Twilight Gauntlet :: Start Match';
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
    $ttg = new TTG();

    $challenge = '';
    if (isset($_REQUEST['id'])){
    	$challenge = new Challenge($_REQUEST['id']);
	}

    $i = 1;
    $wtypes = $ladder->WeaponTypes();
    $locations = $ladder->Locations();
    $types = $ladder->Rules();
    
    if (is_object($challenge)){
    
	    if (isset($_REQUEST['submit'])) {
		    
		    $control = new Control();
	
		    if ($challenge->CanStart()){
		    
		    	if ($_REQUEST['challengee'] != $_REQUEST['challenger']) {
		            $local = explode("_", $_REQUEST['location']);
		            
		            $new = $control->OldMatch($_REQUEST['rules'], $local[0], $local[1], $_REQUEST['posts'],
		            $_REQUEST['num_weapon'], $_REQUEST['challenger'], $_REQUEST['challengee'], $_REQUEST['type_weapon'], $_REQUEST['name'], 
		            time(), 0, $_REQUEST['mbid']);
		            
		            if ($new){              
			            
			            if ($challenge->StartChallenge($control->LastInsert())){ 
		                	echo 'New Match added.';
	                	} else {
		                	echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 14';
	                	}    		                
		            }
		            else {
		                echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 15';
		            }
		            
		        } else {
			        echo "Please hit back and fix the hunters, as you have put the same hunter for both challenger and challengee.";
		        }
	        } else {		        
		        echo "This match not ready to be posted.";		        
	        }
		    
	    } 
	    elseif ($_REQUEST['next']){
		    
		    $challenger = $challenge->GetChallenger();
		    $challengee = $challenge->Opponent($challenge->CurrentChallenger());
		    $overseer = $arena->Overseer();
		    
		    $name = 'Twilight Gauntlet Match: '.$challenger->GetName().' vs. '.$challengee->GetName();
		    
		    $local = explode("_", $_REQUEST['location']);
		    
		    $location = new Location($local[0], $local[1]);
		    $type = new Type($_REQUEST['rules']);
		    
		    echo "<b>Subject Line</b>: ".$name."<br /><br />";

	        echo $overseer->GetName().", the Guild's Overseer, stood at the enterance to ".$location->GetName()." as ".$challenger->GetName()
	        	." apporached.<br /><br />"
	            ."\"Hunter... so you think you have what it takes, do you? Humpf. I think not. Here is your chance to prove me wrong. Your first "
	            ."opponent should be arriving soon. I'm sure ".$challengee->GetName()." will enjoy taking you apart. None the less, I do wish you luck"
	            .". You will need it. I have hidden somewhere in here <b>[INSERT WEAPONS HERE]</b> for you to use. Find them, or perish trying.\"<br />"
	            ."<br />With that, ".$overseer->GetName()." turned and left. The match limit is 2 posts, and the damage maximum is ".$type->GetRules()
	            ."<br /><br />[i]You have all the details of your match, and may begin any time. The match will end within the next 5 days. Good luck.[/i]<br />";
	
	        hr();
	        
	        $form = new Form($page);
		    
		    $form->AddTextBox('Message Board ID', 'mbid', '', 10);
		    
		    $form->AddHidden('id', $_REQUEST['id']);
		    $form->AddHidden('challenger', $challenger->GetID());
		    $form->AddHidden('challengee', $challengee->GetID());
		    $form->AddHidden('name', $name);
		    $form->AddHidden('posts', 2);
			$form->AddHidden('num_weapon', $_REQUEST['num_weapon']);
		    $form->AddHidden('type_weapon', $_REQUEST['type_weapon']);
		    $form->AddHidden('location', $_REQUEST['location']);
		    $form->AddHidden('rules', $_REQUEST['rules']);
		    
		    $form->AddSubmitButton('submit', 'Process');
		    $form->EndForm();
    	}
	    else {
		    $form = new Form($page);
		
		    $form->AddHidden('id', $_REQUEST['id']);
		    
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
		
		    $form->AddSubmitButton('next', 'Next >>');
		    $form->EndForm();
	    }
	    
    } else {
	    
	    $queue = $ttg->Start();
	    
	    if (count($queue)){
		    
	        $table = new Table();
	        
	        $table->StartRow();
	        $table->AddHeader('Choose Twilight Gauntlet Match to Start', 2);
	        $table->EndRow();
	        
	        $table->StartRow();
	        $table->AddHeader('Challenger');
	        $table->AddHeader('&nbsp;');
	        $table->EndRow();
	        foreach ($queue as $value) {
		        $person = $value->GetChallenger();
	            $table->StartRow();
	            $table->AddCell($person->GetName());
	            $table->AddCell('<a href="' . internal_link('admin_ttg_start', array('id'=>$value->GetID())) . '">Start Match</a>');	            
	            $table->EndRow();  
	        }
	        $table->EndTable();		
	    
	    } else {
	        
	        echo "No prepared challenges in the queue to start.";
	        
	    }
	    
    }        

    admin_footer($auth_data);

}
?>
