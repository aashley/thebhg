<?php
include_once('header.php');

if (empty($_REQUEST['order'])) {
	$_REQUEST['order'] = 'points';
	$_REQUEST['sort'] = 'desc';
}

$hunter =& $roster->GetPerson($_REQUEST['id']);
$kag =& $ka->GetKAG($_REQUEST['kag']);
$signups =& $kag->GetHunterSignups($hunter);
$signup = current($signups);
$kabal =& $signup->GetKabal();
page_header('KAG ' . roman($kag->GetID()) . ' :: ' . $hunter->GetName());
add_menu(array('KAG ' . roman($kag->GetID())=>'kag/kag.php?id=' . $kag->GetID(), $kabal->GetName() . ' Kabal'=>'kag/kabal.php?kag=' . $kag->GetID() . '&amp;kabal=' . $kabal->GetID(), $hunter->GetName() . '\'s Long-Term Statistics'=>'kag/stats/hunter.php?id=' . $hunter->GetID()));

$table = new Table('', true);
$table->AddRow('Total Events:', '<div style="text-align: right">' . number_format(count($signups)) . '</div>');
$states = array();
$credits = 0;
foreach ($signups as $signup) {
	$states[$signup->GetState()]++;
	$credits += $signup->GetCredits();
}
$table->AddRow('Unmarked Events:', '<div style="text-align: right">' . number_format($states[0]) . '</div>');
$table->AddRow('Completed Events:', '<div style="text-align: right">' . number_format($states[1] + $states[4]) . '</div>');
$table->AddRow('DNPs:', '<div style="text-align: right">' . number_format($states[2]) . '</div>');
$table->AddRow('No Efforts:', '<div style="text-align: right">' . number_format($states[3]) . '</div>');
$table->AddRow('Total Credits:', '<div style="text-align: right">' . number_format($credits) . '</div>');
$table->EndTable();

echo '<br />';

$table = new Table('Events', true);
$table->StartRow();
create_sort_headers($table, array('ename'=>'Event', 'state'=>'Status', 'points'=>'Points', 'rank'=>'Rank', 'credits'=>'Credits'));
$table->EndRow();
$sups = array();
foreach ($signups as $signup) {
	$array = array();
	$event =& $signup->GetEvent();
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
	$table->AddCell('<a href="event.php?id=' . $array['eid'] . '">' . $array['ename'] . '</a>');
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
