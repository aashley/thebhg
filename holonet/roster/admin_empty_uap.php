<?php
function title() {
	return 'Administration :: Empty Unassigned Pool';
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

	if ($_REQUEST['hunters']) {
		foreach ($_REQUEST['hunters'] as $id=>$action) {
			$hunter = $roster->GetPerson($id);
			if ($action == 'retire') {
				$hunter->SetPosition(19);
				$hunter->SetDivision(12);
			}
			elseif ($action == 'disavow') {
				$hunter->Delete();
			}
		}
		echo 'Unassigned Pool emptied.';
	}
	else {
		$uap = $roster->GetDivision(11);
		$hunters = $uap->GetMembers();
		if (count($hunters)) {
			$form = new Form($page);
			foreach ($hunters as $hunter) {
				$form->StartSelect($hunter->GetName(), 'hunters[' . $hunter->GetID() . ']', $hunter->GetRankCredits() > 1000000 ? 'retire' : 'disavow');
				$form->AddOption('disavow', 'Transfer to Disavowed');
				$form->AddOption('retire', 'Transfer to Retirees');
				$form->AddOption('leave', 'Leave in UAP');
				$form->EndSelect();
			}
			$form->AddSubmitButton('', 'Empty UAP');
			$form->EndForm();
		}
		else {
			echo 'There are no hunters in the Unassigned Pool.';
		}
	}

	admin_footer($auth_data);
}
