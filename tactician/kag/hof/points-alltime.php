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
$table->AddHeader('Scaled Points');
$table->AddHeader('KAGs');
$table->AddHeader('Completed Events');
$table->EndRow();

$maxima = GetKAGMaxima();
$hunters = array();
foreach (array_unique($maxima) as $points) {
	$kags = implode(', ', array_keys($maxima, $points));
	$result = mysql_query("SELECT person, SUM(points) AS points, COUNT(DISTINCT id) AS events, COUNT(DISTINCT kag) AS kags FROM kag_signups WHERE state > 0 AND kag IN ($kags) GROUP BY person ORDER BY person", $db);
	if ($result && mysql_num_rows($result))
		while ($row = mysql_fetch_array($result)) {
			if (isset($hunters[$row['person']])) {
				$hunters[$row['person']]['points'] += ScalePointsWithMaximum($points, $row['points'], $row['events']);
				$hunters[$row['person']]['events'] += $row['events'];
				$hunters[$row['person']]['kags'] += $row['kags'];
			}
			else {
				$row['points'] = ScalePointsWithMaximum($points, $row['points'], $row['events']);
				$hunters[$row['person']] = $row;
			}
		}
}

usort($hunters, 'SortPointsDesc');

for ($i = 0; $i < 10; $i++) {
	$hunter =& $roster->GetPerson($hunters[$i]['person']);
	$table->StartRow();
	$table->AddCell('<div style="text-align: right">' . number_format($i + 1) . '</div>');
	$table->AddCell('<a href="../stats/hunter.php?id=' . $hunter->GetID() . '">' . htmlspecialchars($hunter->GetName()) . '</a>');
	$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['points']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['kags']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['events']) . '</div>');
	$table->EndRow();
}

$table->EndTable();

page_footer();
?>
