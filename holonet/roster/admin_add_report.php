<?php
function title() {
	return 'Administration :: Add Report';
}

function auth($person) {
	global $auth_data, $pleb, $roster;
	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return ($auth_data['commission'] || $auth_data['chief'] || $auth_data['warden']);
}

function output() {
	global $auth_data, $pleb, $roster, $page;

	$pos = $pleb->GetPosition();
	$div = $pleb->GetDivision();

	roster_header();
	if ($_REQUEST['submit']) {
		if ($_REQUEST['submit'] == 'Load Template') {
		} else {
			if (mysql_query('INSERT INTO hn_reports (position, division, author, time, report, html) VALUES (' . $pos->GetID() . ', ' . $div->GetID() . ', ' . $pleb->GetID() . ', UNIX_TIMESTAMP(), "' . addslashes($_REQUEST['report']) . '", ' . ($_REQUEST['html'] == 'on' ? '1' : '0') . ')', $roster->roster_db)) {
				echo 'Report added successfully.';
			}
			else {
				echo 'Error adding report: ' . mysql_error($roster->roster_db);
			}
		}
	}
	else {
		$form = new Form($page);
		if ($auth_date['chief'] || $auth_data['warden'] || $pleb->getID() == 94) {
			$form->AddSubmitButton('submit', 'Load Template');
		}
		$form->AddTextArea('Report:', 'report', '', 20, 70);
		$form->AddCheckBox('Enable HTML:', 'html', 'on');
		$form->table->AddRow('Note:', 'This report cannot be deleted once added.');
		$form->AddSubmitButton('submit', 'Add Report');
		$form->EndForm();
	}

	admin_footer($auth_data);
}
?>
