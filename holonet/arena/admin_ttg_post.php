<?php
function title() {
    return 'Administration :: Twilight Gauntlet :: Post Final Match';
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
		    
            $match = $challenge->FinalMatch();
	            
            if ($match->StartMatch($_REQUEST['mbid'], false)){ 
            	echo 'Final match started.';
            	$challenge->FinalUp();
        	} else {
            	echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 20';
        	}    		                

	    } 
	    else {
		    
		    $challenger = $challenge->GetChallenger();
		    $challengee = new Person($challenge->FinalChallenger());
		    $match = $challenge->FinalMatch();
		    $adjunct = $arena->Adjunct();
		    
		    $location = $match->GetLocation();
		    $type = $match->GetType();
		    $weapon = $match->GetWeaponType();
		    
		    echo "<b>Subject Line</b>: ".$match->GetName()."<br /><br />";

	        echo "All the bets are off. This is for all the marbles. Generic pre-fight comment. Your final match for the Twilight Gauntlet is about to "
	        	."begin. One of you will be coming back as a Twilight Gauntlet Member. The other is going home crying. <br /><br /> Hunters, you are to"
	        	." come to ".$location->GetName()." for your final match. Bring ".$match->GetWeapons()." ".$weapon->GetWeapon()." weapons of your "
	        	."choice. Prepare for the most difficult battle of your lives, as you've both fought long and hard to get to this point. <br />"
	            ."The match limit is 2 posts, and the damage maximum is ".$type->GetRules()."<br /><br />[i]You have all the details of your match, and may begin any time. The match will end "
	            ."within the next 5 days. The winner of this match will be in the Twilight Gauntlet. The loser will be going home. Good luck.[/i]<br />";
	
	        hr();
	        
	        $form = new Form($page);
		    
		    if (isset($_REQUEST['id'])){
				$id = $_REQUEST['id'];
			}
		    
		    $form->AddHidden('id', $id);
		    $form->AddTextBox('Message Board ID', 'mbid', '', 10);
		    
		    $form->AddSubmitButton('submit', 'Process');
		    $form->EndForm();
	    }
	    
    } else {
	    
	    $queue = $ttg->NeedPosting();
	    
	    if (count($queue)){
		    
	        $table = new Table();
	        
	        $table->StartRow();
	        $table->AddHeader('Choose Final Twilight Gauntlet Match', 2);
	        $table->EndRow();
	        
	        $table->StartRow();
	        $table->AddHeader('Challenger');
	        $table->AddHeader('&nbsp;');
	        $table->EndRow();
	        foreach ($queue as $value) {
		        $person = $value->GetChallenger();
	            $table->StartRow();
	            $table->AddCell($person->GetName());
	            $table->AddCell('<a href="' . internal_link('admin_ttg_post', array('id'=>$value->GetID())) . '">Post Final Match</a>');	            
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