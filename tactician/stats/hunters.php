<?php
$min = 5;

include('../header.php');
page_header('Hunter Statistics');

echo 'Minimum: ' . $min . ' answers<HR NOSHADE>';

$hunters = array();
$totals = array();

$result = mysql_query('SELECT answers.person, COUNT(DISTINCT answers.id) AS num FROM answers, missions WHERE answers.mission=missions.id AND answers.correct=1 GROUP BY answers.person', $db);
while ($row = mysql_fetch_array($result)) {
	if ($row['num'] > $min) {
		$hunters[$row['person']] = $row['num'];
	}
}

$result = mysql_query('SELECT answers.person, COUNT(DISTINCT answers.id) AS num FROM answers, missions WHERE answers.mission=missions.id GROUP BY answers.person', $db);
while ($row = mysql_fetch_array($result)) {
	if (isset($hunters[$row['person']])) {
		$hunters[$row['person']] /= $row['num'];
		$totals[$row['person']] = $row['num'];
	}
}

arsort($hunters);

$table = new Table();
$table->StartRow();
$table->AddHeader('&nbsp;');
$table->AddHeader('Hunter');
$table->AddHeader('Answers');
$table->AddHeader('Correct');
$table->EndRow();

$row_no = 0;
$last_rank = 0;
$last_perc = -1;

foreach ($hunters as $rid=>$perc) {
	$perc *= 100;
	$row_no++;
	if ($perc != $last_perc) {
		$last_perc = $perc;
		$last_rank = $row_no;
	}
	
	$table->AddRow(number_format($last_rank), roster_link($rid), number_format($totals[$rid]), number_format($perc, 1) . '%');
}

$table->EndTable();

page_footer();
?>
