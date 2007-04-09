<?php
include('header.php');
page_header('Writer Statistics');

// Array of all tacticians: key is the last mission set, value the roster ID.
$tacticians = array(9=>106, 12=>183, 18=>160, 19=>95, 22=>108, 28=>257, 31=>1622, 
		33=>135, 51=>666, 63=>275, 67=>1829, 68=>666, 76=>2815, 88=>1187, 90=>2006,
		91=>2978, 1000=>95);

function mission_total($missions, $start, $end) {
	$total = 0;
	foreach ($missions as $mset=>$oms) {
		if ($mset >= $start && $mset <= $end) {
			$total += $oms;
		}
	}
	return $total;
}

$authors_result = mysql_query('SELECT author, COUNT(DISTINCT id) AS oms FROM missions WHERE hidden=0 GROUP BY author ORDER BY oms DESC, mset ASC', $db);
if ($authors_result && mysql_num_rows($authors_result)) {
	$table = new Table();
	$table->StartRow();
	$table->AddHeader('&nbsp;', 1, 2);
	$table->AddHeader('Name', 1, 2);
	$table->AddHeader('Tacticians', count($tacticians));
	$table->AddHeader('Totals', 1, 2);
	$table->EndRow();
	$table->StartRow();
	foreach ($tacticians as $tact) {
		$tact = $roster->GetPerson($tact);
		$words = explode(' ', $tact->GetName());
		$table->AddHeader(roster_link($tact, substr($words[0], 0, 4)));
	}
	$table->EndRow();
	$row_no = 0;
	$last_oms = 0;
	$last_rank = 0;
	$om_totals = array();
	while ($row = mysql_fetch_array($authors_result)) {
		$pleb = $roster->GetPerson($row['author']);
		$words = explode(' ', $pleb->GetName());
		$name = $words[0];

		$row_no++;
		if ($row['oms'] != $last_oms) {
			$last_rank = $row_no;
			$last_oms = $row['oms'];
		}
		$table->StartRow();
		$table->AddCell($last_rank);
		$table->AddCell(roster_link($pleb, $name));
		$missions_result = mysql_query('SELECT mset, COUNT(DISTINCT id) AS oms FROM missions WHERE hidden=0 AND author=' . $pleb->GetID() . ' GROUP BY mset ORDER BY mset ASC', $db);
		unset($missions);
		while ($mission = mysql_fetch_array($missions_result)) {
			$missions[$mission['mset']] = $mission['oms'];
		}
		$last_mset = 0;
		$om_totals[0] += $row['oms'];
		foreach ($tacticians as $mset=>$key) {
			$oms = mission_total($missions, $last_mset, $mset);
			$table->AddCell('<DIV ALIGN="right">' . number_format($oms) . '</DIV>');
			$om_totals[$mset] += $oms;
			$last_mset = $mset + 1;
		}
		$table->AddCell('<DIV ALIGN="right"><B>' . number_format($row['oms']) . '</B></DIV>');
		$table->EndRow();
	}
	$table->StartRow();
	$table->AddCell('&nbsp;');
	$table->AddCell('<B>Totals</B>');
	foreach ($tacticians as $mset=>$key) {
		$table->AddCell('<DIV ALIGN="right"><B>' . number_format($om_totals[$mset]) . '</B></DIV>');
	}
	$table->AddCell('<DIV ALIGN="right"><B>' . number_format($om_totals[0]) . '</B></DIV>');
	$table->EndRow();
	$table->EndTable();
}

page_footer();
?>
