<?php
include_once('header.php');

if (empty($_REQUEST['order'])) {
	$_REQUEST['order'] = 'wins';
	$_REQUEST['sort'] = 'desc';
}

page_header('Statistics Centre :: Kabals');

$table = new Table('', true);
$table->StartRow();
create_sort_headers($table, array('name'=>'Name', 'wins'=>'Wins', 'points'=>'Points'));
$table->EndRow();

$result = mysql_query('SELECT kabal, SUM(points) AS points FROM kag_signups GROUP BY kabal', $db);
if ($result && mysql_num_rows($result)) {
	$kabal_wins = array();
	foreach ($ka->GetKAGs() as $kag) {
		$totals = $kag->GetKabalTotals();
		if ($totals) {
			$kabal_wins[key($totals)]++;
		}
	}
	$kabals = array();
	while ($row = mysql_fetch_array($result)) {
		$kabal =& $roster->GetKabal($row['kabal']);
		$array = array('id'=>$row['kabal'], 'name'=>$kabal->GetName(), 'points'=>$row['points'], 'wins'=>$kabal_wins[$row['kabal']]);
		if ($_REQUEST['order'] == 'name') {
			$key = $array['name'];
		}
		elseif ($_REQUEST['order'] == 'points') {
			$key = $array['points'];
		}
		else {
			$key = $array['wins'];
		}
		$kabals[$key][] = $array;
	}
	if ($_REQUEST['sort'] == 'asc') {
		ksort($kabals);
	}
	else {
		krsort($kabals);
	}

	foreach ($kabals as $set) {
		foreach ($set as $array) {
			$table->StartRow();
			$table->AddCell('<a href="kabal.php?id=' . $array['id'] . '">' . $array['name'] . '</a>');
			$table->AddCell('<div style="text-align: right">' . number_format($array['wins']) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($array['points']) . '</div>');
			$table->EndRow();
		}
	}
}

$table->EndTable();

page_footer();
?>
