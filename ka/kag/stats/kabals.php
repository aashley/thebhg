<?php
include_once('header.php');

if (empty($_REQUEST['order'])) {
	$_REQUEST['order'] = 'wins';
	$_REQUEST['sort'] = 'desc';
}

page_header('Statistics Centre :: Kabals');

$maxima = GetKAGMaxima();
$kabals = array();
foreach (array_unique($maxima) as $points) {
	$kags = implode(', ', array_keys($maxima, $points));
	$result = mysql_query("SELECT kabal, SUM(points) AS points, COUNT(DISTINCT id) AS signups FROM kag_signups WHERE state > 0 AND kag IN ($kags) GROUP BY kabal", $db);
	if ($result && mysql_num_rows($result)) {
		while ($row = mysql_fetch_array($result)) {
			if (isset($kabals[$row['kabal']]))
				$kabals[$row['kabal']]['points'] += ScalePointsWithMaximum($points, $row['points'], $row['signups']);
			else {
				$kabal =& $roster->GetDivision($row['kabal']);
				$row['points'] = ScalePointsWithMaximum($points, $row['points'], $row['signups']);
				$row['wins'] = 0;
				$row['name'] = $kabal->GetName();
				$kabals[$row['kabal']] = $row;
			}
		}
	}
}

foreach ($ka->GetKAGs() as $kag) {
	$totals = $kag->GetKabalTotals();
	if ($totals) {
		$kabals[key($totals)]['wins']++;
	}
}

$func = "Sort{$_REQUEST['order']}{$_REQUEST['sort']}";
usort($kabals, $func);

$table = new Table('', true);
$table->StartRow();
create_sort_headers($table, array('name'=>'Name', 'wins'=>'Wins', 'points'=>'Scaled Points'));
$table->EndRow();

foreach ($kabals as $array) {
	$table->StartRow();
	$table->AddCell('<a href="kabal.php?id=' . $array['kabal'] . '">' . $array['name'] . '</a>');
	$table->AddCell('<div style="text-align: right">' . number_format($array['wins']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($array['points']) . '</div>');
	$table->EndRow();
}

$table->EndTable();

page_footer();
?>
