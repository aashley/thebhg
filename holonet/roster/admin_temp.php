<?php
function title() {
	return 'Administration :: ';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return true;
}

function output() {
	global $auth_data, $pleb, $page;

	roster_header();
	admin_footer($auth_data);
}
?>
