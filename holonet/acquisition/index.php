<?php
function title() {
	return 'Current Issue';
}

function output() {
	$cur_year = date('Y');
	$cur_week = date('W') - 1;
	if ($cur_week == 0) {
		$cur_year--;
		$cur_week = 52;
	}
	cover($cur_year, $cur_week);
}
?>
