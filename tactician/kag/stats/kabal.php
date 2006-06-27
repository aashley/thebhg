<?php
include_once('header.php');

if (empty($_REQUEST['order'])) {
	$_REQUEST['order'] = 'points';
	$_REQUEST['sort'] = 'desc';
}

$kabal =& $roster->GetKabal($_REQUEST['id']);
page_header('Statistics Centre :: ' . $kabal->GetName() . ' Kabal');

$table = new Table('KAGs', true);
$table->StartRow();
$table->AddHeader('KAG');
$table->AddHeader('Points');
$table->AddHeader('Signups');
$table->AddHeader('DNPs');
$table->AddHeader('Points Per Signup');
$table->EndRow();

$result = mysql_query('SELECT kag, SUM(points) AS points, COUNT(DISTINCT id) AS signups FROM kag_signups WHERE kabal=' . $_REQUEST['id'] . ' GROUP BY kag ORDER BY kag DESC', $db);
if ($result && mysql_num_rows($result)) {
	while ($row = mysql_fetch_array($result)) {
		$table->StartRow();
		$table->AddCell('<a href="../kabal.php?kag=' . $row['kag'] . '&amp;kabal=' . $_REQUEST['id'] . '">KAG ' . roman($row['kag']) . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['points']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['signups']) . '</div>');
		$dnp_result = mysql_query('SELECT COUNT(DISTINCT id) AS signups FROM kag_signups WHERE kabal=' . $_REQUEST['id'] . ' AND kag=' . $row['kag'] . ' AND state=2', $db);
		if ($dnp_result && mysql_num_rows($dnp_result)) {
			$table->AddCell('<div style="text-align: right">' . number_format(mysql_result($dnp_result, 0, 'signups')) . '</div>');
		}
		else {
			$table->AddCell('0');
		}
		$table->AddCell('<div style="text-align: right">' . number_format(round(($row['points']/$row['signups']))) . '</div>');
		$table->EndRow();
	}
}

$table->EndTable();
echo '<br />';

$table = new Table('Hunters', true);
$table->StartRow();
create_sort_headers($table, array('name'=>'Name', 'points'=>'Scaled Points', 'events'=>'Completed Events', 'pe'=>'Sc.Pts/Event'));
$table->EndRow();

$maxima = GetKAGMaxima();
$hunters = array();
foreach (array_unique($maxima) as $points) {
	$kags = implode(', ', array_keys($maxima, $points));
	$result = mysql_query("SELECT person, SUM(points) AS points, COUNT(DISTINCT id) AS events, COUNT(DISTINCT kag) AS kags FROM kag_signups WHERE state > 0 AND kag IN ($kags) AND kabal = " . $kabal->GetID() . ' GROUP BY person ORDER BY person', $db);
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

foreach ($hunters as $array) {
	$table->StartRow();
	$table->AddCell('<a href="hunter.php?id=' . $array['person'] . '">' . $array['name'] . '</a>');
	$table->AddCell('<div style="text-align: right">' . number_format($array['points']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($array['events']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($array['pe'], 1) . '</div>');
	$table->EndRow();
}

$table->EndTable();

page_footer();
?>
