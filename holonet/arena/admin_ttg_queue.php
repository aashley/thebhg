<?php
function title() {
    return 'Administration :: Twilight Gauntlet :: Queue';
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
    
	$queue = $ttg->Queue();

    if (isset($_REQUEST['id'])){
    	$challenge = new Challenge($_REQUEST['id']);
	}
	
    if (isset($_REQUEST['approve'])) {
        if ($challenge->Approve()) {
	        echo 'Gauntlet Challenge Approved.';
        } else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 17';
        }
    } 
    elseif (isset($_REQUEST['edit'])) {
	    
	    if (isset($_REQUEST['deny'])) {
		    if ($challenge->Deny()) {
		        echo 'Gauntlet Challenge Denied.';
	        } else {
	            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 18';
	        }
        } else {
	        if ($challenge->Remove()) {
		        echo 'Gauntlet Challenge Removed.';
	        } else {
	            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 19';
	        }
        }        
    }
    else {
	    
	    if ($ttg->Pending()){
	    
		    if ($ttg->OpenChallenge()){
			    
			    echo "Can not activate a new challenge at the moment.";	
			    		    
		    } else {
			    
		        $form = new Form($page);
		        
		        $form->table->StartRow();
		        $form->table->AddHeader('Twilight Gauntlet Queue', 2);
		        $form->table->EndRow();
		        
		        $form->table->AddRow('Unapproved Challenges in the Queue', $ttg->Pending());
		        
		        $form->StartSelect('Challenger:', 'id');
		        foreach ($queue as $value) {
			        $person = $value->GetChallenger();
		            $form->AddOption($value->GetID(), $person->GetName());
		        }
		        $form->EndSelect();
		        $form->AddSubmitButton('approve', 'Approve This Challenge');
		        $form->EndForm();
		        
	        }
        
        hr();
        
	        $form = new Form($page);
			        
	        $form->table->StartRow();
	        $form->table->AddHeader('Twilight Gauntlet Queue', 2);
	        $form->table->EndRow();
	        
	        $form->table->AddRow('Unapproved Challenges in the Queue', $ttg->Pending());
	        
	        $form->StartSelect('Challengers:', 'id');
	        foreach ($queue as $value) {
		        $person = $value->GetChallenger();
	            $form->AddOption($value->GetID(), 'Challenger: '.$person->GetName());
	        }
	        $form->EndSelect();
	        
	        $form->AddRadioButton('Deny', 'deny', 1);
	        $form->AddRadioButton('Remove (Deny without notification)', 'deny', 0);
	        
	        $form->AddSubmitButton('edit', 'Remove Challenge from the Queue');
	        $form->EndForm();
        
        } else {
	        
	        echo "No pending challenges in the queue.";
	        
        }
        
    }

    admin_footer($auth_data);
}
?>