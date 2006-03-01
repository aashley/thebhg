<?php
include_once('header.php');

if (isset($_REQUEST['id'])) {
	$cg = $ka->GetCG($_REQUEST['id']);
}
else {
	if ($cgs =& $ka->GetCGs()) {
		$cg = end($cgs);
	}
	else {
		page_header('CG');
		echo 'No CGs found.';
		page_footer();
	}
}

page_header('CG ' . roman($cg->GetID()));
add_menu(array('View All Hunters'=>'cg/hunters.php?cg=' . $cg->GetID()));

$totals = array();
$table = new Table('Cadre Standings', true);
$table->StartRow();
$table->AddHeader('Cadre');
$table->AddHeader('Points');
$table->EndRow();
$totals =& $cg->GetCadreTotals();
if (is_array($totals)) {
	foreach ($totals as $kid=>$total) {
		$cadre = $roster->GetCadre($kid);
		$table->StartRow();
		$table->AddCell('<a href="cadre.php?cg=' . $cg->GetID() . '&amp;cadre=' . $cadre->GetID() . '">' . $cadre->GetName() . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($total) . '</div>');
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

$events = $cg->GetEvents();
if ($events) {
	$table = new Table('Events', true);
	$table->StartRow();
	$table->AddHeader('Name');
	$table->AddHeader('Start');
	$table->AddHeader('End');
	$table->EndRow();
	foreach ($events as $event) {
		$table->StartRow();
		$table->AddCell('<a href="event.php?id=' . $event->GetID() . '">' . $event->GetName() . '</a>');
		$table->AddCell(date('j F Y \a\t G:i:s T', $event->GetStart()));
		$table->AddCell(date('j F Y \a\t G:i:s T', $event->GetEnd()));
		$table->EndRow();
	}
	$table->EndTable();
}

echo '<br />';
if (is_array($totals =& $cg->GetHunterTotals(10))) {
	$table = new Table('Top Hunters', true);
	$table->StartRow();
	$table->AddHeader('');
	$table->AddHeader('Name');
	$table->AddHeader('Cadre');
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
		$table->AddCell('<a href="hunter.php?cg=' . $cg->GetID() . '&amp;id=' . $array['hunter']->GetID() . '">' . $array['hunter']->GetName() . '</a>');
		$table->AddCell('<a href="cadre.php?cg=' . $cg->GetID() . '&amp;cadre=' . $array['cadre']->GetID() . '">' . $array['cadre']->GetName() . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($array['total']) . '</div>');
		$table->EndRow();
	}
	$table->EndTable();
}

page_footer();
?>
