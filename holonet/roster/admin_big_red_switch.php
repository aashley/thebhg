<?php
function title() {
	return 'Administration :: Add Badges of Supremacy';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return ($auth_data['judicator'] || $auth_data['underlord']);
}

function output() {
	global $auth_data, $roster, $mb, $page;

	roster_header();

	if ($_REQUEST['kabal']) {
		mysql_query('UPDATE mb_awarded_medals SET medal=6 WHERE medal=5', $roster->roster_db);
		$kabal = $roster->GetDivision($_REQUEST['kabal']);
		$judicator = $roster->SearchPosition(10);
		if (count($judicator)) {
			$awarder = $judicator[0];
		}
		else {
			$awarder = $roster->GetPerson(1000);
		}
		foreach ($kabal->GetMembers() as $pleb) {
			$mb->AwardMedal($pleb, $awarder, 5, $kabal->GetName() . ' coming first in KAG ' . $_REQUEST['kag']);
		}
		echo 'Badges awarded.';
	}
	else {
		$form = new Form($page);
		$form->AddTextBox('KAG:', 'kag', '', 4);
		$form->StartSelect('Select Kabal:', 'kabal');
		foreach ($roster->GetKabals() as $kabal) {
			$form->AddOption($kabal->GetID(), $kabal->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Pull The Big Red Switch');
		$form->EndForm();
	}

	admin_footer($auth_data);
}
?>
