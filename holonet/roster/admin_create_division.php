<?php
function title() {
	return 'Administration :: Create Division';
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
		$div = $roster->CreateDivision($_REQUEST['name'], (int) $_REQUEST['category']);
		if ($div) {
			$div->SetMailingList($_REQUEST['list']);
			echo 'Division added successfully.';
		}
		else {
			echo 'Error adding division: ' . $roster->Error();
		}
	}
	else {
		$form = new Form($page);
		$form->AddTextBox('Name:', 'name');
		$form->StartSelect('Category:', 'category');
		foreach ($roster->GetDivisionCategories() as $dc) {
			$form->AddOption($dc->GetID(), $dc->GetName());
		}
		$form->EndSelect();
		$form->AddTextBox('Mailing List:', 'list', 'none');
		$form->AddSubmitButton('submit', 'Add Division');
		$form->EndForm();
	}

	admin_footer($auth_data);
}
?>
