<?php
function title() {
    return 'Administration :: General :: Award Teta\'s Knives';
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
		if ($arena->AddTeta($_REQUEST['hunter'])){
			echo 'Hunter awarded Teta\'s Knives.';
		} else {
			echo 'Error.';
		}
		hr();
    }
	    
    foreach ($arena->GetDojo() as $hunter){	
		$hunter = new Person($hunter);
		$hunters[$hunter->GetID()] = $hunter->GetName();
	}
	
	asort($hunters);
	
	$form = new Form($page);
	
	$form->AddSectionTitle('Manage Cutlery');
	
	$form->StartSelect('Hunter', 'hunter');
	foreach ($hunters as $id=>$hunter){	
		$form->AddOption($id, $hunter);
    }
    $form->EndSelect();
    
    $form->AddSubmitButton('submit', 'Award Sharp Item');
    $form->EndForm();

    admin_footer($auth_data);
}
?>