<?php
function title() {
	return 'Administration :: Edit Division Category';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return $auth_data['sysadmin'];
}

function output() {
	global $auth_data, $pleb, $page, $roster;

	roster_header();

	if ($_REQUEST['submit']) {
		$dc = $roster->GetDivisionCategory($_REQUEST['id']);
		$dc->SetName($_REQUEST['name']);
		echo 'Division category saved successfully.';
	}
	elseif ($_REQUEST['id']) {
		$dc = $roster->GetDivisionCategory($_REQUEST['id']);
		$form = new Form($page);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextBox('Name:', 'name', $dc->GetName());
		$form->AddSubmitButton('submit', 'Save Division Category');
		$form->EndForm();
	}
	else {
		$form = new Form($page);
		$form->StartSelect('Division:', 'id');
		foreach ($roster->GetDivisionCategories() as $dc) {
			$form->AddOption($dc->GetID(), $dc->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit Division Category');
		$form->EndForm();
	}

	admin_footer($auth_data);
}
?>
