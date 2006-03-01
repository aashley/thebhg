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
$table->AddHeader('Scaled Points');
$table->AddHeader('Completed Events');
$table->EndRow();

$maxima = GetKAGMaxima();
$hunters = array();
foreach (array_unique($maxima) as $points) {
	$kags = implode(', ', array_keys($maxima, $points));
	$result = mysql_query("SELECT person, SUM(points) AS points, COUNT(DISTINCT id) AS events, kabal, kag FROM kag_signups WHERE state > 0 AND kag IN ($kags) GROUP BY person, kag ORDER BY points DESC, events ASC LIMIT 10", $db);
	if ($result && mysql_num_rows($result))
		while ($row = mysql_fetch_array($result)) {
			$row['points'] = ScalePointsWithMaximum($points, $row['points'], $row['events']);
			$hunters[] = $row;
		}
}

usort($hunters, 'SortPointsDesc');

for ($i = 0; $i < 10; $i++) {
	$hunter =& $roster->GetPerson($hunters[$i]['person']);
	$kabal =& $roster->GetKabal($hunters[$i]['kabal']);
	$table->StartRow();
	$table->AddCell('<div style="text-align: right">' . number_format($i + 1) . '</div>');
	$table->AddCell('<a href="../stats/hunter.php?id=' . $hunter->GetID() . '">' . htmlspecialchars($hunter->GetName()) . '</a>');
	$table->AddCell('<a href="../kabal.php?kag=' . $row['kag'] . '&amp;kabal=' . $kabal->GetID() . '">' . htmlspecialchars($kabal->GetName()) . '</a>');
	$table->AddCell('<a href="../kag.php?id=' . $hunters[$i]['kag'] . '">KAG ' . roman($hunters[$i]['kag']) . '</a>');
	$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['points']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['events']) . '</div>');
	$table->EndRow();
}

$table->EndTable();

page_footer();
?>
