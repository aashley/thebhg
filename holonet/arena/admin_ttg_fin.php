<?php
function title() {
    return 'Administration :: Twilight Gauntlet :: Finish';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $roster;
    
    arena_header();

    $ttg = new TTG();
	$challenge = '';
    if (isset($_REQUEST['id'])){
		$challenge = new Challenge($_REQUEST['id']);
	}
    
    if (is_object($challenge)){
    
	    $match = $challenge->FinalMatch();
	    
	    if (isset($_REQUEST['submit'])) {
	
	        foreach($_REQUEST['person'] as $id=>$pid){
		        if ($_REQUEST['winner'] == $id){
			        $outcome = 2;
			        $ttg->InsertMember($pid, true);
		        } else {
			        $outcome = -5;
			        $ttg->DeleteMember($pid, true);
		        }
		        
	            if ($match->Complete($pid, $_REQUEST['xp'][$id], $_REQUEST['creds'][$id], $outcome)) {
		            
			            $sheet = new Sheet($roster->GetPerson($pid));
			        	$sheet->AddXP($_REQUEST['xp'][$id]);
		        	
	                echo 'Match Results Added for Contender!';
	            }
	            else {
	                echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 28';
	            }
	
	            echo "<br />";
	        }
	        
	        $challenge->Complete();	
		    
	    } else {
		    
		    $people = $match->GetContenders();

	        $form = new Form($page);
	        $form->AddHidden('id', $_REQUEST['id']);
	            
	        for ($i = 0; $i < count($people); $i++) {
	            $person = $people[$i];
	
	            $form->table->StartRow();
	            $form->table->AddHeader('Match Data for <b>'.$person->GetName().'</b>', 2);
	            $form->table->EndRow();
	
	            $form->AddHidden('person[' . $i . ']', $person->GetID());
	
	            $form->AddRadioButton('Winner', 'winner', $i);
	
	            $form->AddTextBox('Credits Earned:', 'creds[' . $i . ']');
	            $form->AddTextBox('Experience Points:', 'xp[' . $i . ']');
	        }
	
	        $form->AddSubmitButton('submit', 'Complete Match');
	        $form->EndForm();
		    
	    }
	    
    } else {
	    
	    $queue = $ttg->Finish();
	    
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
	            $table->AddCell('<a href="' . internal_link('admin_ttg_fin', array('id'=>$value->GetID())) . '">Finish Match</a>');	            
	            $table->EndRow();  
	        }
	        $table->EndTable();		
	    
	    } else {
	        
	        echo "No prepared challenges in the queue to finish.";
	        
	    }
	    
    } 

    admin_footer($auth_data);
}
?>