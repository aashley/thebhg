<?php
function title() {
	return 'Search';
}

function output() {
	global $roster;

	roster_header();
	show_search_form();
	roster_footer();
}
?>
