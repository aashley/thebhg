<?php
function title() {
	return 'Arena Challenge Centre';
}

function coders() {
	return array(666, 85, 1699);
}

function auth($pleb) {
	global $user, $roster;
	$user = $pleb;
	$div = $pleb->GetDivision();
	return ($div->GetID() != 0 && $div->GetID() != 16);
}

function output() {
	global $db, $page, $email_headers, $user, $roster, $lyarna_db;
	
	$rules_query = mysql_query('SELECT * FROM arena_rules', $db);

	echo 'Welcome, ' . $user->GetName() . '.<br><br>';

	$challenges = mysql_query('SELECT id, challenger, challenge_time FROM arena WHERE challengee=' . $user->GetID() . ' AND status=0', $db);
	if ($challenges && mysql_num_rows($challenges)) {
		$table = new Table('Pending Challenges', true);
		$table->StartRow();
		$table->AddHeader('Challenger');
		$table->AddHeader('Date');
		$table->AddHeader('&nbsp;', 2);
		$table->EndRow();
		while ($row = mysql_fetch_array($challenges)) {
			$challenger = $roster->GetPerson($row['challenger']);
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link('hunter', array('id'=>$challenger->GetID()), 'roster') . '">' . $challenger->GetName() . '</a>');
			$table->AddCell(date('j M Y', $row['challenge_time']));
			$table->AddCell('<a href="' . internal_link('acc_accept', array('id'=>$row['id'])) . '">Accept</a>');
			$table->AddCell('<a href="' . internal_link('acc_decline', array('id'=>$row['id'])) . '">Decline</a>');
			$table->EndRow();
		}
		$table->EndTable();
	}
	else {
		echo 'You have no challenges pending.';
	}

	hr();

	$form = new Form('acc_confirm', 'post', '', '', 'Challenge Another Hunter');
	$form->table->StartRow();
	$form->table->AddCell('Has another hunter irritated you? Perhaps they\'ve stolen your ship. Or, worse, your lawn gnome. Now you can challenge them to a fight in the Arena!', 2);
	$form->table->EndRow();
	$form->StartSelect('Hunter to Challenge:', 'challengee');
	hunter_dropdown($form);
	$form->EndSelect();
	$form->AddTextBox('Number of Weapons (0-5)', 'num_weapons', '', 1);
	$form->StartSelect('Weapon Type:', 'type_weapon');
	$types = mysql_query('SELECT * FROM arena_weapons', $db);
	while ($row = mysql_fetch_array($types)) {
		$form->AddOption($row['id'], stripslashes($row['weapon']));
	}
	$form->EndSelect();
	$locations = array();
	$loc_result = mysql_query('SELECT id, name FROM complex WHERE arena=1', $lyarna_db);
	while ($row = @mysql_fetch_array($loc_result)) {
		$locations[$row['id']] = stripslashes($row['name']);
	}
	$loc_result = mysql_query('SELECT id, name FROM estate WHERE arena=1', $lyarna_db);
	while ($row = @mysql_fetch_array($loc_result)) {
		$locations[$row['id']] = stripslashes($row['name']);
	}
	$loc_result = mysql_query('SELECT id, name FROM hq WHERE arena=1', $lyarna_db);
	while ($row = @mysql_fetch_array($loc_result)) {
		$locations[$row['id']] = stripslashes($row['name']);
	}
	asort($locations);
	$form->StartSelect('Location:', 'location', $locations[array_rand($locations)]);
	foreach ($locations as $lid=>$lname) {
		$form->AddOption($lname, $lname);
	}
	$form->EndSelect();
	$form->StartSelect('Rules:', 'rules');
	while ($rule = mysql_fetch_array($rules_query)) {
		$form->AddOption($rule['id'], stripslashes($rule['rule']));
	}
	$form->EndSelect();
	$form->AddTextBox('Post Count (3-5):', 'post_count', '', 1);
	$form->AddSubmitButton('submit', 'Challenge');
	$form->EndForm();

	hr();

	$table = new Table('Explanation of Rules', true);
	mysql_data_seek($rules_query, 0);
	while ($rule = mysql_fetch_array($rules_query)) {
		$table->AddRow(stripslashes($rule['rule']), nl2br(stripslashes($rule['definition'])));
	}
	$table->EndTable();

	hr();

	echo '<a href="' . internal_link('acc_admin') . '">Admin</a>';
}
?>
