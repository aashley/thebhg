<?php
function title() {
	return 'Administration :: Set Competition Winner';
}

function auth($user) {
	global $valid;

	$valid = bb_get_sports($user);
	return $valid;
}

function output() {
	global $prefix, $db, $page, $valid, $roster;

	bb_header();

	if ($_REQUEST['competition']) {
		if ($_REQUEST['winner']) {
			if (mysql_query("UPDATE {$prefix}competitions SET winner=" . $_REQUEST['winner'] . ' WHERE id=' . $_REQUEST['competition'], $db)) {
				$bet_result = mysql_query("SELECT {$prefix}bets.user, {$prefix}bets.amount, {$prefix}options.odds FROM {$prefix}bets, {$prefix}options WHERE {$prefix}options.id={$prefix}bets.option AND {$prefix}bets.competition=" . $_REQUEST['competition'] . " AND {$prefix}bets.option=" . $_REQUEST['winner'], $db);
				if ($bet_result && mysql_num_rows($bet_result)) {
					while ($bet_row = mysql_fetch_array($bet_result)) {
						$better = $roster->GetPerson($bet_row['user']);
						$better->MakeSale($bet_row['amount'] * $bet_row['odds'], '', 'winning bet');
					}
				}
				echo 'The competition winner has been set, and the winning bets have been paid out.';
			}
			else {
				echo 'Error setting competition winner: ' . mysql_error($db);
			}
		}
		else {
			$form = new Form($page);
			$form->AddHidden('competition', $_REQUEST['competition']);
			$form->StartSelect('Winner:', 'winner');
			$option_result = mysql_query("SELECT * FROM {$prefix}options WHERE competition=" . $_REQUEST['competition'] . ' ORDER BY name ASC', $db);
			while ($option_row = mysql_fetch_array($option_result)) {
				$form->AddOption($option_row['id'], stripslashes($option_row['name']));
			}
			$form->EndSelect();
			$form->AddSubmitButton('', 'Save Winner');
			$form->EndForm();
		}
	}
	else {
		$sql = "SELECT {$prefix}competitions.id, CONCAT({$prefix}sports.name, ': ', {$prefix}competitions.name) AS name FROM {$prefix}competitions, {$prefix}sports WHERE {$prefix}competitions.sport={$prefix}sports.id AND {$prefix}competitions.winner=0";
		if (empty($valid['global'])) {
			$sql .= " AND {$prefix}sports.id IN (" . implode(',', $valid) . ')';
		}
		$sql .= ' ORDER BY name ASC';
		$comp_result = mysql_query($sql, $db);
		if ($comp_result && mysql_num_rows($comp_result)) {
			$form = new Form($page);
			$form->StartSelect('Competition:', 'competition');
			while ($comp_row = mysql_fetch_array($comp_result)) {
				$form->AddOption($comp_row['id'], stripslashes($comp_row['name']));
			}
			$form->EndSelect();
			$form->AddSubmitButton('', 'Set Competition Winner');
			$form->EndForm();
		}
		else {
			echo 'No competitions are currently open and able to be deleted.';
		}
	}

	bb_admin_footer($valid);
}
?>
