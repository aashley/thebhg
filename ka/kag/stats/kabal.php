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
		$table->EndRow();
	}
}

$table->EndTable();
echo '<br />';

$table = new Table('Hunters', true);
$table->StartRow();
create_sort_headers($table, array('name'=>'Name', 'points'=>'Points', 'events'=>'Completed Events', 'pe'=>'Pts/Event'));
$table->EndRow();

$result = mysql_query('SELECT person, SUM(points) AS points, COUNT(DISTINCT id) AS events FROM kag_signups WHERE state > 0 AND kabal=' . $_REQUEST['id'] . ' GROUP BY person', $db);
if ($result && mysql_num_rows($result)) {
	$hunters = array();
	while ($row = mysql_fetch_array($result)) {
		$hunter =& $roster->GetPerson($row['person']);
		$array = array('id'=>$hunter->GetID(), 'name'=>$hunter->GetName());
		$array['points'] = $row['points'];
		$array['events'] = $row['events'];
		$array['pe'] = ((double) $array['points'] / $array['events']);
		$key = $array[$_REQUEST['order']];
		$hunters[$key][] = $array;
	}
	if ($_REQUEST['sort'] == 'asc') {
		ksort($hunters);
	}
	else {
		krsort($hunters);
	}

	foreach ($hunters as $set) {
		foreach ($set as $array) {
			$table->StartRow();
			$table->AddCell('<a href="hunter.php?id=' . $array['id'] . '">' . $array['name'] . '</a>');
			$table->AddCell('<div style="text-align: right">' . number_format($array['points']) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($array['events']) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($array['pe'], 1) . '</div>');
			$table->EndRow();
		}
	}
}

$table->EndTable();

page_footer();
?>
