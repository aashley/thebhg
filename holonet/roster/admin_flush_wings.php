<?php
function title() {
	return 'Administration :: Flush Wings';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return $auth_data['underlord'];
}

function output() {
	global $auth_data, $pleb, $page, $roster;

	roster_header();

	if ($_REQUEST['trainees']) {
		foreach ($_REQUEST['trainees'] as $id=>$action) {
			$trn = $roster->GetPerson($id);
			if ($action == 'delete') {
				$trn->Delete();
			}
		}
		echo 'Delete complete.';
	}
	else {
		$fodder = $roster->SearchPosition(18);
		$candidates = array();
		foreach ($fodder as $cannon) {
			if ($cannon->GetLastUpdate() < (time() - (28 * 86400))) {
				$candidates[] = $cannon;
			}
		}
		if (count($candidates)) {
			$form = new Form($page);
			foreach ($candidates as $trn) {
				$form->StartSelect($trn->GetName() . ' (Last Update: ' . date('j/n/Y', $trn->GetLastUpdate()) . ')', 'trainees[' . $trn->GetID() . ']', 'delete');
				$form->AddOption('delete', 'Delete');
				$form->AddOption('keep', 'Keep');
				$form->EndSelect();
			}
			$form->AddSubmitButton('', 'Yank Chain');
			$form->EndForm();
		}
		else {
			echo 'There are no trainees waiting to be flushed.';
		}
	}

	admin_footer($auth_data);
}
