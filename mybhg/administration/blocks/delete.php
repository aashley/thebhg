<?php
$title = 'Administration :: Delete Block';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 2)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

if ($_REQUEST['submit']) {
	if (mysql_query('DELETE FROM blocks WHERE id=' . $_REQUEST['id'], $db)) {
		mysql_query('DELETE FROM block_cache WHERE id=' . $_REQUEST['id'], $db);
		echo 'Block deleted successfully.';
	}
	else {
		echo 'Error deleting block: ' . mysql_error($db);
	}
}
else {
	$form = new Form($_SERVER['PHP_SELF']);
	$form->StartSelect('Block:', 'id');
	$block_result = mysql_query('SELECT id, title FROM blocks ORDER BY weight', $db);
	if ($block_result && mysql_num_rows($block_result)) {
		while ($block_row = mysql_fetch_array($block_result)) {
			$form->AddOption($block_row['id'], $block_row['title']);
		}
	}
	$form->EndSelect();
	$form->AddSubmitButton('submit', 'Delete Block');
	$form->EndForm();
}

include('../../footer.php');
?>
