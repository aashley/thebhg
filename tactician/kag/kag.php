<?php
include_once('header.php');

if (isset($_REQUEST['id'])) {
	$kag = $ka->GetKAG($_REQUEST['id']);
}
else {
	if ($kags =& $ka->GetKAGs()) {
		$kag = end($kags);
	}
	else {
		page_header('KAG');
		echo 'No KAGs found.';
		page_footer();
	}
}

page_header('KG ' . roman($kag->GetID()));
add_menu(array('View All Hunters'=>'kag/hunters.php?kag=' . $kag->GetID()));

$totals = array();
$table = new Table('Kabal Standings', true);
$table->StartRow();
$table->AddHeader('Kabal');
$table->AddHeader('Points');
$table->AddHeader('Signups');
$table->AddHeader('Points Per Signup');
$table->EndRow();
$totals =& $kag->GetKabalTotals();

if (is_array($totals)) {
	foreach ($totals as $kid=>$total) {
		$kabal = $roster->GetKabal($kid);
		$signups = $kag->GetKabalSignups($kabal);
		$table->StartRow();
		$table->AddCell('<a href="kabal.php?kag=' . $kag->GetID() . '&amp;kabal=' . $kabal->GetID() . '">' . $kabal->GetName() . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($total) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($signups) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format(round(($total / $signups))) . '</div>');
		$table->EndRow();
	}
}
else {
	$table->StartRow();
	$table->AddCell('There are no results available at present.', 2);
	$table->EndRow();
}
$table->EndTable();

echo '<br />';

$events = $kag->GetEvents();
if ($events) {
	$table = new Table('Skill Events', true);
	$table->StartRow();
	$table->AddHeader('Name');
	$table->AddHeader('Start');
	$table->AddHeader('End');
	$table->EndRow();
	foreach ($events as $event) {
		if ($event->IsTimed())
			continue;
			
		$name = $event->GetName();
		
		$table->StartRow();
		$table->AddCell('<a href="event.php?id=' . $event->GetID() . '">' . $name . '</a>');
		$table->AddCell(date('j F Y \a\t G:i:s T', $event->getStart()));
		$table->AddCell(date('j F Y \a\t G:i:s T', $event->getEnd()));
		$table->EndRow();
	}
	$table->EndTable();
	
	$table = new Table('Timed Events', true);
	$table->StartRow();
	$table->AddHeader('Name');
	if ($kag->getID() >= 24){
		$table->addHeader('Window Start');
		$table->addHeader('Window End');
		$table->addHeader('Event End');
	} else {
		$table->AddHeader('Start');
		$table->AddHeader('End');
	}
	$table->EndRow();
	foreach ($events as $event) {
		if (!$event->IsTimed())
			continue;
			
		$type = $event->GetTypes();
		$name = $type->GetName();
		
		$table->StartRow();
		$table->AddCell('<a href="event.php?id=' . $event->GetID() . '">' . $name . '</a>');
		if ($kag->getID() >= 24){
			$table->AddCell(date('j F Y \a\t G:i:s T', $event->getWindowStart()));
			$table->AddCell(date('j F Y \a\t G:i:s T', $event->getWindowEnd()));
		} else
			$table->AddCell(date('j F Y \a\t G:i:s T', $event->getStart()));
			$table->AddCell(date('j F Y \a\t G:i:s T', $event->getEnd()));
		$table->EndRow();
	}
	$table->EndTable();
}

echo '<br />';
if (is_array($totals =& $kag->GetHunterTotals(10))) {
	$table = new Table('Top Hunters', true);
	$table->StartRow();
	$table->AddHeader('');
	$table->AddHeader('Name');
	$table->AddHeader('Kabal');
	$table->AddHeader('Points');
	$table->EndRow();
	$rank = 0;
	$displayed_rank = 0;
	$last_total = 0;
	foreach ($totals as $array) {
		$rank++;
		if ($array['total'] != $last_total) {
			$disp_rank = $rank;
			$last_total = $array['total'];
		}
		$table->StartRow();
		$table->AddCell('<div style="text-align: right">' . number_format($disp_rank) . '</div>');
		$table->AddCell('<a href="hunter.php?kag=' . $kag->GetID() . '&amp;id=' . $array['hunter']->GetID() . '">' . $array['hunter']->GetName() . '</a>');
		$table->AddCell('<a href="kabal.php?kag=' . $kag->GetID() . '&amp;kabal=' . $array['kabal']->GetID() . '">' . $array['kabal']->GetName() . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($array['total']) . '</div>');
		$table->EndRow();
	}
	$table->EndTable();
}

page_footer();
?>
