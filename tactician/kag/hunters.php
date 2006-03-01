<?php
include_once('header.php');

$kag =& $ka->GetKAG($_REQUEST['kag']);

page_header('KAG ' . roman($kag->GetID()) . ' :: Hunters');

if (is_array($totals =& $kag->GetHunterTotals())) {
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
else {
	echo 'No results have been posted for this KG yet.';
}

page_footer();
?>
