<?php
function title() {
	return 'Place Bet';
}

function auth($pleb) {
	global $user;

	$user = $pleb;
	return true;
}

function output() {
	global $user, $prefix, $db, $page, $roster;

	bb_header();

	// The Global $user doesnt have the right permissions to call 
	// MakePurchase(). recreate it with the correct ones we then use this
	// one to MakePurchase()
	$realuser = $roster->GetPerson($user->GetID());

	$comp_result = mysql_query("SELECT * FROM {$prefix}competitions WHERE id=" . $_REQUEST['competition'], $db);
	$comp_row = mysql_fetch_array($comp_result);
	$sport_result = mysql_query("SELECT * FROM {$prefix}sports WHERE id=" . $comp_row['sport'], $db);
	$sport_row = mysql_fetch_array($sport_result);
	$opt_result = mysql_query("SELECT * FROM {$prefix}options WHERE id=" . $_REQUEST['option'], $db);
	$opt_row = mysql_fetch_array($opt_result);
	
	if ($comp_row['winner'] != 0 || $comp_row['end'] <= time()) {
		echo 'This competition is closed to any further bets.';
		bb_footer();
		return;
	}

	$table = new Table('Bet Information');
	$table->AddRow('Sport:', '<a href="' . internal_link('sport', array('id'=>$sport_row['id'])) . '">' . stripslashes($sport_row['name']) . '</a>');
	$table->AddRow('Competition:', '<a href="' . internal_link('competition', array('id'=>$_REQUEST['competition'])) . '">' . stripslashes($comp_row['name']) . '</a>');
	$table->AddRow('Option:', stripslashes($opt_row['name']) . ' (' . calculate_odds($opt_row['odds']) . ')');
	$table->EndTable();
	hr();

	if ($_REQUEST['amount']) {
		if ($_REQUEST['amount'] > $user->GetAccountBalance()) {
			echo 'You have insufficient funds for this bet.';
		}
		else {
			if (mysql_query("INSERT INTO {$prefix}bets (competition, `option`, amount, user) VALUES (" . $_REQUEST['competition'] . ', ' . $_REQUEST['option'] . ', ' . $_REQUEST['amount'] . ', ' . $user->GetID() . ')', $db)) {
				$realuser->MakePurchase($_REQUEST['amount'], '', 'bet on ' . stripslashes($comp_row['name']));
				echo 'Your bet has been placed successfully.';
			}
			else {
				echo 'Error placing bet: ' . mysql_error($db);
			}
		}
	}
	else {		
		$form = new Form($page);
		$form->AddHidden('competition', $_REQUEST['competition']);
		$form->AddHidden('option', $_REQUEST['option']);
		$form->AddTextBox('Amount to bet:', 'amount', '', 8);
		$form->AddSubmitButton('', 'Place Bet');
		$form->EndForm();
	}

	bb_footer();
}
?>
