<?php
function title() {
    return 'Administration :: General :: Add Report';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $auth_data, $page, $roster, $hunter;

    arena_header();

    $pos = $hunter->GetPosition();
	$div = $hunter->GetDivision();
	
	if (isset($_REQUEST['submit'])) {
		if (mysql_query('INSERT INTO hn_reports (position, division, author, time, report, html) VALUES (' . $pos->GetID() . ', ' . $div->GetID() . ', ' . $hunter->GetID() . ', UNIX_TIMESTAMP(), "' . addslashes($_REQUEST['report']) . '", ' . ($_REQUEST['html'] == 'on' ? '1' : '0') . ')', $roster->roster_db)) {
			echo 'Report added successfully.';
		}
		else {
			echo 'Error adding report: ' . mysql_error($roster->roster_db);
		}
	}
	else {
		$form = new Form($page);
		$form->AddTextArea('Report:', 'report', '', 20, 70);
		$form->AddCheckBox('Enable HTML:', 'html', 'on');
		$form->table->AddRow('Note:', 'This report cannot be deleted once added.');
		$form->AddSubmitButton('submit', 'Add Report');
		$form->EndForm();
	}

    admin_footer($auth_data);
}
?>
