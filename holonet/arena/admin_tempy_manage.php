<?php
function title() {
    return 'Administration :: Tempestuous Group :: Edit My Signups';
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
    
    $pending = $tempy->InJury($hunter->GetID());

	if (isset($_REQUEST['id'])){
		$petition = new Petition($_REQUEST['id']);
	}
	
    if (isset($_REQUEST['remove'])) {
	    
	    if ($petition->Solidified()){
		    echo "Can not remove yourself as a juror, as the jury has been solidified by a Moderator.";
	    } else {
	        if ($petition->RemoveSignup($hunter->GetID())) {
		       echo 'Signup removed.';
	        } else {
	           NEC(46);
	        }
        }
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
	        $form->AddSubmitButton('remove', 'Remove me as a Juror');
	        $form->EndForm();
        
        } else {
	        
	        echo "Not on any jury.";
	        
        }
        
    }

    admin_footer($auth_data);
}
?>