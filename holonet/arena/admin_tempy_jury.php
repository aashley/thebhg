<?php
function title() {
    return 'Administration :: Tempestuous Group :: Jury Selection';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['tempy'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;
    
    arena_header();

    $tempy = new Tempy();
    
    $pending = $tempy->NeedJury();

    if (isset($_REQUEST['id'])){
		$petition = new Petition($_REQUEST['id']);
	}
	
    if (isset($_REQUEST['signup'])) {
	    
	    if (!in_array($hunter->GetID(), $petition->Jurors())) {
	    
	        if ($petition->Signup($hunter->GetID())) {
		        echo 'Signed up as Juror';
	        } else {
	            NEC(47);
	        }
	        
        } else {
	        
	        echo "You are already marked as a juror for this applicant.";
	        
        }
    } 
    elseif (isset($_REQUEST['view'])) {    
	    
	    echo "Reason Supplied: ";
	    echo $petition->GetReason();
	    
	    hr();
	    
	    $form = new Form($page);
			        
        $form->table->StartRow();
        $form->table->AddHeader('Applications', 2);
        $form->table->EndRow();
        
        $form->AddHidden('id', $_REQUEST['id']);
        
        $form->AddSubmitButton('signup', 'Sign Up For Jury');
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
        
        } else {
	        
	        echo "No pending applicaitons.";
	        
        }
        
    }

    admin_footer($auth_data);
}
?>