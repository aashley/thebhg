<?php
function title() {
	return 'Administration :: Assign New Hunters';
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

	if ($_REQUEST['newbs']) {
		foreach ($_REQUEST['newbs'] as $id=>$kabal) {
			$trn = $roster->GetPerson($id);
			if ($kabal) {
				$trn->SetDivision($kabal);
			}
		}
		echo 'Assignment complete.';
	}
	else {
//		$cat = $roster->GetDivisionCategory(1);
//		$wings = $cat->GetDivisions();
    $wings = $roster->GetWings();
		$candidates = array();
		foreach ($wings as $wing) {
			$members = $wing->GetMembers();
			foreach ($members as $member) {
				$pos = $member->GetPosition();
				$history = $member->GetHistory();
				$history->Load(time() - (7 * 86400), time(), array(2));
				if ($history->Count() == 0 && $pos->GetID() != 18 && $pos->GetID() != 10) {
					$candidates[] = $member;
				}
			}
		}
		if (count($candidates)) {
			$kabals = $roster->GetKabals();
			foreach ($kabals as $kabal) {
				$kabal_totals[$kabal->GetID()] = $kabal->GetMemberCount();
			}
			$form = new Form($page);
			foreach ($candidates as $trn) {
				$div = $trn->GetDivision();
				asort($kabal_totals);
				reset($kabal_totals);
				$kabal = each($kabal_totals);
				$form->StartSelect($trn->GetName(), 'newbs[' . $trn->GetID() . ']', $kabal[0]);
				$kabal_totals[$kabal[0]]++;
				$form->AddOption(0, 'Leave in ' . $div->GetName());
				foreach ($kabals as $kabal) {
					$form->AddOption($kabal->GetID(), $kabal->GetName());
				}
				$form->EndSelect();
			}
			$form->AddSubmitButton('', 'Assign Hunters');
			$form->EndForm();
			hr();
			$table = new Table('Kabal Totals');
			$table->StartRow();
			$table->AddHeader('Kabal');
			$table->AddHeader('Before');
			$table->AddHeader('After');
			$table->EndRow();
			foreach ($kabals as $kabal) {
				$table->AddRow($kabal->GetName(), $kabal->GetMemberCount(), $kabal_totals[$kabal->GetID()]);
			}
			$table->EndTable();
		}
		else {
			echo 'There are no hunters waiting to be automatically assigned.';
		}
	}

	admin_footer($auth_data);
}
