<?php
include_once('header.php');

page_header('Index');

$table = new Table('', true);
$table->StartRow();
$table->AddHeader('KAG');
$table->AddHeader('Leader');
$table->AddHeader('Start');
$table->AddHeader('End');
$table->EndRow();
$kags =& $ka->GetKAGs();
if ($kags) {
	foreach (array_reverse($ka->GetKAGs()) as $kag) {
		$table->StartRow();
		$table->AddCell('<a href="kag.php?id=' . $kag->GetID() . '">KAG ' . roman($kag->GetID()) . '</a>');
		$totals = $kag->GetKabalTotals();
		if (is_array($totals)) {
			$kabal = $roster->GetKabal(key($totals));
			$table->AddCell('<a href="kabal.php?kag=' . $kag->GetID() . '&amp;kabal=' . $kabal->GetID() . '">' . $kabal->GetName() . '</a>');
		}
		else {
			$table->AddCell('N/A');
		}
		$table->AddCell(date('j F Y \a\t G:i:s T', $kag->GetStart()));
		$table->AddCell(date('j F Y \a\t G:i:s T', $kag->GetEnd()));
		$table->EndRow();
	}
}
else {
	$table->StartRow();
	$table->AddCell('No KAGs found.', 4);
	$table->EndRow();
}
$table->EndTable();

page_footer();
?>
