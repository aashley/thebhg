<?php
function title() {
	return 'Administration :: Edit Division';
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
		$div = $roster->GetDivision($_REQUEST['id']);
		$div->SetName($_REQUEST['name']);
		$div->SetMailingList($_REQUEST['list']);
		echo 'Division saved successfully.';
	}
	elseif ($_REQUEST['id']) {
		$div = $roster->GetDivision($_REQUEST['id']);
		$form = new Form($page);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextBox('Name:', 'name', $div->GetName());
		$form->AddTextBox('Mailing List:', 'list', $div->GetMailingList());
		$form->AddSubmitButton('submit', 'Save Division');
		$form->EndForm();
	}
	else {
		$form = new Form($page);
		$form->StartSelect('Division:', 'id');
		foreach ($roster->GetDivisions('name') as $div) {
			$form->AddOption($div->GetID(), $div->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit Division');
		$form->EndForm();
	}

	admin_footer($auth_data);
}
?>
