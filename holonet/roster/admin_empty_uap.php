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
			elseif ($action == 'return') {
				// Find out from whence they came and kick them
				// back there.
				$history = new PersonHistory($hunter->GetID());
				$history->Load(0, 0, array(3), 'DESC');
				$item = $history->GetItem();
				$hunter->SetDivision($item->GetItem(1));
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
				// Figure out when the hunter was transferred
				// to the UAP.
				$history = new PersonHistory($hunter->GetID());
				$history->Load(0, 0, array(3), 'DESC');
				$item = $history->GetItem();
				$kabal = $roster->GetDivision($item->GetItem(1));

				/* Work out a default action. For hunters
				 * transferred into the UAP within the last two
				 * weeks, the default is to leave them be. For
				 * hunters transferred before that, they go to
				 * retirees (if they have more than 1 million
				 * credits) or to disavowed (less than a mil).
				 */
				if ((time() - $item->GetDate()) < 1209600)
					$default = 'leave';
				elseif ($hunter->GetRankCredits() > 1000000)
					$default = 'retire';
				else
					$default = 'disavow';

				$label = $hunter->GetName().' (AWOLed '.date('j/n/Y', $item->GetDate()).')';
				$form->StartSelect($label, 'hunters[' . $hunter->GetID() . ']', $default);
				$form->AddOption('disavow', 'Transfer to Disavowed');
				$form->AddOption('retire', 'Transfer to Retirees');
				$form->AddOption('return', 'Return to '.$kabal->GetName());
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
