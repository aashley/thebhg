<?php
include_once('header.php');

page_header('Index');

$table = new Table('', true);
$table->StartRow();
$table->AddHeader('CG');
$table->AddHeader('Leader');
$table->AddHeader('Start');
$table->AddHeader('End');
$table->EndRow();
$cgs =& $ka->GetCGs();
if ($cgs) {
	foreach (array_reverse($ka->GetCGs()) as $cg) {
		$table->StartRow();
		$table->AddCell('<a href="cg.php?id=' . $cg->GetID() . '">CG ' . roman($cg->GetID()) . '</a>');
		$totals = $cg->GetCadreTotals();
		if (is_array($totals)) {
			$cadre = $roster->GetCadre(key($totals));
			$table->AddCell('<a href="cadre.php?cg=' . $cg->GetID() . '&amp;cadre=' . $cadre->GetID() . '">' . $cadre->GetName() . '</a>');
		}
		else {
			$table->AddCell('N/A');
		}
		$table->AddCell(date('j F Y \a\t G:i:s T', $cg->GetStart()));
		$table->AddCell(date('j F Y \a\t G:i:s T', $cg->GetEnd()));
		$table->EndRow();
	}
}
else {
	$table->StartRow();
	$table->AddCell('No CGs found.', 4);
	$table->EndRow();
}
$table->EndTable();

page_footer();
?>
