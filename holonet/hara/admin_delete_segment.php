<?php
function title() {
	return 'Administration :: Delete Segment';
}

function auth($user) {
	return is_admin($user);
}

function output() {
	global $db, $page, $prefix;

	admin_header();

	if ($_REQUEST['submit']) {
		if (mysql_query('DELETE FROM '.$prefix.'segments WHERE id=' . $_REQUEST['sid'], $db)) {
			echo 'Segment deleted successfully.';
		}
		else {
			echo 'Error deleting segment: ' . mysql_error($db);
		}
	}
	elseif ($_REQUEST['id']) {
		$form = new Form($page);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->StartSelect('Segment:', 'sid');

		$result = mysql_query('SELECT * FROM '.$prefix.'segments WHERE `show`=' . $_REQUEST['id'] . ' ORDER BY name ASC', $db);
		if ($result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$form->AddOption($row['id'], stripslashes($row['name']));
			}
		}
		
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Delete Segment');
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
