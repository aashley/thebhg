<?php
function title() {
	return 'Administration :: Delete Division';
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

	if ($_REQUEST['id']) {
		$div = $roster->GetDivision($_REQUEST['id']);
		$div->Delete();
		echo 'Division deleted.';
	}
	else {
		$form = new Form($page);
		$form->StartSelect('Division:', 'id');
		foreach ($roster->GetDivisions('name') as $div) {
			$form->AddOption($div->GetID(), $div->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Delete Division');
		$form->EndForm();
	}

	admin_footer($auth_data);
}
?>
