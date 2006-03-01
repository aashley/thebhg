<?php
include('header.php');
page_header('Mission Set ' . $mset . ' Statistics');

// Overall set statistics.
$result = mysql_query('SELECT COUNT(*) AS num FROM missions WHERE mset=' . $mset, $db);
$missions = mysql_result($result, 0, 'num');
echo 'Missions: ' . number_format($missions) . '<BR>';
$result = mysql_query('SELECT COUNT(DISTINCT answers.id) AS num FROM answers, missions WHERE answers.mission=missions.id AND missions.complete=1 AND missions.mset=' . $mset, $db);
$total = mysql_result($result, 0, 'num');
echo 'Total answers: ' . number_format($total) . ' (' . number_format($total / $missions, 1) . ' per mission)<BR>';
$result = mysql_query('SELECT COUNT(DISTINCT answers.id) AS num FROM answers, missions WHERE answers.correct=1 AND answers.mission=missions.id AND missions.complete=1 AND missions.mset=' . $mset, $db);
$correct = mysql_result($result, 0, 'num');
echo 'Correct answers: ' . number_format($correct) . ' (' . number_format(100 * ($correct / $total), 1) . '%)<BR>';

echo '<HR NOSHADE>';
$table = new Table();
$table->StartRow();
$table->AddHeader('Mission');
$table->AddHeader('Author');
$table->AddHeader('Answers');
$table->AddHeader('Correct Answers', 2);
$table->EndRow();
$mission_result = mysql_query('SELECT * FROM missions WHERE mset=' . $mset . ' ORDER BY title ASC', $db);
while ($row = mysql_fetch_array($mission_result)) {
	$table->StartRow();
	$table->AddCell('<A HREF="../mission.php?id=' . $row['id'] . '">' . htmlspecialchars(stripslashes($row['title'])) . '</A>');
	$table->AddCell(roster_link($row['author']));
	$result = mysql_query('SELECT COUNT(DISTINCT answers.id) AS num FROM answers, missions WHERE answers.mission=missions.id AND missions.complete=1 AND missions.id=' . $row['id'], $db);
	$total = mysql_result($result, 0, 'num');
	$table->AddCell(number_format($total));
	$result = mysql_query('SELECT COUNT(DISTINCT answers.id) AS num FROM answers, missions WHERE answers.correct=1 AND answers.mission=missions.id AND missions.complete=1 AND missions.id=' . $row['id'], $db);
	$correct = mysql_result($result, 0, 'num');
	$table->AddCell(number_format($correct));
	$table->AddCell(number_format(100 * ($correct / $total), 1) . '%');
	$table->EndRow();
}
$table->EndTable();

page_footer();
?>
