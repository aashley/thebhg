<?php
function title() {
	return 'Administration :: Create New Position';
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
		if ($roster->CreatePosition($_REQUEST['name'], $_REQUEST['abbrev'], $_REQUEST['income'], $_REQUEST['trainee'] == 'on', $_REQUEST['sdiv'], $_REQUEST['alias'] == 'on', $roster->GetPosition($_REQUEST['after']))) {
			echo 'Position created successfully.';
			echo $roster->Error();
		}
		else {
			echo $roster->Error();
		}
	}
	else {
		$form = new Form($page);
		$form->AddTextBox('Name:', 'name');
		$form->AddTextBox('Abbreviation:', 'abbrev');
		$form->AddTextBox('Monthly Income:', 'income', '0');
		$form->AddCheckBox('Available to Trainees:', 'trainee', 'on');
		$form->AddTextBox('Special Division:', 'sdiv');
		$form->AddCheckBox('Create E-mail Alias:', 'alias', 'on');
		$form->StartSelect('Position to insert after:', 'after');
		foreach ($roster->GetPositions() as $pos) {
			$form->AddOption($pos->GetID(), $pos->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Create Position');
		$form->EndForm();
	}

	admin_footer($auth_data);
}
?>
