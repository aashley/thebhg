<?php
function title() {
	return 'Administration :: Add Competition';
}

function auth($user) {
	global $valid;

	$valid = bb_get_sports($user);
	return $valid;
}

function output() {
	global $prefix, $db, $valid, $page;

	bb_header();

	if ($_REQUEST['sport']) {
		if ($_REQUEST['options']) {
			if (mysql_query("INSERT INTO {$prefix}competitions (sport, name, description, start, end) VALUES (" . $_REQUEST['sport'] . ', "' . addslashes($_REQUEST['name']) . '", "' . addslashes($_REQUEST['description']) . '", ' . $_REQUEST['start'] . ', ' . $_REQUEST['end'] . ')', $db)) {
				$cid = mysql_insert_id($db);
				foreach ($_REQUEST['options'] as $id=>$option) {
					mysql_query("INSERT INTO {$prefix}options (competition, name, odds) VALUES ($cid, \"" . addslashes($option) . '", ' . parse_odds($_REQUEST['bets'][$id]) . ')', $db);
				}
				echo 'Competition and options saved.';
			}
			else {
				echo 'Error adding competition: ' . mysql_error($db);
			}
		}
		else {
			echo 'Odds may be entered in either the n.nn form, or the x/y form. For example, to input odds of 2/1 (where you get 3 ICs for every 1 IC you outlay), you could enter the odds as "3.00" or "2/1".';
			hr();
			
			$form = new Form($page);
			$form->AddHidden('sport', $_REQUEST['sport']);
			$form->AddHidden('name', $_REQUEST['name']);
			$form->AddHidden('description', $_REQUEST['description']);
			$form->AddHidden('start', parse_date_box('start'));
			$form->AddHidden('end', parse_date_box('end'));
			$form->AddHidden('optnum', $_REQUEST['optnum']);

			$form->table->StartRow();
			$form->table->AddHeader('Option Name');
			$form->table->AddHeader('Odds');
			$form->table->EndRow();

			for ($i = 0; $i < $_REQUEST['optnum']; $i++) {
				$form->table->StartRow();
				$form->table->AddCell('<input type="text" name="options[' . $i . ']" size="20">');
				$form->table->AddCell('<input type="text" name="bets[' . $i . ']" size="10">');
				$form->table->EndRow();
			}

			$form->AddSubmitButton('', 'Save Competition');
			$form->EndForm();
		}
	}
	else {
		$form = new Form($page);
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
		$form->AddTextBox('Number of Options:', 'optnum', '', 4);
		$form->AddSubmitButton('', 'Add Competition');
		
		$form->EndForm();
	}

	bb_admin_footer($valid);
}
