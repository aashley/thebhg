<?php
function title() {
	return 'Administration :: Delete Competition';
}

function auth($user) {
	global $valid;

	$valid = bb_get_sports($user);
	return $valid;
}

function output() {
	global $prefix, $db, $page, $valid, $roster;

	bb_header();

	echo 'Remember that deleting a competition will also refund all the bets made. You cannot delete already completed competitions.';
	hr();

	if ($_REQUEST['competition']) {
		if (mysql_query("DELETE FROM {$prefix}competitions WHERE id=" . $_REQUEST['competition'], $db)) {
			$bet_result = mysql_query("SELECT * FROM {$prefix}bets WHERE competition=" . $_REQUEST['competition'], $db);
			if ($bet_result && mysql_num_rows($bet_result)) {
				while ($bet_row = mysql_fetch_array($bet_result)) {
					$better = $roster->GetPerson($bet_row['user']);
					$better->MakeSale($bet_row['amount'], '', 'bet refund');
				}
			}
			mysql_query("DELETE FROM {$prefix}bets WHERE competition=" . $_REQUEST['competition'], $db);
			mysql_query("DELETE FROM {$prefix}options WHERE competition=" . $_REQUEST['competition'], $db);
			echo 'The competition has been deleted, and all bets have been refunded.';
		}
		else {
			echo 'Error deleting competition: ' . mysql_error($db);
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
			$form->AddSubmitButton('', 'Delete Competition');
			$form->EndForm();
		}
		else {
			echo 'No competitions are currently open and able to be deleted.';
		}
	}

	bb_admin_footer($valid);
}
?>
