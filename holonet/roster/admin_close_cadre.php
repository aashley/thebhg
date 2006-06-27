<?php
$auth_data = array();
$cadre = null;
$pleb = null;

function title() {
  return 'Administration :: Close Cadre';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return $auth_data['underlord'];
}

function output() {
  global $auth_data, $cadre, $roster, $pleb, $page;

  roster_header();

  if ($_REQUEST['submit']) {
		$cadre = $roster->GetCadre($_REQUEST['id']);
		if ($cadre->Close())
			echo 'Cadre closed.';
		else
			echo 'Error: '. $cadre->Error();
	}
	else {
		$form = new Form($page);
		$form->StartSelect('Cadre:', 'id');
		foreach ($roster->GetCadres() as $div) {
			$form->AddOption($div->GetID(), $div->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Delete Cadre');
		$form->EndForm();
	}

  admin_footer($auth_data);

}

?>
