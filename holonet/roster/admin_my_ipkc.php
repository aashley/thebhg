<?php
function title() {
	return 'Administration :: Edit My IPKC';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return true;
}

function output() {
	global $auth_data, $pleb, $page;

	roster_header();

	$bd = $pleb->GetBioData();
	if ($_REQUEST['submit']) {
		if ($bd->SetHomeWorld($_REQUEST['homeworld']) && $bd->SetAge($_REQUEST['age']) && $bd->SetSpecies($_REQUEST['species']) && $bd->SetHeight($_REQUEST['height']) && $bd->SetSex($_REQUEST['sex']) && $bd->SetImageURL($_REQUEST['imageurl'])) {
			echo 'IPKC saved.';
		}
		else {
			echo 'Error saving IPKC: ' . $bd->Error();
		}
	}
	else {
		$form = new Form($page);
		$form->AddTextBox('Homeworld:', 'homeworld', $bd->GetHomeWorld());
		$form->AddTextBox('Age:', 'age', $bd->GetAge());
		$form->AddTextBox('Species:', 'species', $bd->GetSpecies());
		$form->AddTextBox('Height:', 'height', $bd->GetHeight());
		$form->AddTextBox('Sex:', 'sex', $bd->GetSex());
		$form->AddTextBox('Face Image URL:', 'imageurl', $bd->GetImageURL(), 40);
		$form->AddSubmitButton('submit', 'Save IPKC');
		$form->EndForm();
	}
	
	admin_footer($auth_data);
}
?>
