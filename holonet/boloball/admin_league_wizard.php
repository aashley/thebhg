<?php
function title() {
	return 'Administration :: League Wizard';
}

function auth($user) {
	global $valid;

	$valid = bb_get_sports($user);
	return $valid;
}

function output() {
	global $prefix, $db, $valid, $page;

	bb_header();

	if ($_REQUEST['ties']) {
		if ($_REQUEST['tie'] == 0) {
			$start = parse_date_box('start');
			$end = parse_date_box('end');
		}
		else {
			$start = $_REQUEST['start'];
			$end = $_REQUEST['end'];
			$name = $_REQUEST['name'] . ' (' . $_REQUEST['options'][0] . ' vs ' . $_REQUEST['options'][1] . ')';
			if (mysql_query("INSERT INTO {$prefix}competitions (sport, name, description, start, end) VALUES (" . $_REQUEST['sport'] . ', "' . addslashes($name) . '", "' . addslashes($_REQUEST['description']) . '", ' . $_REQUEST['start'] . ', ' . $_REQUEST['end'] . ')', $db)) {
				$cid = mysql_insert_id($db);
				foreach ($_REQUEST['options'] as $id=>$option) {
					mysql_query("INSERT INTO {$prefix}options (competition, name, odds) VALUES ($cid, \"" . addslashes($option) . '", ' . parse_odds($_REQUEST['bets'][$id]) . ')', $db);
				}
			}
			else {
				echo 'Error adding competition: ' . mysql_error($db);
				bb_admin_footer($valid);
				return;
			}
		}
		
		if ($_REQUEST['tie'] >= $_REQUEST['ties']) {
			echo 'Your league has been saved.';
		}
		else {
			echo 'Odds should be entered in the n.nn form, not the x/y form. For example, to input odds of 2/1 (where you get 3 ICs for every 1 IC you outlay), you would enter the odds as "3".';
			hr();

			$form = new Form($page);
			$form->AddHidden('tie', $_REQUEST['tie'] + 1);
			$form->AddHidden('ties', $_REQUEST['ties']);
			$form->AddHidden('sport', $_REQUEST['sport']);
			$form->AddHidden('name', $_REQUEST['name']);
			$form->AddHidden('description', $_REQUEST['description']);
			$form->AddHidden('start', $start);
			$form->AddHidden('end', $end);
			$form->AddHidden('opium', $_REQUEST['opium']);

			$form->table->StartRow();
			$form->table->AddHeader('Team Name');
			$form->table->AddHeader('Odds');
			$form->table->EndRow();

			for ($i = 0; $i < $_REQUEST['opium']; $i++) {
				$form->table->StartRow();
				$form->table->AddCell('<input type="text" name="options[' . $i . ']" size="20">');
				$form->table->AddCell('<input type="text" name="bets[' . $i . ']" size="10">');
				$form->table->EndRow();
			}

			if (($_REQUEST['tie'] + 1) == $_REQUEST['ties']) {
				$form->AddSubmitButton('', 'Finish');
			}
			else {
				$form->AddSubmitButton('', 'Next >>');
			}
			$form->EndForm();
		}
	}
	else {
		$form = new Form($page);
		$form->AddHidden('tie', '0');

		if ($valid['global'] || count($valid) > 1) {
			$form->StartSelect('Sport:', 'sport');
			if ($valid['global']) {
				$sports_result = mysql_query("SELECT * FROM {$prefix}sports ORDER BY name ASC", $db);
			}
			else {
				$sports_result = mysql_query("SELECT * FROM {$prefix}sports WHERE id IN (" . implode(',', $valid) . ') ORDER BY name ASC', $db);
			}
			if ($sports_result && mysql_num_rows($sports_result)) {
				while ($sport_row = mysql_fetch_array($sports_result)) {
					$form->AddOption($sport_row['id'], stripslashes($sport_row['name']));
				}
			}
			$form->EndSelect();
		}
		else {
			$sports_result = mysql_query("SELECT * FROM {$prefix}sports WHERE id=" . $valid[0], $db);
			$form->AddHidden('sport', mysql_result($sports_result, 0, 'id'));
			$form->table->AddRow('Sport:', stripslashes(mysql_result($sports_result, 0, 'name')));
		}

		$form->AddTextBox('Name:', 'name', '', 40);
		$form->AddTextArea('Description:', 'description');
		$form->AddDateBox('Start of Betting:', 'start', time(), true);
		$form->AddDateBox('End of Betting:', 'end', 0, true);
		$form->AddTextBox('Number of Matches:', 'ties', '', 4);
		$form->AddTextBox('Number of Options Per Match:', 'opium', '2', 4);
		$form->AddSubmitButton('', 'Next >>');
		
		$form->EndForm();
	}

	bb_admin_footer($valid);
}
?>
