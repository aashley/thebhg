<?php
if ($_REQUEST['id']) {
	$result = mysql_query("SELECT * FROM {$prefix}competitions WHERE id=" . $_REQUEST['id'], $db);
	$row = mysql_fetch_array($result);
}

function title() {
	global $row;
	return 'Competition :: ' . stripslashes($row['name']);
}

function output() {
	global $row, $prefix, $db;

	bb_header();

	echo nl2br(stripslashes($row['description']));
	hr();

	$table = new Table('Competition Information');
	$table->StartRow();
	$table->AddCell('Status:');
	if ($row['winner'] == 0) {
		if ($row['end'] > time()) {
			$table->AddCell('Open');
		}
		else {
			$table->AddCell('Closed (result pending)');
		}
		$table->EndRow();
		$table->AddRow('Betting Ends:', date('j F Y \a\t G:i:s T', $row['end']));
	}
	else {
		$table->AddCell('Complete');
		$table->EndRow();
		$table->AddRow('Betting Ended:', date('j F Y \a\t G:i:s T', $row['end']));
	}
	$table->EndTable();

	$option_result = mysql_query("SELECT * FROM {$prefix}options WHERE competition=" . $_REQUEST['id'] . ' ORDER BY odds ASC, name ASC', $db);
	if ($option_result && mysql_num_rows($option_result)) {
		hr();
		$table = new Table('Available Bets', true);
		$table->StartRow();
		$table->AddHeader('Bet');
		$table->AddHeader('Odds');
		if ($row['winner'] == 0 && $row['end'] > time()) {
			$table->AddHeader('&nbsp;');
		}
		$table->EndRow();
		while ($opt_row = mysql_fetch_array($option_result)) {
			$table->StartRow();
			$table->AddCell(stripslashes($opt_row['name']));
			$table->AddCell(calculate_odds($opt_row['odds']));
			if ($row['winner'] == 0 && $row['end'] > time()) {
				$table->AddCell('<a href="' . internal_link('bet', array('competition'=>$_REQUEST['id'], 'option'=>$opt_row['id'])) . '">Place Bet</a>');
			}
			$table->EndRow();
		}
		$table->EndTable();
	}

	bb_footer();
}
?>
