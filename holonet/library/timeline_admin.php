<?php
function title() {
	return 'Administration :: Timeline';
}

function auth($user) {
	$pos = $user->GetPosition();
	return ($pos->GetID() == 4 || $pos->GetID() == 1 || $pos->GetID() == 10 || $user->GetID() == 666);
}

function output() {
	global $timeline, $page;

	menu_header();

	echo 'Welcome to the timeline administration.';

	timeline_admin_footer();
}
?>

