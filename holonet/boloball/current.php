<?php
function title() {
	global $row;
	return 'Current Competitions';
}

function output() {
	global $prefix, $db;

	bb_header();

	$comp_result = mysql_query("SELECT {$prefix}competitions.id, {$prefix}competitions.sport AS sid, {$prefix}sports.name AS sport, {$prefix}competitions.name, {$prefix}competitions.start, {$prefix}competitions.end FROM {$prefix}competitions, {$prefix}sports WHERE {$prefix}competitions.sport={$prefix}sports.id AND {$prefix}competitions.start<=UNIX_TIMESTAMP() AND {$prefix}competitions.winner=0 AND {$prefix}competitions.end>=UNIX_TIMESTAMP() ORDER BY sport DESC, end DESC, name ASC", $db);
	if ($comp_result && mysql_num_rows($comp_result)) {
		$table = new Table('', true);
		$table->StartRow();
		$table->AddHeader('Sport');
		$table->AddHeader('Name');
		$table->AddHeader('Betting Ends');
		$table->EndRow();
		while ($comp_row = mysql_fetch_array($comp_result)) {
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link('sport', array('id'=>$comp_row['sid'])) . '">' . stripslashes($comp_row['sport']) . '</a>');
			$table->AddCell('<a href="' . internal_link('competition', array('id'=>$comp_row['id'])) . '">' . stripslashes($comp_row['name']) . '</a>');
			$table->AddCell(date('j F Y \a\t G:i:s T', $comp_row['end']));
			$table->EndRow();
		}
		$table->EndTable();
	}
	else {
		echo 'There are no current competitions.';
	}

	bb_footer();
}
?>

