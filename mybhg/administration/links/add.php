<?php
$title = 'Administration :: Add Link';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 2)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

if ($_REQUEST['submit']) {
	if (mysql_query('INSERT INTO links (name, url, show_main, section) VALUES ("' . addslashes($_REQUEST['name']) . '", "' . addslashes($_REQUEST['url']) . '", ' . ($_REQUEST['show_main'] == 'on' ? '1' : '0') . ', ' . $_REQUEST['section'] . ')', $db)) {
		echo 'Link added successfully.';
	}
	else {
		echo 'Error adding link: ' . mysql_error($db);
	}
}
else {
	$form = new Form($_SERVER['PHP_SELF']);
	$form->AddTextBox('Name:', 'name');
	$form->AddTextBox('URL:', 'url');
	$form->AddCheckBox('Show On Index:', 'show_main', 'on');
	$form->StartSelect('Section:', 'section');
	$result = mysql_query('SELECT * FROM link_sections ORDER BY name', $db);
	if ($result && mysql_num_rows($result)) {
		while ($row = mysql_fetch_array($result)) {
			$form->AddOption($row['id'], stripslashes($row['name']));
		}
	}
	$form->EndSelect();
	$form->AddSubmitButton('submit', 'Add Link');
	$form->EndForm();
}

include('../../footer.php');
?>
