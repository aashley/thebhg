<?php
function title() {
    return 'Administration :: Twilight Gauntlet :: Queue';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['ttg'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;
    
    arena_header();

    $ttg = new TTG();
    
	$queue = $ttg->NeedChallengers();

	if (isset($_REQUEST['id'])){
		$challenge = new Challenge($_REQUEST['id']);
	}
	
    if (isset($_REQUEST['submit'])) {
	    
	    if (in_array($hunter->GetID(), $challenge->Opponents())){
		    echo "You are already listed as an active challenger for this match.";
	    } else {    
	        if ($challenge->ThrowDown($hunter->GetID())) {
		        echo 'You have taken this challenge.';
	        } else {
	            NEC(30);
	        } 
        }    
       
    }
    else {
	    
	    if (count($queue)){
			    
	        $form = new Form($page);
	        
	        $form->table->StartRow();
	        $form->table->AddHeader('Twilight Gauntlet Queue', 2);
	        $form->table->EndRow();
	        
	        $form->StartSelect('Challenger:', 'id');
	        foreach ($queue as $value) {
		        $person = $value->GetChallenger();
	            $form->AddOption($value->GetID(), $person->GetName());
	        }
	        $form->EndSelect();
	        $form->AddSubmitButton('submit', 'Take This Challenge');
	        $form->EndForm();		
        
        } else {
	        
	        echo "No pending challenges in the queue require opponents.";
	        
        }
        
    }

    admin_footer($auth_data);
}
?>