<?php
if ($_REQUEST['id']) {
	$result = mysql_query("SELECT * FROM {$prefix}sports WHERE id=" . $_REQUEST['id'], $db);
	$row = mysql_fetch_array($result);
}

function title() {
	global $row;
	return 'Sport :: ' . stripslashes($row['name']);
}

function output() {
	global $row, $prefix, $db, $roster;

	bb_header();

	echo nl2br(stripslashes($row['description']));
	$user_result = mysql_query("SELECT user FROM {$prefix}users WHERE sport=" . $_REQUEST['id'], $db);
	if ($user_result && mysql_num_rows($user_result)) {
		while ($user_row = mysql_fetch_array($user_result)) {
			$pleb = $roster->GetPerson($user_row['user']);
			$users[$pleb->GetName()] = '<a href="' . internal_link('hunter', array('id'=>$pleb->GetID()), 'roster') . '">' . $pleb->GetName() . '</a>';
		}
		ksort($users);
		echo '<br><br>Administrator(s): ' . implode(', ', $users);
	}
	hr();

	$comp_result = mysql_query("SELECT id, name, start, end, (winner = 0) AS open FROM {$prefix}competitions WHERE sport=" . $_REQUEST['id'] . ' AND start<=UNIX_TIMESTAMP() AND winner=0 ORDER BY open DESC, end DESC, name ASC', $db);
	if ($comp_result && mysql_num_rows($comp_result)) {
		$table = new Table('', true);
		$table->StartRow();
		$table->AddHeader('Name');
		$table->AddHeader('Status');
		$table->AddHeader('Betting Ends');
		$table->EndRow();
		while ($comp_row = mysql_fetch_array($comp_result)) {
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link('competition', array('id'=>$comp_row['id'])) . '">' . stripslashes($comp_row['name']) . '</a>');
			if ($comp_row['open']) {
				if ($comp_row['end'] > time()) {
					$table->AddCell('Open');
				}
				else {
					$table->AddCell('Closed (result pending)');
				}
				$table->AddCell(date('j F Y \a\t G:i:s T', $comp_row['end']));
			}
			else {
				$table->AddCell('Complete');
				$table->AddCell('N/A');
			}
			$table->EndRow();
		}
		$table->EndTable();
	}
	else {
		echo 'No competitions exist for this sport.';
	}

	bb_footer();
}
?>
