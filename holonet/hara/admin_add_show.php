<?php
function title() {
	return 'Administration :: Add Show';
}

function auth($user) {
	return is_admin($user);
}

function output() {
	global $db, $page, $prefix;

	admin_header();

	if ($_REQUEST['submit']) {
		$time = parse_date_box('time');
		if (mysql_query('INSERT INTO '.$prefix.'shows (name, time) VALUES ("' . addslashes($_REQUEST['name']) . '", ' . $time . ')', $db)) {
			echo 'Show added successfully.';
		}
		else {
			echo 'Error adding show: ' . mysql_error($db);
		}
	}
	else {
		$form = new Form($page);
		$form->AddTextBox('Name:', 'name');
		$form->AddDateBox('Date and Time:', 'time', 0, true);
		$form->AddSubmitButton('submit', 'Add Show');
		$form->EndForm();
	}
	
	admin_footer();
}
?>
