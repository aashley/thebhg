<?php
function title() {
	return 'Administration :: Add Segment';
}

function auth($user) {
	return is_admin($user);
}

function output() {
	global $db, $page, $prefix, $roster;

	admin_header();

	if ($_REQUEST['submit']) {
		if (mysql_query('INSERT INTO '.$prefix.'segments (`show`, name, creator) VALUES (' . $_REQUEST['id'] . ', "' . addslashes($_REQUEST['name']) . '", ' . $_REQUEST['creator'] . ')', $db)) {
			echo 'Segment added successfully.';
		}
		else {
			echo 'Error adding segment: ' . mysql_error($db);
		}
	}
	elseif ($_REQUEST['id']) {
		$form = new Form($page);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextBox('Name:', 'name');
		$form->StartSelect('Created By:', 'creator');
		hunter_dropdown($form);
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Add Segment');
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
