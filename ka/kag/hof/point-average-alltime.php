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
$table->AddHeader('Scaled Point Average');
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
				$hunters[$row['person']]['pe'] = $hunters[$row['person']]['points'] / $hunters[$row['person']]['events'];
			}
			else {
				$row['points'] = ScalePointsWithMaximum($points, $row['points'], $row['events']);
				$row['pe'] = $row['points'] / $row['events'];
				$hunters[$row['person']] = $row;
			}
		}
}

usort($hunters, 'SortPEDesc');

$rank = 0;
$i = -1;
while ($rank < 10 && ++$i < count($hunters)) {
	if ($hunters[$i]['events'] < 10)
		continue;
	
	$hunter =& $roster->GetPerson($hunters[$i]['person']);
	$table->StartRow();
	$table->AddCell('<div style="text-align: right">' . number_format(++$rank) . '</div>');
	$table->AddCell('<a href="../stats/hunter.php?id=' . $hunter->GetID() . '">' . htmlspecialchars($hunter->GetName()) . '</a>');
	$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['pe'], 1) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['points']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['kags']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['events']) . '</div>');
	$table->EndRow();
}

$table->EndTable();

page_footer();
?>
