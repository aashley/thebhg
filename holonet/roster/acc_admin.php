<?php
function title() {
	return 'Arena Challenge Centre :: Administration';
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

	echo 'Welcome to the administration interface for the ACC.';

	acc_footer();
}
?>
