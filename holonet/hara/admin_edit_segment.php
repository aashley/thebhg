<?php
function title() {
	return 'Administration :: Edit Segment';
}

function auth($user) {
	return is_admin($user);
}

function output() {
	global $db, $page, $prefix, $roster;

	admin_header();

	if ($_REQUEST['submit']) {
		if (mysql_query('UPDATE '.$prefix.'segments SET name="' . addslashes($_REQUEST['name']) . '", creator=' . $_REQUEST['creator'] . ' WHERE id=' . $_REQUEST['sid'], $db)) {
			echo 'Segment saved successfully.';
		}
		else {
			echo 'Error saving segment: ' . mysql_error($db);
		}
	}
	elseif ($_REQUEST['sid']) {
		$result = mysql_query('SELECT * FROM '.$prefix.'segments WHERE id=' . $_REQUEST['sid'], $db);
		$row = mysql_fetch_array($result);
		
		$form = new Form($page);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddHidden('sid', $_REQUEST['sid']);
		$form->AddTextBox('Name:', 'name', stripslashes($row['name']));
		$form->StartSelect('Created By:', 'creator', $row['creator']);
		hunter_dropdown($form);
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Save Segment');
		$form->EndForm();
	}
	elseif ($_REQUEST['id']) {
		$form = new Form($page, 'get');
		$form->AddHidden('id', $_REQUEST['id']);
		$form->StartSelect('Segment:', 'sid');

		$result = mysql_query('SELECT * FROM '.$prefix.'segments WHERE `show`=' . $_REQUEST['id'] . ' ORDER BY name ASC', $db);
		if ($result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$form->AddOption($row['id'], stripslashes($row['name']));
			}
		}
		
		$form->EndSelect();
		$form->AddSubmitButton('', 'Next >>');
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
		$form->AddSubmitButton('', 'Next >>');
		$form->EndForm();
	}
	
	admin_footer();
}
?>
