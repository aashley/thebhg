<?php
function title() {
	return 'Administration :: Create New Rank';
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
		if ($roster->CreateRank($_REQUEST['name'], $_REQUEST['abbrev'], $_REQUEST['credits'], $_REQUEST['aa'] == 'on', $_REQUEST['unlim'] == 'on', $_REQUEST['manual'] == 'on', $roster->GetRank($_REQUEST['after']))) {
			echo 'Rank created successfully.';
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
		$form->AddTextBox('Credits Required:', 'credits');
		$form->AddCheckBox('Available to Trainees:', 'aa', 'on');
		$form->AddCheckBox('Unlimited Credits:', 'unlim', 'on');
		$form->AddCheckBox('Manually Set:', 'manual', 'on');
		$form->StartSelect('Rank to insert after:', 'after');
		foreach ($roster->GetRanks() as $rank) {
			$form->AddOption($rank->GetID(), $rank->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Create Rank');
		$form->EndForm();
	}

	admin_footer($auth_data);
}
?>
