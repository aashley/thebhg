<?php
function title() {
	return 'Administration :: Index';
}

function auth($user) {
	return is_admin($user);
}

function output() {
	admin_header();
	echo 'Welcome to the administration section.';
	admin_footer();
}
?>
