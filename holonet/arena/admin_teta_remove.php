<?php
function title() {
    return 'Administration :: General :: Remove Teta\'s Knives';
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
		if ($arena->RemoveTeta($_REQUEST['hunter'])){
			echo 'Hunter got their pointy friends taken from them.';
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
	
	$form->AddSectionTitle('Select Hunter to Piss Off');
	
	$form->StartSelect('Hunter', 'hunter');
	foreach ($hunters as $id=>$hunter){	
		$form->AddOption($id, $hunter);
    }
    $form->EndSelect();
    
    $form->AddSubmitButton('submit', 'Steal Cutlery');
    $form->EndForm();

    admin_footer($auth_data);
}
?>