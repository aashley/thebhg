<?php
function title() {
	return 'Administration :: Change Ranks';
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

	switch ($_REQUEST['stage']) {
		case 'transfer':
			if ($_REQUEST['to'] != -1) {
				$to = $roster->GetRank($_REQUEST['to']);
			}
			$table = new Table();
			foreach ($_REQUEST['members'] as $member) {
				$table->StartRow();
				$pleb = $roster->GetPerson($member);
				if ($_REQUEST['to'] == -1) {
					$to = $roster->GetRank($_REQUEST[$member]);
				}
				$table->AddCell('Attempting to alter ' . $pleb->GetName() . ' to the position of '. $to->GetName() . ':');
				if ($pleb->SetRank($to->GetID())) {
					$table->AddCell('OK');
				}
				else {
					$table->AddCell('Error: ' . $pleb->Error());
				}
				$table->EndRow();
			}
			$table->EndTable();
			break;
		case 'confirm':
			$form = new Form($page);
			$form->AddHidden('stage', 'transfer');
			$form->AddHidden('to', $_REQUEST['to']);
			if ($_REQUEST['to'] != -1) {
				$to = $roster->GetRank($_REQUEST['to']);
			}
			$form->table->StartRow();
			$form->table->AddCell('Do you wish to make the following changes:', 1, count($_REQUEST['members']));
			$first = true;
			foreach ($_REQUEST['members'] as $member) {
				if ($first) {
					$first = false;
				}
				else {
					$form->table->StartRow();
				}
				$pleb = $roster->GetPerson($member);
				$form->AddHidden('members[]', $member);
				if ($_REQUEST['to'] == -1) {
					$form->AddHidden($member, $_REQUEST[$member]);
					$to = $roster->GetRank($_REQUEST[$member]);
				}
				$form->table->AddCell($pleb->GetName() . ' to ' . $to->GetName());
				$form->table->EndRow();
			}
			$form->AddSubmitButton('', 'Yes');
			$form->EndForm();
			break;
		case 'chooseto':
			$form = new Form($page);
			$form->AddHidden('stage', 'confirm');
			foreach ($_REQUEST['members'] as $member) {
				$form->AddHidden('members[]', $member);
			}
			$form->StartSelect('Change everyone to:', 'to');
			$form->AddOption('-1', 'N/A, individual selections');
			$ranks = $roster->GetRanks();
			foreach ($ranks as $rank) {
				$form->AddOption($rank->GetID(), $rank->GetName());
			}
			$form->EndSelect();
			foreach ($_REQUEST['members'] as $member) {
				$pleb = $roster->GetPerson($member);
				$form->StartSelect('Change ' . $pleb->GetName() . ' to:', $member);
				$ranks = $roster->GetRanks();
				foreach ($ranks as $rank) {
					$form->AddOption($rank->GetID(), $rank->GetName());
				}
				$form->EndSelect();
			}
			$form->AddSubmitButton('', 'Next');
			$form->EndForm();
			break;
		case 'choosewho':
			$form = new Form($page);
			$form->AddHidden('stage', 'chooseto');
			$form->AddHidden('from', $_REQUEST['from']);
			$form->StartSelect('Choose the people to change the rank of:', 'members[]', false, 10, true);
			$from = $roster->GetDivision($_REQUEST['from']);
			$plebs = $from->GetMembers();
			foreach ($plebs as $pleb) {
				$form->AddOption($pleb->GetID(), $pleb->GetName());
			}
			$form->EndSelect();
			$form->AddSubmitButton('', 'Next');
			$form->EndForm();
			break;
		default:
			$form = new Form($page);
			$form->AddHidden('stage', 'choosewho');
			$form->StartSelect('Division to select members from:', 'from');
			$divs = $roster->GetDivisions();
			foreach ($divs as $div) {
				$form->AddOption($div->GetID(), $div->GetName());
			}
			$form->EndSelect();
			$form->AddSubmitButton('', 'Next');
			$form->EndForm();
	}
	
	admin_footer($auth_data);
}
?>
