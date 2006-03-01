<?php
include_once('header.php');

if (empty($_REQUEST['order'])) {
	$_REQUEST['order'] = 'points';
	$_REQUEST['sort'] = 'desc';
}

page_header('Statistics Centre :: Hunters');

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
				$hunters[$row['person']]['pe'] = $hunters[$row['person']]['points'] / $hunters[$row['person']]['events'];
				$hunters[$row['person']]['kags'] += $row['kags'];
			}
			else {
				$hunter =& $roster->GetPerson($row['person']);
				$row['name'] = $hunter->GetName();
				$row['points'] = ScalePointsWithMaximum($points, $row['points'], $row['events']);
				$row['pe'] = $row['points'] / $row['events'];
				$hunters[$row['person']] = $row;
			}
		}
}

$func = "Sort{$_REQUEST['order']}{$_REQUEST['sort']}";
usort($hunters, $func);

$table = new Table('Hunters', true);
$table->StartRow();
create_sort_headers($table, array('name'=>'Name', 'points'=>'Scaled Points', 'events'=>'Completed Events', 'pe'=>'Sc.Pts/Event'));
$table->EndRow();

foreach ($hunters as $row) {
	$table->StartRow();
	$table->AddCell('<a href="../stats/hunter.php?id=' . $row['person'] . '">' . htmlspecialchars($row['name']) . '</a>');
	$table->AddCell('<div style="text-align: right">' . number_format($row['points']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($row['events']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($row['pe'], 1) . '</div>');
	$table->EndRow();
}

$table->EndTable();

page_footer();
?>
