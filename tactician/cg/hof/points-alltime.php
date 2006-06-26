<?php
include_once('header.php');
page_header('CG Hall of Fame');
?>
			<div>
				<h2>CG Hall of Fame :: Most Points (All-Time)</h2>
				<p>Some hunters accumulate their points steadily over many CGs, other flame like a shooting star for a handful of CGs and seemingly gain points at will during that period. But whether they are a tortoise or a hare, the hunters on this list have proven over time that they are the best of the best.</p>
			</div>
<?php
$table = new Table();
$table->StartRow();
$table->AddHeader('');
$table->AddHeader('Hunter');
$table->AddHeader('Points');
$table->AddHeader('CGs');
$table->AddHeader('Completed Events');
$table->EndRow();

$result = mysql_query('SELECT cg_signups.person, SUM(cg_signups.points) AS points, COUNT(DISTINCT cg_signups.id) AS events, COUNT(DISTINCT cg_signups.cg) AS cgs FROM cg_signups, cg_events WHERE cg_signups.state > 0 AND cg_events.id = cg_signups.event AND cg_events.team = 0 GROUP BY cg_signups.person ORDER BY points DESC, events ASC LIMIT 10', $db);
if ($result && mysql_num_rows($result)) {
	$rank = 0;
	while ($row = mysql_fetch_array($result)) {
		$hunter =& $roster->GetPerson($row['person']);
		$table->StartRow();
		$table->AddCell('<div style="text-align: right">' . number_format(++$rank) . '</div>');
		$table->AddCell('<a href="../stats/hunter.php?id=' . $hunter->GetID() . '">' . htmlspecialchars($hunter->GetName()) . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['points']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['cgs']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['events']) . '</div>');
		$table->EndRow();
	}
}

$table->EndTable();

page_footer();
?>
