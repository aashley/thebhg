<?php
function title() {
	return 'Administration :: Declare AWOLs';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return ($auth_data['underlord'] || $auth_data['chief']);
}

function output() {
	global $auth_data, $pleb, $page, $roster;

	roster_header();

	if (!$auth_data['underlord']) {
		$div = $pleb->GetDivision();
	}
	else if ($_REQUEST['division']) {
		$div = $roster->GetDivision($_REQUEST['division']);
	}
	
	if (isset($div)) {
		if ($_REQUEST['submit']) {
			$subject = 'AWOL Check: ' . $div->GetName();
			$email = 'An AWOL Check has been run in ' . $div->GetName() . " and the following member(s) have been declared as AWOL:\n\n";
			if ($_REQUEST['noawol'] == 'on') {
				$email .= "No AWOLs have been declared.\n";
			}
			else {
				foreach ($_REQUEST['hunters'] as $id) {
					if (!mysql_query('INSERT INTO hn_pending_awols (id) VALUES (' . $id . ')', $roster->roster_db)) {
						$hunter = $roster->GetPerson($id);
						echo 'Error declaring ' . $hunter->GetName() . ' AWOL: they are already on the pending AWOL list.<br>';
					}
					else {
						$hunter = $roster->GetPerson($id);
						$email .= $hunter->IDLine(0) . "\n";
					}
				}
			}
			$email .= "\nBHG Roster";
			echo 'AWOLs declared.';

			$juds = $roster->SearchPosition(6);
			if (count($juds)) {
				foreach ($juds as $jud) {
					$addresses[] = $jud->GetEmail();
				}
				$sender = '"BHG Roster" <unanswered@thebhg.org>';
				$email_headers = 'X-Sender: ' . $sender . "\nReturn-Path: " . $sender . "\nFrom: " . $sender . "\nReply-To: " . $sender . "\nX-Mailer: PHP/" . phpversion();
				mail(implode(', ', $addresses), $subject, $email, $email_headers);
			}
		}
		else {
			$form = new Form($page);
			$form->AddHidden('division', $div->GetID());
			$form->StartSelect('Select the hunter(s) to be made AWOL:', 'hunters[]', false, 10, true);
			$members = $div->GetMembers('name');
			foreach ($members as $member) {
				$form->AddOption($member->GetID(), $member->GetName());
			}
			$form->EndSelect();
			$form->AddCheckBox('No AWOLs for this AWOL check:', 'noawol', 'on');
			$form->AddSubmitButton('submit', 'Declare AWOLs');
			$form->EndForm();
		}
	}
	else {
		$form = new Form($page);
		$form->StartSelect('Select the division to declare AWOLs in:', 'division');
		$divisions = $roster->GetDivisions();
		foreach ($divisions as $division) {
			$form->AddOption($division->GetID(), $division->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Select Division');
		$form->EndForm();
	}

	admin_footer($auth_data);
}
