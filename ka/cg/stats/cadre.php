<?php
include_once('header.php');

if (empty($_REQUEST['order'])) {
	$_REQUEST['order'] = 'points';
	$_REQUEST['sort'] = 'desc';
}

$cadre =& $roster->GetCadre($_REQUEST['id']);
page_header('Statistics Centre :: ' . $cadre->GetName() . ' Cadre');

$table = new Table('CGs', true);
$table->StartRow();
$table->AddHeader('CG');
$table->AddHeader('Points');
$table->AddHeader('Signups');
$table->AddHeader('DNPs');
$table->EndRow();

$result = mysql_query('SELECT cg, SUM(points) AS points, COUNT(DISTINCT id) AS signups FROM cg_signups WHERE cadre=' . $_REQUEST['id'] . ' GROUP BY cg ORDER BY cg DESC', $db);
if ($result && mysql_num_rows($result)) {
	while ($row = mysql_fetch_array($result)) {
		$table->StartRow();
		$table->AddCell('<a href="../cadre.php?cg=' . $row['cg'] . '&amp;cadre=' . $_REQUEST['id'] . '">CG ' . roman($row['cg']) . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['points']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($row['signups']) . '</div>');
		$dnp_result = mysql_query('SELECT COUNT(DISTINCT id) AS signups FROM cg_signups WHERE cadre=' . $_REQUEST['id'] . ' AND cg=' . $row['cg'] . ' AND state=2', $db);
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

$result = mysql_query('SELECT person, SUM(points) AS points, COUNT(DISTINCT id) AS events FROM cg_signups WHERE state > 0 AND cadre=' . $_REQUEST['id'] . ' GROUP BY person', $db);
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
