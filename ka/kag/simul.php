<?php
function get_points($hunter) {
	global $last_kag, $db;
	 
	$points = 0;
	$result = mysql_query('SELECT kag, SUM(points) AS points, COUNT(DISTINCT id) AS events FROM kag_signups WHERE person=' . $hunter->GetID() . ' AND kag BETWEEN ' . ($last_kag->GetID() - 5) . ' AND ' . $last_kag->GetID() . ' GROUP BY kag ORDER BY kag DESC', $db);
	if ($result && mysql_num_rows($result)) {
		$parts = 0;
		$events = 0;
		$kags = 0;
		while ($row = mysql_fetch_array($result)) {
			$weight = $row['kag'] - ($last_kag->GetID() - 5);
			$parts += $weight;
			$points += ($weight * ($row['points'] / $row['events']));
			$kags++;
			$events += $row['events'];
		}
		$points /= $parts;
		$points *= ($events / $kags);
	}
	return $points;
}

include_once('header.php');
page_header('Simulated KAG');

// Get the most recent KAG.
$kags = $ka->GetKAGs();
if (isset($_REQUEST['last'])) {
	$last_kag = $ka->GetKAG((int) $_REQUEST['last']);
}
else {
	$last_kag = end($kags);
}

// Fill the array of kabals and hunters.
$kabals = array();
$hunters = array();

foreach ($roster->GetKabals() as $kabal) {
	$karray = array('kabal'=>$kabal, 'points'=>0, 'hunters'=>array());
	foreach ($kabal->GetMembers('name') as $member) {
		if ($points = get_points($member)) {
			$harray = array('hunter'=>$member, 'points'=>$points);
			$karray['points'] += $points;
			$karray['hunters'][] = $harray;
		}
		$hunters[$member->GetID()] = $points;
	}
	$kabals[] = $karray;
}

// Display the kabal-by-kabal totals.
$points = array();
foreach ($kabals as $kabal) {
	$points[$kabal['kabal']->GetName()] = $kabal['points'];
}
arsort($points);

$table = new Table('Kabals', true);
$table->StartRow();
$table->AddHeader('Kabal');
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
$table->AddHeader('Kabal');
$table->AddHeader('Hunter');
$table->AddHeader('Points');
$table->EndRow();
foreach ($kabals as $kabal) {
	foreach ($kabal['hunters'] as $hunter) {
		$table->AddRow($kabal['kabal']->GetName(), $hunter['hunter']->GetName(), number_format($hunter['points']));
	}
}
$table->EndTable();

echo '<br /><br />';

// Finally, display the ins and outs since the last KAG.
$table = new Table('Transfers', true);
$table->StartRow();
$table->AddHeader('Kabal');
$table->AddHeader('In');
$table->AddHeader('Out');
$table->EndRow();
$roster_db = mysql_connect('localhost', 'thebhg_roster', 'bhgrosterpass');
mysql_select_db('thebhg_roster', $roster_db);
foreach ($roster->GetKabals() as $kabal) {
	// Figure out the ins.
	$ins = array();
	$tin = 0;
	$result = mysql_query('SELECT person FROM roster_history WHERE type=3 AND item2=' . $kabal->GetID() . ' AND date>=' . $last_kag->GetEnd() . ' ORDER BY date DESC', $roster_db);
	if ($result && mysql_num_rows($result)) {
		while ($row = mysql_fetch_array($result)) {
			$person = $roster->GetPerson($row['person']);
			$div = $person->GetDivision();
			if ($div->GetID() == $kabal->GetID()) {
				$history = $person->GetHistory();
				$history->Load($last_kag->GetEnd(), 0, array(3), 'ASC');
				$history->First();
				$item = $history->GetItem();
				$old_div = $roster->GetDivision($item->GetItem(1));
				if ($old_div->GetID() != $kabal->GetID()) {
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
	$result = mysql_query('SELECT person FROM roster_history WHERE type=3 AND item1=' . $kabal->GetID() . ' AND date>=' . $last_kag->GetEnd() . ' ORDER BY date DESC', $roster_db);
	if ($result && mysql_num_rows($result)) {
		while ($row = mysql_fetch_array($result)) {
			$person = $roster->GetPerson($row['person']);
			$div = $person->GetDivision();
			if ($div->GetID() != $kabal->GetID()) {
				$history = $person->GetHistory();
				$history->Load($last_kag->GetEnd(), 0, array(3), 'ASC');
				$history->First();
				$item = $history->GetItem();
				if ($item->GetItem(1) == $kabal->GetID()) {
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
	$table->AddCell($kabal->GetName() . '<br /><br />Points In: ' . number_format($tin) . '<br />Points Out: ' . number_format($tout) . '<br />Difference: ' . $difference);
	$table->AddCell(implode('<br />', $ins));
	$table->AddCell(implode('<br />', $outs));
	$table->EndRow();
}
$table->EndTable();

page_footer();
?>
