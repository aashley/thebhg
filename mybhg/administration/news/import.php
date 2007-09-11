<?php
$title = 'Administration :: Import Old News';
include('../../header.php');

$global_db = mysql_connect('localhost', 'thebhg', '1IHfHTsAmILMwpP');

if (empty($my_user) || !check_auth($my_user, 2)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

if ($_REQUEST['submit']) {
	if (mysql_select_db($_REQUEST['database'], $global_db)) {
		$result = mysql_query('SELECT * FROM newsboard', $global_db);
		if ($result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$rows[] = '(' . ((int) $_REQUEST['section']) . ', ' . $row['timestamp'] . ', ' . $row['poster'] . ', "' . addslashes($row['topic']) . '", "' . addslashes($row['message']) . '")';
			}
			$sql = 'INSERT INTO newsboard (section, timestamp, poster, topic, message) VALUES ' . implode(', ', $rows);
			if (mysql_query($sql, $roster->roster_db)) {
				echo 'News imported successfully.';
			}
			else {
				echo 'Error importing news:<br /><br />Query: ' . $sql . '<br /><br />Error: ' . mysql_error($roster->roster_db);
			}
		}
		elseif ($result) {
			echo 'No news items found.';
		}
		else {
			echo 'Error loading news items: ' . mysql_error($global_db);
		}
	}
	else {
		echo 'Error changing database: ' . mysql_error($global_db);
	}
}
else {
	$form = new Form($_SERVER['PHP_SELF']);
	$form->StartSelect('Database:', 'database');
	$result = mysql_list_dbs($global_db);
	while ($row = mysql_fetch_row($result)) {
		$form->AddOption($row[0], $row[0]);
	}
	$form->EndSelect();
	$form->StartSelect('Section:', 'section');
	foreach ($news->GetAvailableSections() as $section) {
		$form->AddOption($section['id'], $section['name']);
	}
	$form->EndSelect();
	$form->AddSubmitButton('submit', 'Import News');
	$form->EndForm();
}

include('../../footer.php');
?>
