<?php
$title = 'Administration :: Delete Link Section';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 2)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

if ($_REQUEST['submit']) {
	if (mysql_query('DELETE FROM link_sections WHERE id=' . $_REQUEST['id'], $db)) {
		echo 'Link section deleted successfully.';
	}
	else {
		echo 'Error deleting link section: ' . mysql_error($db);
	}
}
else {
	$form = new Form($_SERVER['PHP_SELF']);
	$form->StartSelect('Link Section:', 'id');
	$links_result = mysql_query('SELECT * FROM link_section ORDER BY name', $db);
	if ($links_result && mysql_num_rows($links_result)) {
		while ($links_row = mysql_fetch_array($links_result)) {
			$form->AddOption($links_row['id'], $links_row['name']);
		}
	}
	$form->EndSelect();
	$form->AddSubmitButton('submit', 'Delete Link Section');
	$form->EndForm();
}

include('../../footer.php');
?>
