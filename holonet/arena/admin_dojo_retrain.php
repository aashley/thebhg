<?php
function title() {
    return 'Administration :: Dojo of Shadows :: Declare a Retraining';
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
    
    if (isset($_REQUEST['submit'])) {
		if ($arena->RemoveApproved($_REQUEST['hunter'])){
			echo 'Hunter declared as Dojo Learner.';
		} else {
			echo 'Error.';
		}
		hr();
    }
	    
    foreach ($arena->GetApproved() as $hunter){	
		$hunter = new Person($hunter);
		$hunters[$hunter->GetID()] = $hunter->GetName();
	}
	
	asort($hunters);
	
	$form = new Form($page);
	
	$form->AddSectionTitle('Select Hunter to Retrain');
	
	$form->StartSelect('Hunter', 'hunter');
	foreach ($hunters as $id=>$hunter){	
		$form->AddOption($id, $hunter);
    }
    $form->EndSelect();
    
    $form->AddSubmitButton('submit', 'Declare Retraining');
    $form->EndForm();

    admin_footer($auth_data);
}
?>