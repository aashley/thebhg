<?php
function title() {
	return 'Survey Results';
}

function auth($person) {
	return ($person->GetID() == 666 || $person->GetID() == 94);
}

function output() {
	global $db, $roster;
	
	roster_header();

	// Get the total number of respondents.
	$r_result = mysql_query('SELECT COUNT(DISTINCT person) AS people FROM qa_answers', $db);
	$total = mysql_result($r_result, 0, 'people');

	echo 'Total respondents: ' . $total;

	$q_result = mysql_query('SELECT * FROM qa_questions WHERE type IN ("dropdown", "multiple") ORDER BY section, id', $db);
	while ($q_row = mysql_fetch_array($q_result)) {
		hr();
		$table = new Table(stripslashes($q_row['question']));
		$a_result = mysql_query('SELECT * FROM qa_options WHERE question=' . $q_row['id'] . ' ORDER BY id', $db);
		$q_total = $total;
		$table->StartRow();
		$table->AddHeader('Answer');
		$table->AddHeader('People');
		if ($q_row['type'] == 'dropdown') {
			$table->AddHeader('Percentage');
		}
		$table->EndRow();
		while ($a_row = mysql_fetch_array($a_result)) {
			if ($q_row['type'] == 'dropdown') {
				$result = mysql_query('SELECT COUNT(DISTINCT person) AS people FROM qa_answers WHERE question=' . $q_row['id'] . ' AND answer="' . $a_row['id'] . '"', $db);
			}
			else {
				$result = mysql_query('SELECT COUNT(DISTINCT person) AS people FROM qa_answers WHERE question=' . $q_row['id'] . ' AND answer LIKE "%' . $a_row['id'] . '%"', $db);
			}
			if (mysql_num_rows($result)) {
				$row = mysql_fetch_array($result);
				$r_people = $row['people'];
			}
			else {
				$r_people = 0;
			}
			$q_total -= $r_people;
			$perc = number_format(100 * ($r_people / $total), 1) . '%';
			$table->StartRow();
			$table->AddCell(stripslashes($a_row['name']));
			$table->AddCell(number_format($r_people));
			if ($q_row['type'] == 'dropdown') {
				$table->AddCell($perc);
			}
			$table->EndRow();
		}
		if ($q_row['type'] == 'dropdown') {
			$table->StartRow();
			$table->AddCell('Did not answer');
			$table->AddCell(number_format($q_total));
			$table->AddCell(number_format(100 * ($q_total / $total), 1) . '%');
			$table->EndRow();
		}
		$table->EndTable();
	}

	roster_footer();
}
?>
