<?php
if ($_REQUEST['id']) {
	$result = mysql_query("SELECT * FROM {$prefix}sports WHERE id=" . $_REQUEST['id'], $db);
	$row = mysql_fetch_array($result);
}

function title() {
	global $row;
	
	$title = 'Administration :: Edit Sport';
	if (isset($row)) {
		$title .= ' :: ' . stripslashes($row['name']);
	}
	return $title;
}

function auth($user) {
	global $valid;

	$valid = bb_get_sports($user);
	return $valid['global'];
}

function output() {
	global $prefix, $db, $valid, $row, $page;

	bb_header();

	if (isset($row)) {
		if ($_REQUEST['name']) {
			if (mysql_query("UPDATE {$prefix}sports SET name=\"" . addslashes($_REQUEST['name']) . '", description="' . addslashes($_REQUEST['description']) . '" WHERE id=' . $_REQUEST['id'], $db)) {
				echo 'Sport saved.';
			}
			else {
				echo 'Error saving sport: ' . mysql_error($db);
			}
		}
		else {
			$form = new Form($page);
			$form->AddHidden('id', $_REQUEST['id']);
			$form->AddTextBox('Name:', 'name', html_escape(stripslashes($row['name'])));
			$form->AddTextArea('Description:', 'description', stripslashes($row['description']));
			$form->AddSubmitButton('', 'Save Sport');
			$form->EndForm();
		}
	}
	else {
		$form = new Form($page, 'get');
		$form->StartSelect('Sport:', 'id');
		$sports_result = mysql_query("SELECT * FROM {$prefix}sports ORDER BY name ASC", $db);
		if ($sports_result && mysql_num_rows($sports_result)) {
			while ($sport_row = mysql_fetch_array($sports_result)) {
				$form->AddOption($sport_row['id'], stripslashes($sport_row['name']));
			}
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit Sport');
		$form->EndForm();
	}

	bb_admin_footer($valid);
}
?>
