<?php
$title = 'Administration :: Edit Link';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 2)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

if ($_REQUEST['submit']) {
	if (mysql_query('UPDATE links SET name="' . addslashes($_REQUEST['name']) . '", url="' . addslashes($_REQUEST['url']) . '", show_main=' . ($_REQUEST['show_main'] == 'on' ? '1' : '0') . ', section=' . $_REQUEST['section'] . ' WHERE id=' . $_REQUEST['id'], $db)) {
		echo 'Link saved successfully.';
	}
	else {
		echo 'Error saving link: ' . mysql_error($db);
	}
}
elseif ($_REQUEST['id']) {
	$result = mysql_query('SELECT * FROM links WHERE id=' . $_REQUEST['id'], $db);
	if ($result && mysql_num_rows($result)) {
		$row = mysql_fetch_array($result);
	
		$form = new Form($_SERVER['PHP_SELF']);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextBox('Name:', 'name', stripslashes($row['name']));
		$form->AddTextBox('URL:', 'url', stripslashes($row['url']));
		$form->AddCheckBox('Show On Index:', 'show_main', 'on', $row['show_main']);
		$form->StartSelect('Section:', 'section');
		$result = mysql_query('SELECT * FROM link_sections ORDER BY name', $db);
		if ($result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$form->AddOption($row['id'], stripslashes($row['name']));
			}
		}
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Save Link');
		$form->EndForm();
	}
	else {
		echo 'Error loading link.';
	}
}
else {
	$form = new Form($_SERVER['PHP_SELF'], 'get');
	$form->StartSelect('Link:', 'id');
	$links_result = mysql_query('SELECT * FROM links ORDER BY name', $db);
	if ($links_result && mysql_num_rows($links_result)) {
		while ($links_row = mysql_fetch_array($links_result)) {
			$form->AddOption($links_row['id'], $links_row['name']);
		}
	}
	$form->EndSelect();
	$form->AddSubmitButton('', 'Edit Link');
	$form->EndForm();
}

include('../../footer.php');
?>
