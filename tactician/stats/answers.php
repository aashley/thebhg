<?php
include('../header.php');
page_header('Answer Statistics');

// All-time correct percentage.
$result = mysql_query('SELECT COUNT(DISTINCT answers.id) AS num FROM answers, missions WHERE answers.mission=missions.id AND missions.complete=1', $db);
$total = mysql_result($result, 0, 'num');
echo 'Total answers: ' . number_format($total) . '<BR>';
$result = mysql_query('SELECT COUNT(DISTINCT answers.id) AS num FROM answers, missions WHERE answers.correct=1 AND answers.mission=missions.id AND missions.complete=1', $db);
$correct = mysql_result($result, 0, 'num');
echo 'Correct answers: ' . number_format($correct) . ' (' . number_format(100 * ($correct / $total), 1) . '%)<BR>';

echo '<HR NOSHADE>';
$table = new Table();
$table->StartRow();
$table->AddHeader('Mission Set', 2);
$table->AddHeader('Missions');
$table->AddHeader('Answers');
$table->AddHeader('Per Mission');
$table->AddHeader('Correct Answers', 2);
$table->EndRow();
$set_result = mysql_query('SELECT missions.mset, MIN(answers.time) AS start FROM answers, missions WHERE missions.mset>=34 AND missions.id=answers.mission AND missions.complete=1 GROUP BY missions.mset ORDER BY missions.mset ASC', $db);
while ($row = mysql_fetch_array($set_result)) {
	$table->StartRow();
	$table->AddCell('<A HREF="set.php?mset=' . $row['mset'] . '">Set ' . $row['mset'] . '</A>');
	if ($row['start'] > 0) {
		$table->AddCell(date('j F Y', $row['start']));
	}
	else {
		$table->AddCell('&nbsp;');
	}

	$result = mysql_query('SELECT COUNT(*) AS num FROM missions WHERE mset=' . $row['mset'], $db);
	$missions = mysql_result($result, 0, 'num');
	$table->AddCell(number_format($missions));
	$result = mysql_query('SELECT COUNT(DISTINCT answers.id) AS num FROM answers, missions WHERE answers.mission=missions.id AND missions.complete=1 AND missions.mset=' . $row['mset'], $db);
	$total = mysql_result($result, 0, 'num');
	$table->AddCell(number_format($total));
	$table->AddCell(number_format($total / $missions, 1));
	$result = mysql_query('SELECT COUNT(DISTINCT answers.id) AS num FROM answers, missions WHERE answers.correct=1 AND answers.mission=missions.id AND missions.complete=1 AND missions.mset=' . $row['mset'], $db);
	$correct = mysql_result($result, 0, 'num');
	$table->AddCell(number_format($correct));
	$table->AddCell(number_format(100 * ($correct / $total), 1) . '%');

	$table->EndRow();
}
$table->EndTable();

page_footer();
?>
