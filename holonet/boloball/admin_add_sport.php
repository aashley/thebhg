<?php
function title() {
	return 'Administration :: Add Sport';
}

function auth($user) {
	global $valid;

	$valid = bb_get_sports($user);
	return $valid['global'];
}

function output() {
	global $prefix, $db, $valid, $page;

	bb_header();

	if ($_REQUEST['name']) {
		if (mysql_query("INSERT INTO {$prefix}sports (name, description) VALUES (\"" . addslashes($_REQUEST['name']) . '", "' . addslashes($_REQUEST['description']) . '")', $db)) {
			foreach ($_REQUEST['user'] as $pleb) {
				mysql_query("INSERT INTO {$prefix}users (sport, user) VALUES (" . mysql_insert_id($db) . ', ' . $pleb . ')', $db);
			}
			echo 'Sport added.';
		}
		else {
			echo 'Error adding sport: ' . mysql_error($db);
		}
	}
	else {
		$form = new Form($page);
		$form->AddTextBox('Name:', 'name');
		$form->AddTextArea('Description:', 'description');
		$form->StartSelect('Administrator:', 'user[]', false, 10, true);
		hunter_dropdown($form);
		$form->EndSelect();
		$form->AddSubmitButton('', 'Add Sport');
		$form->EndForm();
	}

	bb_admin_footer($valid);
}
?>
