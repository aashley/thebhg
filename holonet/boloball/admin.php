<?php
function title() {
	return 'Administration :: Index';
}

function auth($user) {
	global $valid;
	
	$valid = bb_get_sports($user);
	return $valid;
}

function output() {
	global $valid;
	
	bb_header();
	echo 'Welcome to the Boloball administration section.<br><br>If you are administering a sport for the first time, you will probably want to add a competition. Usually, you will use the "Add Competition" page, but in a situation where there are a number of two-team match-ups (for example, where you would want to create a competition for a round of the FA Cup with hunters being able to bet on each match), you are probably better off using the "League Wizard", which is geared up specifically for these problems.<br><br>Note that once a competition is created, you cannot change the options or the odds for the options without deleting the competition, refunding all bets, and creating a new competition. In other words, be sure that the odds and options are correct before starting.<br><br>Once the competition is complete, you will need to come back and use the "Set Competition Winner" page. Once you have selected a winner, all winning bets will be paid automatically.';
	bb_admin_footer($valid);
}
?>
