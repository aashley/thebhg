<?php
function title() {
    return 'Administration :: Twilight Gauntlet :: My Current Challenges';
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
    
	$queue = $ttg->MyChallenges($hunter->GetID());
	    
    if (count($queue)){
		    
        $table = new Table();
        
        $table->StartRow();
        $table->AddHeader('My Twilight Gauntlet Challenges', 3);
        $table->EndRow();
        
        $table->StartRow();
        $table->AddHeader('Challenger');
        $table->AddHeader('Status');
        $table->AddHeader('&nbsp');
        $table->EndRow();
        foreach ($queue as $value) {
	        $person = $value->GetChallenger();
	        if ($value->CanRemove()){
		        $candeny = '<a href="' . internal_link('admin_ttg_remove', array('id'=>$value->GetID(), 'bhg_id'=>$hunter->GetID())) . '">Remove Myself</a>';
	        }
            $table->AddRow($person->GetName(), $value->GetStatus(), $candeny);
        }
        $table->EndTable();		
    
    } else {
        
        echo "You are currently not signed up for any challenges in the queue.";
        
    }

    admin_footer($auth_data);
}
?>