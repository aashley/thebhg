<?php
include_once('roster/dropdowns.php');
function title() {
	return 'Administration :: Transfer Members';
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
				$to = $roster->GetDivision($_REQUEST['to']);
			}
			$table = new Table();
			foreach ($_REQUEST['members'] as $member) {
				$table->StartRow();
				$pleb = $roster->GetPerson($member);
				if ($_REQUEST['to'] == -1) {
					$to = $roster->GetDivision($_REQUEST[$member]);
				}
				$table->AddCell('Attempting to transfer ' . $pleb->GetName() . ' to '. $to->GetName() . ':');
				if ($pleb->SetDivision($to->GetID())) {
					if ($to->GetID() == 12) {
						$pleb->SetPosition(19);
					}
          if ($_REQUEST['from'] == 12 || $_REQUEST['from'] == 16) {
            $pleb->SetPosition(14);
          }
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
			$form->AddHidden('from', $_REQUEST['from']);
			if ($_REQUEST['to'] != -1) {
				$to = $roster->GetDivision($_REQUEST['to']);
			}
			$form->table->StartRow();
			$form->table->AddCell('Do you wish to make the following transfers:', 1, count($_REQUEST['members']));
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
					$to = $roster->GetDivision($_REQUEST[$member]);
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
			$form->AddHidden('from', $_REQUEST['from']);
			foreach ($_REQUEST['members'] as $member) {
				$form->AddHidden('members[]', $member);
			}
      $form->table->StartRow();
      $form->table->AddCell('<label for="to">Move everyone to:</label>');
      $form->table->AddCell(DivisionDropDown('to',
                                             1,
                                             0,
                                             1,
                                             0,
                                             0,
                                             0,
                                             array('N/A, individual selections' => -1)));
      $form->table->EndRow();

//			$form->StartSelect('Move everyone to:', 'to');
//			$form->AddOption('-1', 'N/A, individual selections');
//			$divs = $roster->GetDivisions();
//			foreach ($divs as $div) {
//				$form->AddOption($div->GetID(), $div->GetName());
//			}
//			$form->EndSelect();
			foreach ($_REQUEST['members'] as $member) {
				$pleb = $roster->GetPerson($member);
        $form->table->StartRow();
        $form->table->AddCell('<label for="'.$member
            .'">Move '.$pleb->GetName().' to:</label>');
        $pdiv = $pleb->getPreviousDivision();
        $form->table->AddCell(
            DivisionDropDown($member,
                             1,
                             0,
                             1,
                             0,
                             $pdiv->getID(),
                             0,
                             array()));
        $form->table->EndRow();

//				$form->StartSelect('Move ' . $pleb->GetName() . ' to:', $member);
//				$divs = $roster->GetDivisions();
//				foreach ($divs as $div) {
//					$form->AddOption($div->GetID(), $div->GetName());
//				}
//				$form->EndSelect();
			}
			$form->AddSubmitButton('', 'Next');
			$form->EndForm();
			break;
		case 'choosewho':
			$form = new Form($page);
			$form->AddHidden('stage', 'chooseto');
			$form->AddHidden('from', $_REQUEST['from']);
			$form->StartSelect('Choose the people to transfer:', 'members[]', false, 10, true);
			$from = $roster->GetDivision($_REQUEST['from']);
			$plebs = $from->GetMembers('name');
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
      $form->table->StartRow();
      $form->table->AddCell('<label for="from">Division to transfer from:</label>');
      $form->table->AddCell(DivisionDropDown('from',
                                             1,
                                             0,
                                             1,
                                             0,
                                             0,
                                             0));
      $form->table->EndRow();
//			$form->StartSelect('Division to transfer from:', 'from');
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
