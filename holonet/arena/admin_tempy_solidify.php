<?php
function title() {
    return 'Administration :: Tempestuous Group :: Solidify Jury';
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
    
    $pending = $tempy->FullJury($hunter);

	if (isset($_REQUEST['id'])){
		$petition = new Petition($_REQUEST['id']);
	}
	
    if (isset($_REQUEST['submit'])) {
        if ($petition->SolidifyJury()) {
	        echo 'Jury Solidified.';
        } else {
            NEC(38);
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
	        $form->AddSubmitButton('submit', 'Solidify');
	        $form->EndForm();
        
        } else {
	        
	        echo "No pending petitions with complete jury that you can process.";
	        
        }
        
    }

    admin_footer($auth_data);
}
?>