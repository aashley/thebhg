<?php
function title() {
	return 'Past Issues';
}

function output() {
	$table = new Table('', true);
	$table->StartRow();
	$table->AddHeader('Issue');
	$table->AddHeader('Date');
	$table->EndRow();

	// First automated issue.
	$year = 2002;
	$week = 50;

	// The start of time for the automated Acquisition.
	$start = 1039410000;

	$cur_year = date('Y');
	$cur_week = date('W') - 1;
	if ($cur_week == 0) {
		$cur_year--;
		$cur_week = 52;
	}
	$current = get_dates($cur_year, $cur_week);
	for ($ts = $current['end'] + 1; $ts >= $start; $ts -= 604800) {
		$year = date('Y', $ts);
		$week = date('W', $ts) - 1;
		$table->AddRow('<a href="' . internal_link('issue', array('year'=>$year, 'week'=>$week)) . '">' . $year . '-' . $week . '</a>', date('j F Y', $ts + 1));
	}

	$table->EndTable();
}
?>
