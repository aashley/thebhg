<?php
$auth_data = array();

function title() {
	return 'Administration :: Index';
}

function auth($pleb) {
	global $auth_data;

	$auth_data = get_auth_data($pleb);
	$div = $pleb->GetDivision();
	return ($div->GetID() != 16);
}

function output() {
	global $auth_data;

	roster_header();
	echo 'Welcome to BHG Roster administration. You will see a variety of options available to you, with the exact selection depending on what position you hold.<br><br>Please try not to break anything.';
	admin_footer($auth_data);
}
?>
