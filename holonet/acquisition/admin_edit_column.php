<?php
function title() {
	return 'Administration :: Edit Column';
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
		if (mysql_query('UPDATE aq_columns SET name="' . addslashes($_REQUEST['name']) . '", author=' . $_REQUEST['author'] . ', active=' . ($_REQUEST['active'] == 'on' ? '1' : '0') . ' WHERE id=' . $_REQUEST['id'], $db)) {
			echo 'Column saved successfully.';
		}
		else {
			echo 'Error saving column: ' . mysql_error($db);
		}
	}
	elseif ($_REQUEST['id']) {
		$result = mysql_query('SELECT * FROM aq_columns WHERE id=' . $_REQUEST['id'], $db);
		$row = mysql_fetch_array($result);
		
		$form = new Form($page, 'post');
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextBox('Name:', 'name', stripslashes($row['name']), 40);
		$form->StartSelect('Author:', 'author', $row['author']);
		hunter_dropdown($form);
		$form->EndSelect();
		$form->AddCheckBox('Active:', 'active', 'on', $row['active']);
		$form->AddSubmitButton('', 'Save Column');
		$form->EndForm();
	}
	else {
		$form = new Form($page, 'get');
		$form->StartSelect('Column:', 'id');
		$result = mysql_query('SELECT id, name, active FROM aq_columns ORDER BY name', $db);
		while ($row = mysql_fetch_array($result)) {
			$form->AddOption($row['id'], html_escape(stripslashes($row['name'])) . ($row['active'] ? ' (active)' : ' (inactive)'));
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit Column');
		$form->EndForm();
	}

	admin_footer($user);
}
?>
