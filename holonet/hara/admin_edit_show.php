<?php
function title() {
	return 'Administration :: Edit Show';
}

function auth($user) {
	return is_admin($user);
}

function output() {
	global $db, $page, $prefix;

	admin_header();

	if ($_REQUEST['submit']) {
		$time = parse_date_box('time');
		if (mysql_query('UPDATE '.$prefix.'shows SET name="' . addslashes($_REQUEST['name']) . '", time=' . $time . ' WHERE id=' . $_REQUEST['id'], $db)) {
			echo 'Show saved successfully.';
		}
		else {
			echo 'Error saving show: ' . mysql_error($db);
		}
	}
	elseif ($_REQUEST['id']) {
		$result = mysql_query('SELECT * FROM '.$prefix.'shows WHERE id=' . $_REQUEST['id'], $db);
		$row = mysql_fetch_array($result);

		$form = new Form($page);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextBox('Name:', 'name', stripslashes($row['name']));
		$form->AddDateBox('Date and Time:', 'time', $row['time'], true);
		$form->AddSubmitButton('submit', 'Save Show');
		$form->EndForm();
	}
	else {
		$form = new Form($page, 'get');
		$form->StartSelect('Show:', 'id');
		
		$result = mysql_query('SELECT * FROM '.$prefix.'shows ORDER BY time DESC', $db);
		if ($result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$form->AddOption($row['id'], stripslashes($row['name']) . ' (' . date('j/n/Y @ G:i', $row['time']) . ')');
			}
		}
		
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit Show');
		$form->EndForm();
	}
	
	admin_footer();
}
?>
