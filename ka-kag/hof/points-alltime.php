<?php
include_once('header.php');
page_header('KAG Hall of Fame');
?>
			<div>
				<h2>KAG Hall of Fame :: Most Points (All-Time)</h2>
				<p>Some hunters accumulate their points steadily over many KAGs, other flame like a shooting star for a handful of KAGs and seemingly gain points at will during that period. But whether they are a tortoise or a hare, the hunters on this list have proven over time that they are the best of the best.</p>
			</div>
<?php
$table = new Table();
$table->StartRow();
$table->AddHeader('');
$table->AddHeader('Hunter');
$table->AddHeader('Points');
$table->AddHeader('KAGs');
$table->AddHeader('Completed Events');
$table->EndRow();

$result = mysql_query('SELECT person, SUM(points) AS points, COUNT(DISTINCT id) AS events, COUNT(DISTINCT kag) AS kags FROM kag_signups WHERE state > 0 GROUP BY person ORDER BY points DESC, events ASC LIMIT 10', $db);
if ($result && mysql_num_rows($result)) {
	$rank = 0;
	while ($row = mysql_fetch_array($result)) {
		$hunter =& $roster->GetPerson($row['person']);
		$table->StartRow();
		$table->AddCell('<div style="text-align: right">' . number_format(++$rank) . '</div>');
		$table->AddCell('<a href="../stats/hunter.php?id=' . $hunter->GetID() . '">' . htmlspecialchars($hunter->GetName()) . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['points']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['kags']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['events']) . '</div>');
		$table->EndRow();
	}
}

$table->EndTable();

page_footer();
?>
