<?php
include_once('header.php');
page_header('KAG Hall of Fame');
?>
			<div>
				<h2>KAG Hall of Fame :: Highest Point Average</h2>
				<p>Some hunters prefer to specialise in their own pet events, rather than competing in a broad range of events. This is reflected by their high average of points per event, although they may not have a high overall point total. This table shows the hunters who have the highest average of all.</p>
				<p>Qualification: Minimum ten events.</p>
			</div>
<?php
$table = new Table();
$table->StartRow();
$table->AddHeader('');
$table->AddHeader('Hunter');
$table->AddHeader('Point Average');
$table->AddHeader('Points');
$table->AddHeader('KAGs');
$table->AddHeader('Completed Events');
$table->EndRow();

$result = mysql_query('SELECT person, SUM(points) AS points, COUNT(DISTINCT id) AS events, COUNT(DISTINCT kag) AS kags, SUM(points)/COUNT(DISTINCT id) AS pav FROM kag_signups WHERE state > 0 GROUP BY person ORDER BY pav DESC, points DESC, events ASC, kags ASC', $db);
if ($result && mysql_num_rows($result)) {
	$rank = 0;
	while (($row = mysql_fetch_array($result)) && $rank < 10) {
		if ($row['events'] >= 10) {
			$hunter =& $roster->GetPerson($row['person']);
			$table->StartRow();
			$table->AddCell('<div style="text-align: right">' . number_format(++$rank) . '</div>');
			$table->AddCell('<a href="../stats/hunter.php?id=' . $hunter->GetID() . '">' . htmlspecialchars($hunter->GetName()) . '</a>');
			$table->AddCell('<div style="text-align: right">' . number_format($row['pav'], 1) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($row['points']) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($row['kags']) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($row['events']) . '</div>');
			$table->EndRow();
		}
	}
}

$table->EndTable();

page_footer();
?>
