<?php
function title() {
	return 'Administration :: Approve AWOLs';
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
			switch ($action) {
				case 'approve':
					$hunter = $roster->GetPerson($id);
					$hunter->SetDivision(11);
				case 'deny':
					mysql_query('DELETE FROM hn_pending_awols WHERE id=' . $id, $roster->roster_db);
			}
		}
		echo 'AWOLs processed.';
	}
	else {
		$result = mysql_query('SELECT roster_roster.id, roster_roster.name, roster_divisions.name AS division FROM roster_divisions, roster_roster, hn_pending_awols WHERE roster_roster.id=hn_pending_awols.id AND roster_roster.division=roster_divisions.id ORDER BY roster_divisions.name ASC, roster_roster.name ASC', $roster->roster_db);
		if ($result && mysql_num_rows($result)) {
			$form = new Form($page);
			while ($row = mysql_fetch_array($result)) {
				$form->StartSelect(stripslashes($row['name']) . ' (' . stripslashes($row['division']) . ')', 'hunters[' . $row['id'] . ']', 'approve');
				$form->AddOption('approve', 'Approve');
				$form->AddOption('deny', 'Deny');
				$form->AddOption('hold', 'Hold');
				$form->EndSelect();
			}
			$form->AddSubmitButton('', 'Process AWOLs');
			$form->EndForm();
		}
		else {
			echo 'There are no pending AWOLs.';
		}
	}

	admin_footer($auth_data);
}
