<?php
$title = 'Preferences';
include('header.php');
include_once('timezone.php');

if (empty($my_user)) {
	echo 'You must be logged in to edit your preferences.';
	include('footer.php');
}

if ($_REQUEST['submit']) {
	$sql = 'UPDATE prefs SET ';
	$sets = array();
	if (isset($_REQUEST['blocks'])) {
		$sets[] = 'blocks="' . implode(',', $_REQUEST['blocks']) . '"';
	}
	else {
		$sets[] = 'blocks=""';
	}
	if (isset($_REQUEST['sections'])) {
		$sets[] = 'sections="' . implode(',', $_REQUEST['sections']) . '"';
	}
	else {
		$sets[] = 'sections=""';
	}
	$sets[] = 'posts=' . ((int) $_REQUEST['posts']);
	$sets[] = 'timezone="' . addslashes($_REQUEST['timezone']) . '"';
	$sets[] = 'theme="' . addslashes($_REQUEST['theme']) . '"';
	if (isset($_REQUEST['show_weather'])) {
		$sets[] = 'weather="' . addslashes(str_replace('-', '', $my_weather)) . '"';
	}
	else {
		$sets[] = 'weather="-' . addslashes(str_replace('-', '', $my_weather)) . '"';
	}
	$sql .= implode(', ', $sets);
	$sql .= ' WHERE id=' . $my_user->GetID();
	if (mysql_query($sql, $db)) {
		echo 'Preferences saved.';
	}
	else {
		echo 'Error saving preferences: ' . mysql_error($db);
	}
}
else {
	$form = new Form($_SERVER['PHP_SELF']);
	
	$form->table->StartRow();
	$form->table->AddHeader('Blocks to Show', 2);
	$form->table->EndRow();

	$result = mysql_query('SELECT id, title FROM blocks ORDER BY weight', $db);
	while ($row = mysql_fetch_array($result)) {
		$checked = in_array($row['id'], $my_blocks);
		$form->AddCheckBox(stripslashes($row['title']), 'blocks[]', $row['id'], $checked);
	}
	$form->AddCheckBox('Weather', 'show_weather', 'on', $my_weather{0} != '-');

	$form->table->StartRow();
	$form->table->AddHeader('News/Calendar Sections to Show', 2);
	$form->table->EndRow();

	$sections = $news->GetAvailableSections();
	foreach ($sections as $sec) {
		$checked = in_array($sec['id'], $my_sections);
		$form->AddCheckBox($sec['name'], 'sections[]', $sec['id'], $checked);
	}

	$form->table->StartRow();
	$form->table->AddHeader('Other Options', 2);
	$form->table->EndRow();

	$form->AddTextBox('Posts To Show:', 'posts', $my_posts, 3);

	$form->StartSelect('Time Zone:', 'timezone', $my_tz);
	foreach ($tz as $id=>$name) {
		$name = str_replace('/', ': ', $name);
		$form->AddOption($id, $name);
	}
	$form->EndSelect();

	$form->StartSelect('Theme:', 'theme', $my_theme);
	foreach (get_themes() as $dir=>$th) {
		if (!$th->IECompliant()) {
			$name = '* ';
		}
		else {
			$name = '';
		}
		$form->AddOption($dir, $name . $th->GetName());
	}
	$form->EndSelect();
	
	$form->table->StartRow();
	$form->table->AddCell('Note: Themes marked with an asterisk (*) require a browser with full CSS 2 and alpha-channel PNG support. In other words, they work nicely with Firefox, Mozilla, and Opera, but not so well with Internet Explorer.', 2);
	$form->table->EndRow();

	$form->AddSubmitButton('submit', 'Save Preferences');
	$form->EndForm();
}

include('footer.php');
?>
