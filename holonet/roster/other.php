<?php
function title() {
	return 'Other Bits &amp; Pieces';
}

function coders() {
	return array(94, 666);
}

function output() {
	roster_header();
	
	echo 'You can find other stuff that Jer and Koral have written in their occasional fits of boredom here. Some of these pages are informative, others merely silly.';

	hr();

	$table = new Table();
	$table->StartRow();
	$table->AddHeader('Title');
	$table->AddHeader('Description');
	$table->EndRow();
	$table->AddRow('<a href="' . internal_link('cadres') . '">Cadre Statistics</a>', 'Displays all current cadres, along with a few statistics on each one\'s membership.');
	$table->AddRow('<a href="' . internal_link('dewinged') . '">Citadel Transfers</a>', 'Displays a list of people who have transferred out of the Citadel into a kabal, as well as wing-by-wing statistics.');
	//$table->AddRow('<a href="' . internal_link('current-staff') . '">Current Staff</a>', 'Displays the current Commission members and KA staff of the BHG.');
	$table->AddRow('<a href="' . internal_link('xp_stats') . '">Experience Points</a>', 'Displays a list of all hunters who have earned XP, along with the amount of XP they have earned in total and the amount they have available now.');
	$table->AddRow('<a href="' . internal_link('voters') . '">Hall of Fame Voters</a>', 'Displays a list of people who are eligble to vote for Hall of Fame inductees.');
	$table->AddRow('<a href="' . internal_link('high_rollers') . '">High Rollers</a>', 'Displays all Active Hunters sorted by total credits earned.');
	$table->AddRow('<a href="' . internal_link('montgomery_burns') . '">Highest Account Balances</a>', 'Displays all Active Hunters sorted by their current account balance.');
	$table->AddRow('<a href="' . internal_link('medal_awards') . '">Medal Awards</a>', 'Displays a list and graph of the number of merit awards made each month.');
	$table->AddRow('<a href="' . internal_link('stats') . '">Overall Statistics</a>', 'Displays some overall statistics on divisions and ranks.');
	$table->AddRow('<a href="' . internal_link('position_changes') . '">Positional Changes</a>', 'Displays non-trivial positional changes that occurred during the selected month.');
	$table->AddRow('<a href="' . internal_link('random') . '">Random Hunter</a>', 'Displays a random hunter\'s dossier.');
	$table->AddRow('<a href="' . internal_link('recent_credits') . '">Recent Credit Awards</a>', 'Displays the number of credits hunters have received over the last few days.');
	$table->AddRow('<a href="' . internal_link('rc_kabal') . '">Recent Credit Awards By Division</a>', 'Displays the number of credits hunters in each division have received over the last few days.');
	$table->AddRow('<a href="' . internal_link('promotions') . '">Recent Promotions</a>', 'Displays the most recent promotions in the BHG.');
	$table->AddRow('<a href="' . internal_link('old_farts') . '">Time in Service</a>', 'Displays the join date of all Active Hunters.');
	$table->EndTable();

	roster_footer();
}
?>
