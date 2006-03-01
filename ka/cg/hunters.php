<?php
include_once('header.php');

$cg =& $ka->GetCG($_REQUEST['cg']);

page_header('CG ' . roman($cg->GetID()) . ' :: Hunters');

if (is_array($totals =& $cg->GetHunterTotals())) {
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
else {
	echo 'No results have been posted for this CG yet.';
}

page_footer();
?>
