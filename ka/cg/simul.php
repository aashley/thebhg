<?php
function get_points($hunter) {
	global $last_cg, $db;
	
	$points = 0;
	$result = mysql_query('SELECT cg, SUM(points) AS points, COUNT(DISTINCT id) AS events FROM cg_signups WHERE person=' . $hunter->GetID() . ' AND cg>' . ($last_cg->GetID() - 5) . ' GROUP BY cg ORDER BY cg DESC', $db);
	if ($result && mysql_num_rows($result)) {
		$parts = 0;
		$events = 0;
		$cgs = 0;
		while ($row = mysql_fetch_array($result)) {
			$weight = $row['cg'] - ($last_cg->GetID() - 5);
			$parts += $weight;
			$points += ($weight * ($row['points'] / $row['events']));
			$cgs++;
			$events += $row['events'];
		}
		$points /= $parts;
		$points *= ($events / $cgs);
	}
	return $points;
}

include_once('header.php');
page_header('Simulated CG');

// Get the most recent CG.
$cgs = $ka->GetCGs();
if (isset($_REQUEST['last'])) {
	$last_cg = $ka->GetCG((int) $_REQUEST['last']);
}
else {
	$last_cg = end($cgs);
}

// Fill the array of cadres and hunters.
$cadres = array();
$hunters = array();

foreach ($roster->GetCadres() as $cadre) {
	$karray = array('cadre'=>$cadre, 'points'=>0, 'hunters'=>array());
	foreach ($cadre->GetMembers('name') as $member) {
		if ($points = get_points($member)) {
			$harray = array('hunter'=>$member, 'points'=>$points);
			$karray['points'] += $points;
			$karray['hunters'][] = $harray;
		}
		$hunters[$member->GetID()] = $points;
	}
	$cadres[] = $karray;
}

// Display the cadre-by-cadre totals.
$points = array();
foreach ($cadres as $cadre) {
	$points[$cadre['cadre']->GetName()] = $cadre['points'];
}
arsort($points);

$table = new Table('Cadres', true);
$table->StartRow();
$table->AddHeader('Cadre');
$table->AddHeader('Points');
$table->EndRow();
foreach ($points as $name=>$score) {
	$table->AddRow($name, number_format($score));
}
$table->EndTable();

echo '<br /><br />';

// Now show the hunter-by-hunter breakdown.
$table = new Table('Hunters', true);
$table->StartRow();
$table->AddHeader('Cadre');
$table->AddHeader('Hunter');
$table->AddHeader('Points');
$table->EndRow();
foreach ($cadres as $cadre) {
	foreach ($cadre['hunters'] as $hunter) {
		$table->AddRow($cadre['cadre']->GetName(), $hunter['hunter']->GetName(), number_format($hunter['points']));
	}
}
$table->EndTable();

echo '<br /><br />';

// Finally, display the ins and outs since the last CG.
$table = new Table('Transfers', true);
$table->StartRow();
$table->AddHeader('Cadre');
$table->AddHeader('In');
$table->AddHeader('Out');
$table->EndRow();
$roster_db = mysql_connect('localhost', 'thebhg_roster', 'bhgrosterpass');
mysql_select_db('thebhg_roster', $roster_db);
foreach ($roster->GetCadres() as $cadre) {
	// Figure out the ins.
	$ins = array();
	$tin = 0;
	$result = mysql_query('SELECT person FROM roster_history WHERE type=3 AND item2=' . $cadre->GetID() . ' AND date>=' . $last_cg->GetEnd() . ' ORDER BY date DESC', $roster_db);
	if ($result && mysql_num_rows($result)) {
		while ($row = mysql_fetch_array($result)) {
			$person = $roster->GetPerson($row['person']);
			$div = $person->GetDivision();
			if ($div->GetID() == $cadre->GetID()) {
				$history = $person->GetHistory();
				$history->Load($last_cg->GetEnd(), 0, array(3), 'ASC');
				$history->First();
				$item = $history->GetItem();
				$old_div = $roster->GetDivision($item->GetItem(1));
				if ($old_div->GetID() != $cadre->GetID()) {
					$ins[$person->GetID()] = $person->GetName() . ' (From ' . $old_div->GetName() . ')';
					if (isset($hunters[$person->GetID()])) {
						$tin += $hunters[$person->GetID()];
					}
					else {
						$tin += get_points($person);
					}
				}
			}
		}
	}
	sort($ins);

	// Now for the outs.
	$outs = array();
	$tout = 0;
	$result = mysql_query('SELECT person FROM roster_history WHERE type=3 AND item1=' . $cadre->GetID() . ' AND date>=' . $last_cg->GetEnd() . ' ORDER BY date DESC', $roster_db);
	if ($result && mysql_num_rows($result)) {
		while ($row = mysql_fetch_array($result)) {
			$person = $roster->GetPerson($row['person']);
			$div = $person->GetDivision();
			if ($div->GetID() != $cadre->GetID()) {
				$history = $person->GetHistory();
				$history->Load($last_cg->GetEnd(), 0, array(3), 'ASC');
				$history->First();
				$item = $history->GetItem();
				if ($item->GetItem(1) == $cadre->GetID()) {
					$new_div = $person->GetDivision();
					$outs[$person->GetID()] = $person->GetName() . ' (To ' . $new_div->GetName() . ')';
					if (isset($hunters[$person->GetID()])) {
						$tout += $hunters[$person->GetID()];
					}
					else {
						$tout += get_points($person);
					}
				}
			}
		}
	}
	sort($outs);

	// Display it all.
	$tin = round($tin);
	$tout = round($tout);
	$diff = $tin - $tout;
	if ($diff > 0) {
		$difference = '+' . number_format($diff);
	}
	else {
		$difference = number_format($diff);
	}
	
	$table->StartRow();
	$table->AddCell($cadre->GetName() . '<br /><br />Points In: ' . number_format($tin) . '<br />Points Out: ' . number_format($tout) . '<br />Difference: ' . $difference);
	$table->AddCell(implode('<br />', $ins));
	$table->AddCell(implode('<br />', $outs));
	$table->EndRow();
}
$table->EndTable();

page_footer();
?>
