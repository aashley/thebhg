<?php
function title() {
	return 'Arena Challenge Centre :: Remove Challenge';
}

function auth($pleb) {
	global $user;
	$user = $pleb;
	$pos = $pleb->GetPosition();
	return ($pleb->GetID() == 666 || $pos->GetID() == 9 || $pos->GetID() == 29 || $pos->GetID() == 4);
}

function output() {
	global $user, $page, $roster, $db, $lyarna_db, $email_headers;

	menu_header();

	if (mysql_query('DELETE FROM arena WHERE id=' . $_REQUEST['id'], $db)) {
		echo 'Challenge successfully deleted.';
	}
	else {
		echo 'Error deleting challenge: ' . mysql_error($db);
	}

	acc_footer();
}
?>
