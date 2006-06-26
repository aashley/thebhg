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
	echo '<div><h2>Error</h2>This hunter has never participated in a CG.</div>';
	page_footer();
}

$table = new Table('', true);

$result = mysql_query('SELECT cadre, cg FROM cg_signups WHERE person=' . $_REQUEST['id'] . ' GROUP BY cadre', $db);
$cadres = array();
$credits = 0;
$tec = 0;
while ($row = mysql_fetch_array($result)) {
	$cadre = $roster->GetCadre($row['cadre']);
	$cadres[$cadre->GetID()] = $cadre->GetName();
	$cg =& $ka->GetCG($_REQUEST['cg']);
	foreach ($cg->GetTeamSignups($cadre) as $signup){
		$credits += $signup->getCredits();
		$tec += $signup->getCredits();
	}
}
asort($cadres);
$table->StartRow();
$table->AddCell('Cadre' . ((count($cadres) == 1) ? '' : 's') . ':', 1, count($cadres));
$first = true;
foreach ($cadres as $kid=>$name) {
	if ($first) {
		$first = false;
	}
	else {
		$table->StartRow();
	}
	$table->AddCell('<a href="cadre.php?id=' . $kid . '">' . $name . '</a>');
	$table->EndRow();
}

$result = mysql_query('SELECT MIN(cg) AS first, MAX(cg) AS last, SUM(points) AS points, COUNT(DISTINCT id) AS events FROM cg_signups WHERE person=' . $_REQUEST['id'], $db);
$row = mysql_fetch_array($result);
$table->AddRow('First CG:', '<a href="../cg.php?id=' . $row['first'] . '">CG ' . roman($row['first']) . '</a>');
$table->AddRow('Most Recent CG:', '<a href="../cg.php?id=' . $row['last'] . '">CG ' . roman($row['last']) . '</a>');
$table->AddRow('Total Points:', '<div style="text-align: right">' . number_format($row['points']) . '</div>');
$table->AddRow('Total Events:', '<div style="text-align: right">' . number_format($row['events']) . '</div>');

$states = array();
$ms = 0;
foreach ($signups as $signup) {
	$states[$signup->GetState()]++;
	$credits += $signup->GetCredits();
	if ($signup->GetState() == 1 && $signup->GetRank() == 1) {
		$ms++;
	}
}
$table->AddRow('Average Points Per Event:', '<div style="text-align: right">' . number_format($row['points'] / (array_sum($states) - $states[0]), 1) . '</div>');
$table->AddRow('Unmarked Events:', '<div style="text-align: right">' . number_format($states[0]) . '</div>');
$table->AddRow('Completed Events:', '<div style="text-align: right">' . number_format($states[1] + $states[4]) . '</div>');
$table->AddRow('DNPs:', '<div style="text-align: right">' . number_format($states[2]) . '</div>');
$table->AddRow('No Efforts:', '<div style="text-align: right">' . number_format($states[3]) . '</div>');
$table->AddRow('Master\'s Shields:', '<div style="text-align: right">' . number_format($ms) . '</div>');
$table->AddRow('Total Team Event Credits:', '<div style="text-align: right">' . number_format($tec) . '</div>');
$table->AddRow('Total Credits:', '<div style="text-align: right">' . number_format($credits) . '</div>');

$table->EndTable();

echo '<br />';

$table = new Table('CGs', true);
$table->StartRow();
$table->AddHeader('CG');
$table->AddHeader('Cadre');
$table->AddHeader('Points');
$table->AddHeader('Completed Events');
$table->AddHeader('Points/Event');
$table->EndRow();
$cgs = array();
foreach ($signups as $signup) {
	if ($signup->GetState() > 0) {
		$cg =& $signup->GetCG();
		if (empty($cgs[$cg->GetID()])) {
			$cgs[$cg->GetID()] = array('points'=>0, 'events'=>0, 'cadre'=>$signup->GetCadre());
		}
		$cgs[$cg->GetID()]['points'] += $signup->GetPoints();
		$cgs[$cg->GetID()]['events']++;
	}
}
ksort($cgs);
foreach ($cgs as $cg=>$array) {
	$table->StartRow();
	$table->AddCell("<a href=\"../hunter.php?cg=$cg&amp;id={$_REQUEST['id']}\">CG " . roman($cg) . '</a>');
	$table->AddCell("<a href=\"../cadre.php?cg=$cg&amp;cadre=" . $array['cadre']->GetID() . '">' . $array['cadre']->GetName() . '</a>');
	$table->AddCell('<div style="text-align: right">' . number_format($array['points']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($array['events']) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($array['points'] / $array['events'], 1) . '</div>');
	$table->EndRow();
}
$table->EndTable();

echo '<br />';

$table = new Table('Events', true);
$table->StartRow();
create_sort_headers($table, array('cg'=>'CG', 'ename'=>'Event', 'state'=>'Status', 'points'=>'Points', 'rank'=>'Rank', 'credits'=>'Credits'));
$table->EndRow();
$sups = array();
foreach ($signups as $signup) {
	$array = array();
	$event =& $signup->GetEvent();
	$cg =& $event->GetCG();
	$array['cg'] = $cg->GetID();
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
	$table->AddCell('<a href="../cg.php?id=' . $array['cg'] . '">CG ' . roman($array['cg']) . '</a>');
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
