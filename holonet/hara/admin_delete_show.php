<?php
function title() {
	return 'Administration :: Delete Show';
}

function auth($user) {
	return is_admin($user);
}

function output() {
	global $db, $page, $prefix;

	admin_header();

	if ($_REQUEST['submit']) {
		if (mysql_query('DELETE FROM '.$prefix.'shows WHERE id=' . $_REQUEST['id'], $db)) {
			echo 'Show deleted successfully.';
		}
		else {
			echo 'Error deleting show: ' . mysql_error($db);
		}
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
		$form->AddSubmitButton('submit', 'Delete Show');
		$form->EndForm();
	}
	
	admin_footer();
}
?>
