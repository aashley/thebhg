<?php
function title() {
	return 'My Bets';
}

function auth($pleb) {
	global $user;

	$user = $pleb;
	return true;
}

function output() {
	global $user, $prefix, $db, $page;

	$sports = $prefix . 'sports';
	$competitions = $prefix . 'competitions';
	$options = $prefix . 'options';
	$bets = $prefix . 'bets';
	
	$pending_result = mysql_query("SELECT $sports.id AS sid, $sports.name AS sport, $competitions.id AS cid, $competitions.name AS competition, $options.name AS `option`, $options.odds AS odds, $bets.amount FROM $sports, $competitions, $options, $bets WHERE $sports.id=$competitions.sport AND $competitions.id=$options.competition AND $options.id=$bets.`option` AND $competitions.winner=0 AND $bets.user=" . $user->GetID() . " ORDER BY sport ASC, competition ASC, `option` ASC, amount DESC", $db);
	$complete_result = mysql_query("SELECT $sports.id AS sid, $sports.name AS sport, $competitions.id AS cid, $competitions.name AS competition, ($competitions.winner=$options.id) AS winner, $options.name AS `option`, $options.odds AS odds, $bets.amount FROM $sports, $competitions, $options, $bets WHERE $sports.id=$competitions.sport AND $competitions.id=$options.competition AND $options.id=$bets.`option` AND $competitions.winner!=0 AND $bets.user=" . $user->GetID() . " ORDER BY sport ASC, competition ASC, `option` ASC, winner DESC, amount DESC", $db);
	
	bb_header();

	if (mysql_num_rows($pending_result)) {
		$table = new Table('Pending Bets');
		$table->StartRow();
		$table->AddHeader('Sport');
		$table->AddHeader('Competition');
		$table->AddHeader('Option');
		$table->AddHeader('Odds');
		$table->AddHeader('Amount');
		$table->EndRow();
		while ($pending_row = mysql_fetch_array($pending_result)) {
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link('sport', array('id'=>$pending_row['sid'])) . '">' . stripslashes($pending_row['sport']));
			$table->AddCell('<a href="' . internal_link('competition', array('id'=>$pending_row['cid'])) . '">' . stripslashes($pending_row['competition']));
			$table->AddCell(stripslashes($pending_row['option']));
			$table->AddCell(calculate_odds($pending_row['odds']));
			$table->AddCell(number_format($pending_row['amount']) . ' ICs');
			$table->EndRow();
		}
		$table->EndTable();

		if (mysql_num_rows($complete_result)) {
			hr();
		}
	}
	elseif (mysql_num_rows($complete_result) == 0) {
		echo 'You have never placed a bet.';
	}

	if (mysql_num_rows($complete_result)) {
		$table = new Table('Past Bets');
		$table->StartRow();
		$table->AddHeader('Sport');
		$table->AddHeader('Competition');
		$table->AddHeader('Option');
		$table->AddHeader('Odds');
		$table->AddHeader('Amount');
		$table->AddHeader('Credits Won');
		$table->EndRow();
		while ($complete_row = mysql_fetch_array($complete_result)) {
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link('sport', array('id'=>$complete_row['sid'])) . '">' . stripslashes($complete_row['sport']));
			$table->AddCell('<a href="' . internal_link('competition', array('id'=>$complete_row['cid'])) . '">' . stripslashes($complete_row['competition']));
			$table->AddCell(stripslashes($complete_row['option']));
			$table->AddCell(calculate_odds($complete_row['odds']));
			$table->AddCell(number_format($complete_row['amount']) . ' ICs');
			if ($complete_row['winner']) {
				$table->AddCell(number_format($complete_row['odds'] * $complete_row['amount']) . ' ICs');
			}
			else {
				$table->AddCell('N/A');
			}
			$table->EndRow();
		}
		$table->EndTable();
	}

	bb_footer();
}
?>
