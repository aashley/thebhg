<?php
include_once('header.php');
page_header('CG Hall of Fame');
?>
			<div>
				<h2>CG Hall of Fame :: Highest Point Average</h2>
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
$table->AddHeader('CGs');
$table->AddHeader('Completed Events');
$table->EndRow();

$result = mysql_query('SELECT cg_signups.person, SUM(cg_signups.points) AS points, COUNT(DISTINCT cg_signups.id) AS events, COUNT(DISTINCT cg_signups.cg) AS cgs, SUM(cg_signups.points)/COUNT(DISTINCT cg_signups.id) AS pav FROM cg_signups, cg_events WHERE cg_signups.state > 0 AND cg_events.id = cg_signups.event AND cg_events.team = 1 GROUP BY cg_signups.person ORDER BY pav DESC, points DESC, events ASC, cgs ASC', $db);
echo mysql_error($db);
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
			$table->AddCell('<div style="text-align: right">' . number_format($row['cgs']) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($row['events']) . '</div>');
			$table->EndRow();
		}
	}
}

$table->EndTable();

page_footer();
?>
