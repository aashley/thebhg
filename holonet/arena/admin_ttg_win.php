<?php

function title() {
    return 'Administration :: Twilight Gauntlet :: Declare Winner';
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

    $ttg = new TTG();

    $challenge = '';
    if (isset($_REQUEST['id'])){
    	$challenge = new Challenge($_REQUEST['id']);
	}
    
    if (is_object($challenge)){
 
        if ($challenge->DeclareWin()){ 
	        
	        $match = $challenge->GetMatch();
				            
            $form = new Form('admin_arena_complete');

            $form->table->AddRow('Match Added Successfully.');
            $form->AddHidden('id', $match->GetID());
            $form->AddHidden('add_xp', '1');

		    $form->AddSubmitButton('', 'Complete Insert >>');
		    $form->EndForm();
	        
        	echo 'Winner declared.';
    	} else {
        	NEC(13);
    	}    	                
	    
    } else {
	    
	    $queue = $ttg->UnsetWinners();
	    
	    if (count($queue)){
		    
	        $table = new Table();
	        
	        $table->StartRow();
	        $table->AddHeader('Choose Twilight Gauntlet Match to Complete', 2);
	        $table->EndRow();
	        
	        $table->StartRow();
	        $table->AddHeader('Challenger');
	        $table->AddHeader('&nbsp;');
	        $table->EndRow();
	        foreach ($queue as $value) {
		        $person = $value->GetChallenger();
	            $table->StartRow();
	            $table->AddCell($person->GetName());
	            $table->AddCell('<a href="' . internal_link('admin_ttg_win', array('id'=>$value->GetID())) . '">Declare Winner</a>');	            
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
