<?php
function title() {
    return 'Administration :: Twilight Gauntlet :: End Challenge';
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

    $ttg = new TTG();
    
	$queue = $ttg->Running();

	if (isset($_REQUEST['id'])){
		$challenge = new Challenge($_REQUEST['id']);
	}
	
    if (isset($_REQUEST['submit'])) {
	       
        if ($challenge->EndGauntlet()) {
	        echo 'Gauntlet Challenge Marked as Completed. Please continue the admin to finish the match.';
	        
	        hr();
        
	        $form = new Form('admin_arena_complete');
	        $match = $challenge->GetMatch();
	        $form->AddHidden('id', $match->GetID());
	        $form->AddSubmitButton('next', 'Continue to End Match >>');
		    $form->EndForm();
        } else {        
            NEC(29);
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
	        $form->AddSubmitButton('submit', 'End This Challenge');
	        $form->EndForm();		
        
        } else {
	        
	        echo "No pending challenges in the queue can be completed.";
	        
        }
        
    }

    admin_footer($auth_data);
}
?>