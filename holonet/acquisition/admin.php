<?php
function title() {
	return 'Administration :: Index';
}

function auth($pleb) {
	global $user, $roster;
	
	$user = $roster->GetPerson($pleb->GetID());
	return (is_global_admin($user) || get_columns($user));
}

function output() {
	global $user;

	admin_header();

	echo 'Welcome to the Acquisition administration section.';
	
	admin_footer($user);
}
?>
