<?php
function title() {
	return 'Arena Challenge Centre :: Add/Remove Locations';
}

function auth($pleb) {
	global $user;
	$user = $pleb;
	$pos = $pleb->GetPosition();
	return ($pleb->GetID() == 666 || $pos->GetID() == 9 || $pos->GetID() == 29 || $pos->GetID() == 4);
}

function output() {
	global $user, $page, $roster, $db, $lyarna_db, $email_headers;

	menu_header();

	echo '<a href="' . internal_link($page, array('table'=>'complex')) . '">Complexes</a> | ';
	echo '<a href="' . internal_link($page, array('table'=>'estate')) . '">Estates</a> | ';
	echo '<a href="' . internal_link($page, array('table'=>'hq')) . '">Headquarters</a>';

	hr();

	if ($_REQUEST['submit']) {
		if ($_REQUEST['locations']) {
			if (mysql_query('UPDATE ' . $_REQUEST['table'] . ' SET arena=1 WHERE id IN (' . implode(', ', $_REQUEST['locations']) . ')', $lyarna_db) && mysql_query('UPDATE ' . $_REQUEST['table'] . ' SET arena=0 WHERE id NOT IN (' . implode(', ', $_REQUEST['locations']) . ')', $lyarna_db)) {
				echo 'Saved location list.';
			}
			else {
				echo 'Error saving location list: ' . mysql_error($lyarna_db);
			}
		}
		else {
			if (mysql_query('UPDATE ' . $_REQUEST['table'] . ' SET arena=0', $lyarna_db)) {
				echo 'Saved location list.';
			}
			else {
				echo 'Error saving location list: ' . mysql_error($lyarna_db);
			}
		}
	}
	else {
		$form = new Form($page);
		$form->AddHidden('table', $_REQUEST['table']);
		$locations = mysql_query('SELECT id, name, arena FROM ' . $_REQUEST['table'] . ' ORDER BY name', $lyarna_db);
		while ($row = mysql_fetch_array($locations)) {
			$form->AddCheckBox(stripslashes($row['name']), 'locations[]', $row['id'], $row['arena']);
		}
		$form->AddSubmitButton('submit', 'Update List');
		$form->EndForm();
	}

	acc_footer();
}
?>
