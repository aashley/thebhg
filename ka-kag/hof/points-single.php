<?php
include_once('header.php');
page_header('KAG Hall of Fame');
?>
			<div>
				<h2>KAG Hall of Fame :: Most Points (Single KAG)</h2>
				<p>High scoring hunters. Hunters love them when they're in the same kabal as them, and hate them when they're in opposing kabals. The ability to dominate a KAG is a rare one, and can be the difference between a kabal receiving a Badge of Supremacy or not. These hunters have shown that they can take a KAG by the scruff of the neck and dominate it.</p>
			</div>
<?php
$table = new Table();
$table->StartRow();
$table->AddHeader('');
$table->AddHeader('Hunter');
$table->AddHeader('Kabal');
$table->AddHeader('KAG');
$table->AddHeader('Points');
$table->AddHeader('Completed Events');
$table->EndRow();

$result = mysql_query('SELECT person, SUM(points) AS points, COUNT(DISTINCT id) AS events, kag, kabal FROM kag_signups WHERE state > 0 GROUP BY person, kag ORDER BY points DESC, events ASC, kag ASC LIMIT 10', $db);
if ($result && mysql_num_rows($result)) {
	$rank = 0;
	while ($row = mysql_fetch_array($result)) {
		$hunter =& $roster->GetPerson($row['person']);
		$kabal =& $roster->GetKabal($row['kabal']);
		$table->StartRow();
		$table->AddCell('<div style="text-align: right">' . number_format(++$rank) . '</div>');
		$table->AddCell('<a href="../hunter.php?kag=' . $row['kag'] . '&amp;id=' . $hunter->GetID() . '">' . htmlspecialchars($hunter->GetName()) . '</a>');
		$table->AddCell('<a href="../kabal.php?kag=' . $row['kag'] . '&amp;kabal=' . $kabal->GetID() . '">' . htmlspecialchars($kabal->GetName()) . '</a>');
		$table->AddCell('<a href="../kag.php?id=' . $row['kag'] . '">KAG ' . roman($row['kag']) . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['points']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['events']) . '</div>');
		$table->EndRow();
	}
}

$table->EndTable();

page_footer();
?>
