<?php
function title() {
    return 'Administration :: Tempestuous Group :: Pending Petitions';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['tempy_mod'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;
    
    arena_header();

    $tempy = new Tempy();
    
    $pending = $tempy->Pending();

	if (isset($_REQUEST['id'])){
		$petition = new Petition($_REQUEST['id']);
	}
	
    if (isset($_REQUEST['approve'])) {
        if ($petition->Approve($hunter->GetID())) {
	        echo 'Petition Approved.';
        } else {
            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 41';
        }
    } 
    elseif (isset($_REQUEST['edit'])) {
	    
	    if (isset($_REQUEST['deny'])) {
		    if ($petition->Deny()) {
		        echo 'Petition Denied.';
	        } else {
	            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 42';
	        }
        } else {
	        if ($petition->Remove()) {
		        echo 'Petition Removed.';
	        } else {
	            echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 43';
	        }
        } 
    } 
    elseif (isset($_REQUEST['view'])) {    
	    
	    echo "Reason Supplied: ";
	    echo $petition->GetReason();
	    
	    hr();
	    
	    $form = new Form($page);
			        
        $form->table->StartRow();
        $form->table->AddHeader('Process', 2);
        $form->table->EndRow();
        
        $form->AddRadioButton('Approve', 'approve', 1);
        $form->AddRadioButton('Deny', 'approve', 0);
        $form->AddHidden('deny', 1);
        $form->AddHidden('edit', 1);
        $form->AddHidden('id', $_REQUEST['id']);
        
        $form->AddSubmitButton('submit', 'Process Petition');
        $form->EndForm();
	       
    }
    else {
	    
	    if (count($pending)){
			    
	        $form = new Form($page);
	        
	        $form->table->StartRow();
	        $form->table->AddHeader('Applications', 2);
	        $form->table->EndRow();
	        
	        $form->StartSelect('Applicant:', 'id');
	        foreach ($pending as $value) {
		        $person = $value->GetApplicant();
	            $form->AddOption($value->GetID(), $person->GetName());
	        }
	        $form->EndSelect();
	        $form->AddSubmitButton('view', 'View Reason');
	        $form->EndForm();
        
        	hr();
        
	        $form = new Form($page);
			        
	        $form->table->StartRow();
	        $form->table->AddHeader('Applications', 2);
	        $form->table->EndRow();
	        
	        $form->StartSelect('Applicant:', 'id');
	        foreach ($pending as $value) {
		        $person = $value->GetApplicant();
	            $form->AddOption($value->GetID(), $person->GetName());
	        }
	        $form->EndSelect();
	        
	        $form->AddRadioButton('Deny', 'deny', 1);
	        $form->AddRadioButton('Remove (Deny without notification)', 'deny', 0);
	        
	        $form->AddSubmitButton('edit', 'Remove Petition');
	        $form->EndForm();
        
        } else {
	        
	        echo "No pending petitions.";
	        
        }
        
    }

    admin_footer($auth_data);
}
?>