<?php
function title() {
	return 'Administration :: Add Column';
}

function auth($pleb) {
	global $user, $roster;

	$user = $roster->GetPerson($pleb->GetID());
	return is_global_admin($user);
}

function output() {
	global $user, $page, $db;

	admin_header();

	if ($_REQUEST['name']) {
		if (mysql_query('INSERT INTO aq_columns (name, author, active) VALUES ("' . addslashes($_REQUEST['name']) . '", ' . $_REQUEST['author'] . ', ' . ($_REQUEST['active'] == 'on' ? '1' : '0') . ')', $db)) {
			echo 'Column added successfully.';
		}
		else {
			echo 'Error adding column: ' . mysql_error($db);
		}
	}
	else {
		$form = new Form($page, 'post');
		$form->AddTextBox('Name:', 'name', '', 40);
		$form->StartSelect('Author:', 'author');
		hunter_dropdown($form);
		$form->EndSelect();
		$form->AddCheckBox('Active:', 'active', 'on', true);
		$form->AddSubmitButton('', 'Add Column');
		$form->EndForm();
	}

	admin_footer($user);
}
?>
