<?php
$title = 'Administration :: Edit Link Section';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 2)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

if ($_REQUEST['submit']) {
	if (mysql_query('UPDATE link_sections SET name="' . addslashes($_REQUEST['name']) . '" WHERE id=' . $_REQUEST['id'], $db)) {
		echo 'Link section saved successfully.';
	}
	else {
		echo 'Error saving link section: ' . mysql_error($db);
	}
}
elseif ($_REQUEST['id']) {
	$result = mysql_query('SELECT * FROM link_sections WHERE id=' . $_REQUEST['id'], $db);
	if ($result && mysql_num_rows($result)) {
		$row = mysql_fetch_array($result);
	
		$form = new Form($_SERVER['PHP_SELF']);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextBox('Name:', 'name', stripslashes($row['name']));
		$form->AddSubmitButton('submit', 'Save Link Section');
		$form->EndForm();
	}
	else {
		echo 'Error loading link section.';
	}
}
else {
	$form = new Form($_SERVER['PHP_SELF'], 'get');
	$form->StartSelect('Link Section:', 'id');
	$links_result = mysql_query('SELECT * FROM link_sections ORDER BY name', $db);
	if ($links_result && mysql_num_rows($links_result)) {
		while ($links_row = mysql_fetch_array($links_result)) {
			$form->AddOption($links_row['id'], $links_row['name']);
		}
	}
	$form->EndSelect();
	$form->AddSubmitButton('', 'Edit Link Section');
	$form->EndForm();
}

include('../../footer.php');
?>
