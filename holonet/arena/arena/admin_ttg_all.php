<?php
function title() {
    return 'Administration :: Twilight Gauntlet :: Edit Signups';
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
    
	$queue = $ttg->AllPending();
	    
    if (count($queue)){
		    
	    echo "To remove a challenger, click on their name.";
	    
	    hr();
	    
        $table = new Table();
        
        $table->StartRow();
        $table->AddHeader('All Twilight Gauntlet Challenges', 5);
        $table->EndRow();
        
        $table->StartRow();
        $table->AddHeader('Challenger');
        $table->AddHeader('Status');
        $table->AddHeader('Challenger 1');
        $table->AddHeader('Challenger 2');
        $table->AddHeader('Challenger 3');
        $table->EndRow();
        foreach ($queue as $value) {
	        $person = $value->GetChallenger();
            $table->StartRow();
            $table->AddCell($person->GetName());
            $table->AddCell($value->GetStatus());
            
            foreach ($value->Opponents() as $id=>$person){
	            $match = $value->GetMatch($id);
	            if ($person == 0){
		            $add = "No Challenger";
	            } elseif ($match->GetID()){
	            	$add = "Match Started";
            	}
            	else {
		            $pleb = new Person($person);
		            $add = '<a href="' . internal_link('admin_ttg_remove', array('id'=>$value->GetID(), 'bhg_id'=>$pleb->GetID())) 
		            		. '">' . $pleb->GetName() . '</a>';
	            }
	            
	            $table->AddCell($add);
            }
            
            $table->EndRow();
            
        }
        $table->EndTable();		
    
    } else {
        
        echo "No editable challenges in the queue.";
        
    }

    admin_footer($auth_data);
}
?>