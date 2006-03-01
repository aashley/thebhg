<?php
include_once('header.php');

if (empty($_REQUEST['order'])) {
	$_REQUEST['order'] = 'points';
	$_REQUEST['sort'] = 'desc';
}

$hunter =& $roster->GetPerson($_REQUEST['id']);
$signups =& $ka->GetHunterSignups($hunter);
page_header('Statistics Centre :: ' . $hunter->GetName());

if (!$signups) {
	echo '<div><h2>Error</h2>This hunter has never participated in a KAG.</div>';
	page_footer();
}

$table = new Table('', true);

$result = mysql_query('SELECT kabal FROM kag_signups WHERE person=' . $hunter->GetID() . ' GROUP BY kabal', $db);
$kabals = array();
while ($row = mysql_fetch_array($result)) {
	$kabal = $roster->GetKabal($row['kabal']);
	$kabals[$kabal->GetID()] = $kabal->GetName();
}
asort($kabals);
$table->StartRow();
$table->AddCell('Kabal' . ((count($kabals) == 1) ? '' : 's') . ':', 1, count($kabals));
$first = true;
foreach ($kabals as $kid=>$name) {
	if ($first) {
		$first = false;
	}
	else {
		$table->StartRow();
	}
	$table->AddCell('<a href="kabal.php?id=' . $kid . '">' . $name . '</a>');
	$table->EndRow();
}

$maxima = GetKAGMaxima();
$scaledEvents = 0;
$scaledTotal = 0;
foreach (array_unique($maxima) as $points) {
	$kags = implode(', ', array_keys($maxima, $points));
	$result = mysql_query("SELECT SUM(points) AS points, COUNT(DISTINCT id) AS events FROM kag_signups WHERE state > 0 AND kag IN ($kags) AND person=" . $hunter->GetID(), $db);
	if ($result && mysql_num_rows($result)) {
		$scaledEvents += mysql_result($result, 0, 'events');
		$scaledTotal += ScalePointsWithMaximum($points, mysql_result($result, 0, 'points'), mysql_result($result, 0, 'events'));
	}
}
$scaledPE = $scaledTotal / $scaledEvents;

$result = mysql_query('SELECT MIN(kag) AS first, MAX(kag) AS last, SUM(points) AS points, COUNT(DISTINCT id) AS events FROM kag_signups WHERE person=' . $hunter->GetID(), $db);
$row = mysql_fetch_array($result);
$table->AddRow('First KAG:', '<a href="../kag.php?id=' . $row['first'] . '">KAG ' . roman($row['first']) . '</a>');
$table->AddRow('Most Recent KAG:', '<a href="../kag.php?id=' . $row['last'] . '">KAG ' . roman($row['last']) . '</a>');
$table->AddRow('Total Points:', '<div style="text-align: right">' . number_format($row['points']) . '</div>');
$table->AddRow('Total Scaled Points:', '<div style="text-align: right">' . number_format($scaledTotal) . '</div>');
$table->AddRow('Total Events:', '<div style="text-align: right">' . number_format($row['events']) . '</div>');

$states = array();
$credits = 0;
$ms = 0;
foreach ($signups as $signup) {
	$states[$signup->GetState()]++;
	$credits += $signup->GetCredits();
	if ($signup->GetState() == 1 && $signup->GetRank() == 1) {
		$ms++;
	}
}
$table->AddRow('Average Points Per Event:', '<div style="text-align: right">' . number_format($row['points'] / (array_sum($states) - $states[0]), 1) . '</div>');
$table->AddRow('Average Scaled Points Per Event:', '<div style="text-align: right">' . number_format($scaledPE, 1) . '</div>');
$table->AddRow('Unmarked Events:', '<div style="text-align: right">' . number_format($states[0]) . '</div>');
$table->AddRow('Completed Events:', '<div style="text-align: right">' . number_format($states[1] + $states[4]) . '</div>');
$table->AddRow('DNPs:', '<div style="text-align: right">' . number_format($states[2]) . '</div>');
$table->AddRow('No Efforts:', '<div style="text-align: right">' . number_format($states[3]) . '</div>');
$table->AddRow('Master\'s Shields:', '<div style="text-align: right">' . number_format($ms) . '</div>');
$table->AddRow('Total Credits:', '<div style="text-align: right">' . number_format($credits) . '</div>');

$table->EndTable();

echo '<br />';

$table = new Table('KAGs', true);
$table->StartRow();
$table->AddHeader('KAG');
$table->AddHeader('Kabal');
$table->AddHeader('Points');
$table->AddHeader('Completed Events');
$table->AddHeader('Points/Event');
$table->EndRow();
$kags = array();
foreach ($signups as $signup) {
	if ($signup->GetState() > 0) {
		$kag =& $signup->GetKAG();
		if (empty($kags[$kag->GetID()])) {
			$kags[$kag->GetID()] = array('points'=>0, 'events'=>0, 'kabal'=>$signup->GetKabal());
		}
		$kags[$kag->GetID()]['points'] += $signup->GetPoints();
		$kags[$kag->GetID()]['events']++;
	}
}
ksort($kags);
foreach ($kags as $kag=>$array) {
	$table->StartRow();
	$table->AddCell("<a href=\"../hunter.php?kag=$kag&amp;id={$_REQUEST['id']}\">KAG " . roman($kag) . '</a>');
	$table->AddCell("<a href=\"../kabal.php?kag=$kag&amp;kabal=" . $array['kabal']->GetID() . '">' . $array['kabal']->GetName() . '</a>');
	$table->AddCell('<div style="text-align: right">' . number_format($array['points']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($array['events']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($array['points'] / $array['events'], 1) . '</div>');
	$table->EndRow();
}
$table->EndTable();

echo '<br />';

$table = new Table('Events', true);
$table->StartRow();
create_sort_headers($table, array('kag'=>'KAG', 'ename'=>'Event', 'state'=>'Status', 'points'=>'Points', 'rank'=>'Rank', 'credits'=>'Credits'));
$table->EndRow();
$sups = array();
foreach ($signups as $signup) {
	$array = array();
	$event =& $signup->GetEvent();
	$kag =& $event->GetKAG();
	$array['kag'] = $kag->GetID();
	$array['eid'] = $event->GetID();
	$array['ename'] = $event->GetName();
	$array['state'] = $signup->GetState();
	$array['points'] = $signup->GetPoints();
	$array['rank'] = $signup->GetRank();
	$array['credits'] = $signup->GetCredits();
	$sups[] = $array;
}

uasort($sups, sort_result_array);

foreach ($sups as $array) {
	$table->StartRow();
	$table->AddCell('<a href="../kag.php?id=' . $array['kag'] . '">KAG ' . roman($array['kag']) . '</a>');
	$table->AddCell('<a href="../event.php?id=' . $array['eid'] . '">' . $array['ename'] . '</a>');
	if ($array['state'] == 0) {
		$table->AddCell('Unmarked', 3);
	}
	elseif ($array['state'] == 1 || $array['state'] == 4) {
		$table->AddCell('Complete');
		$table->AddCell('<div style="text-align: right">' . number_format($array['points']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($array['rank']) . '</div>');
	}
	elseif ($array['state'] == 2) {
		$table->AddCell('DNP');
		$table->AddCell('<div style="text-align: right">' . number_format($array['points']) . '</div>');
		$table->AddCell('');
	}
	else {
		$table->AddCell('No Effort');
		$table->AddCell('<div style="text-align: right">' . number_format($array['points']) . '</div>');
		$table->AddCell('');
	}
	$table->AddCell('<div style="text-align: right">' . number_format($array['credits']) . '</div>');
	$table->EndRow();
}
$table->EndTable();

page_footer();
?>
