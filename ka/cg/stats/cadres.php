<?php
include_once('header.php');

if (empty($_REQUEST['order'])) {
	$_REQUEST['order'] = 'wins';
	$_REQUEST['sort'] = 'desc';
}

page_header('Statistics Centre :: Cadres');

$table = new Table('', true);
$table->StartRow();
create_sort_headers($table, array('name'=>'Name', 'wins'=>'Wins', 'points'=>'Points'));
$table->EndRow();

$result = mysql_query('SELECT cadre, SUM(points) AS points FROM cg_signups GROUP BY cadre', $db);
if ($result && mysql_num_rows($result)) {
	$cadre_wins = array();
	foreach ($ka->GetCGs() as $cg) {
		$totals = $cg->GetCadreTotals();
		if ($totals) {
			$cadre_wins[key($totals)]++;
		}
	}
	$cadres = array();
	while ($row = mysql_fetch_array($result)) {
		$cadre =& $roster->GetCadre($row['cadre']);
		$array = array('id'=>$row['cadre'], 'name'=>$cadre->GetName(), 'points'=>$row['points'], 'wins'=>$cadre_wins[$row['cadre']]);
		if ($_REQUEST['order'] == 'name') {
			$key = $array['name'];
		}
		elseif ($_REQUEST['order'] == 'points') {
			$key = $array['points'];
		}
		else {
			$key = $array['wins'];
		}
		$cadres[$key][] = $array;
	}
	if ($_REQUEST['sort'] == 'asc') {
		ksort($cadres);
	}
	else {
		krsort($cadres);
	}

	foreach ($cadres as $set) {
		foreach ($set as $array) {
			$table->StartRow();
			$table->AddCell('<a href="cadre.php?id=' . $array['id'] . '">' . $array['name'] . '</a>');
			$table->AddCell('<div style="text-align: right">' . number_format($array['wins']) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($array['points']) . '</div>');
			$table->EndRow();
		}
	}
}

$table->EndTable();

page_footer();
?>
