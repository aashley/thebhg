<?php
$title = 'Administration :: Site Configuration :: Delete Variable';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 2)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

$value = $config->GetValue($_GET['name']);

if (isset($_GET['confirm'])) {
	if ($value->Delete()) {
		echo 'Variable deleted.';
	}
	else {
		echo 'Error deleting variable.';
	}
}
else {
	echo 'Are you sure you want to delete this variable?<br /><br /><a href="' . $_SERVER['PHP_SELF'] . '?name=' . urlencode($value->GetName()) . '&amp;confirm">Yes</a> :: <a href="javascript:history.go(-1)">No</a>';
}

include('../../footer.php');
?>
