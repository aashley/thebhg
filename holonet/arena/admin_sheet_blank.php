<?php
function title() {
    return 'Administration :: General :: Insert Blank Sheet';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['aa'];
}

function output() {
    global $auth_data, $page, $roster;

    arena_header();
	
	$form = new Form($page);
	$form->StartSelect('Choose Division');
	foreach ($roster->GetDivisions() as $kabal){
		$form->AddOption($kabal->GetID(), $kabal->GetName());
	}
	$form->EndSelect();
	$form->AddSubmitButton('next', 'Choose Hunter');
	$form->EndForm();

    admin_footer($auth_data);
}
?>