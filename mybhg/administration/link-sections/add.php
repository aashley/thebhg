<?php
$title = 'Administration :: Add Link Section';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 2)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

if ($_REQUEST['submit']) {
	if (mysql_query('INSERT INTO link_sections (name) VALUES ("' . addslashes($_REQUEST['name']) . '")', $db)) {
		echo 'Link section added successfully.';
	}
	else {
		echo 'Error adding link section: ' . mysql_error($db);
	}
}
else {
	$form = new Form($_SERVER['PHP_SELF']);
	$form->AddTextBox('Name:', 'name');
	$form->AddSubmitButton('submit', 'Add Link Section');
	$form->EndForm();
}

include('../../footer.php');
?>
