<?php
include_once('roster/dropdowns.php');
function title() {
	return 'Administration :: Change Positions';
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
				$to = $roster->GetPosition($_REQUEST['to']);
			}
			$table = new Table();
			foreach ($_REQUEST['members'] as $member) {
				$table->StartRow();
				$pleb = $roster->GetPerson($member);
				if ($_REQUEST['to'] == -1) {
					$to = $roster->GetPosition($_REQUEST[$member]);
				}
				$table->AddCell('Attempting to alter ' . $pleb->GetName() . ' to the position of '. $to->GetName() . ':');
				if ($pleb->SetPosition($to->GetID())) {
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
				$to = $roster->GetPosition($_REQUEST['to']);
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
					$to = $roster->GetPosition($_REQUEST[$member]);
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
			$divs = $roster->GetPositions();
			foreach ($divs as $div) {
				$form->AddOption($div->GetID(), $div->GetName());
			}
			$form->EndSelect();
			foreach ($_REQUEST['members'] as $member) {
				$pleb = $roster->GetPerson($member);
        $pp = $pleb->GetPosition();
				$form->StartSelect('Change ' . $pleb->GetName() . ' to:',
                           $member,
                           $pp->GetID());
				$divs = $roster->GetPositions();
				foreach ($divs as $div) {
					$form->AddOption($div->GetID(), $div->GetName());
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
			$form->StartSelect('Choose the people to change the position of:', 'members[]', false, 10, true);
			$from = $roster->GetDivision($_REQUEST['from']);
			$plebs = $from->GetMembers();
			foreach ($plebs as $pleb) {
        $pos = $pleb->GetPosition();
				$form->AddOption($pleb->GetID(), $pos->GetName().' '.$pleb->GetName());
			}
			$form->EndSelect();
			$form->AddSubmitButton('', 'Next');
			$form->EndForm();
			break;
		default:
			$form = new Form($page);
			$form->AddHidden('stage', 'choosewho');
      $form->table->StartRow();
      $form->table->AddCell('<label for="from">Division to change positions of:</label>');
      $form->table->AddCell(DivisionDropDown('from',
                                             1,
                                             0,
                                             1,
                                             0,
                                             0,
                                             0));
      $form->table->EndRow();
//			$form->StartSelect('Division to select members from:', 'from');
//			$divs = $roster->GetDivisions();
//			foreach ($divs as $div) {
//				$form->AddOption($div->GetID(), $div->GetName());
//			}
//			$form->EndSelect();
			$form->AddSubmitButton('', 'Next');
			$form->EndForm();
	}
	
	admin_footer($auth_data);
}
?>
