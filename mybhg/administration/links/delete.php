<?php
$title = 'Administration :: Delete Link';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 2)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

if ($_REQUEST['submit']) {
	if (mysql_query('DELETE FROM links WHERE id=' . $_REQUEST['id'], $db)) {
		echo 'Link deleted successfully.';
	}
	else {
		echo 'Error deleting link: ' . mysql_error($db);
	}
}
else {
	$form = new Form($_SERVER['PHP_SELF']);
	$form->StartSelect('Link:', 'id');
	$links_result = mysql_query('SELECT * FROM links ORDER BY name', $db);
	if ($links_result && mysql_num_rows($links_result)) {
		while ($links_row = mysql_fetch_array($links_result)) {
			$form->AddOption($links_row['id'], $links_row['name']);
		}
	}
	$form->EndSelect();
	$form->AddSubmitButton('submit', 'Delete Link');
	$form->EndForm();
}

include('../../footer.php');
?>
