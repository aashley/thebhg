<?php
function title() {
    return 'Administration :: Twilight Gauntlet :: Progress Round';
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
			            
			            if ($challenge->Progress($challenge->NextRound(), $control->LastInsert())){ 
				            
				            $match = $challenge->GetMatch();
				            
				            $form = new Form('admin_arena_complete');
                
			                $form->table->AddRow('Match Added Successfully.');
			                $form->AddHidden('id', $match->GetID());
			                $form->AddHidden('add_xp', '1');
				
						    $form->AddSubmitButton('', 'Complete Insert >>');
						    $form->EndForm();
				            
		                	echo 'New Match added.';
	                	} else {
		                	echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 21';
	                	}    		                
		            }
		            else {
		                echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 22';
		            }
		            
		        } else {
			        echo "Please hit back and fix the hunters, as you have put the same hunter for both challenger and challengee.";
		        }
	        } else {		        
		        echo "This match not ready to be posted.";		        
	        }
		    
	    } 
	    elseif (isset($_REQUEST['next'])){
		    
		    $challenger = $challenge->GetChallenger();
		    $challengee = $challenge->Opponent($challenge->CurrentChallenger()+1);
		    $adjunct = $arena->Adjunct();
		    
		    $name = 'Twilight Gauntlet Match: '.$challenger->GetName().' vs. '.$challengee->GetName();
		    
		    $local = explode("_", $_REQUEST['location']);
		    
		    $location = new Location($local[0], $local[1]);
		    $type = new Type($_REQUEST['rules']);
		    
		    echo "<b>Subject Line</b>: ".$name."<br /><br />";

	        echo "You clutch the scroll given to you by ".$adjunct->GetName().", the Guild's Adjunct. After completing your last Twilight Gauntlet "
	        	."match, your feeling pretty confident, and you head to ".$location->GetName()." for your next match.<br /><br />"
	            ."\"Hunter... I must say, I am amazed. You managed to solve the last challenge that was given to you. You may have some promise afterall. However "
	            ."it can all end here if you should faulter against ".$challengee->GetName().". Once again, good luck. You will, again, need it. As with last time"
	            .", I have hidden somewhere here <b>[INSERT WEAPONS HERE]</b> for you to use. You best find them quickly before your opponent finds you.\"<br />"
	            ."<br />The words of ".$adjunct->GetName()." echoed in your mind as you focused for your next challenge. <br /> The match limit is 2 posts, and "
	            ."the damage maximum is ".$type->GetRules()."<br /><br />[i]You have all the details of your match, and may begin any time. The match will end "
	            ."within the next 5 days. Good luck.[/i]<br />";
	
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
		
		    if (isset($_REQUEST['id'])){
				$id = $_REQUEST['id'];
			}
		    
		    $form->AddHidden('id', $id);
		    
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
	    
	    $queue = $ttg->Ready();
	    
	    if (count($queue)){
		    
	        $table = new Table();
	        
	        $table->StartRow();
	        $table->AddHeader('Choose Twilight Gauntlet Match to Progress', 2);
	        $table->EndRow();
	        
	        $table->StartRow();
	        $table->AddHeader('Challenger');
	        $table->AddHeader('&nbsp;');
	        $table->EndRow();
	        foreach ($queue as $value) {
		        $person = $value->GetChallenger();
	            $table->StartRow();
	            $table->AddCell($person->GetName());
	            $table->AddCell('<a href="' . internal_link('admin_ttg_next', array('id'=>$value->GetID())) . '">Progress Match</a>');	            
	            $table->EndRow();  
	        }
	        $table->EndTable();		
	    
	    } else {
	        
	        echo "No prepared challenges in the queue.";
	        
	    }
	    
    } 

    admin_footer($auth_data);
}
?>