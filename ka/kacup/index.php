<?php
include_once('header.php');

page_header('Index');

$table = new Table();

$table->StartRow();
$table->AddHeader('KAC');
$table->AddHeader('Leader');
$table->AddHeader('Start');
$table->AddHeader('End');
$table->EndRow();

foreach ($ka->GetSeasons() as $kac){
	$kabals = $kac->GetKabalTotals();
	$leader = key($kabals);
	$kabal = new Division($leader);
	$table->AddRow('<a href="/kac/stats.php?flag=kac&season='.$kac->GetSeasonID().'">Season '.roman($kac->GetSeasonID())
			.'</a> (<a href="/kac/stats.php?flag=ladder&season='.$kac->GetSeasonID().'">Ladder</a>)', '<a href="/kac/stats.php?flag=kabal&kabal='
			.$kabal->GetID().'&season='.$kac->GetSeasonID().'">'.$kabal->GetName().'</a>', $kac->Dates('HUMAN', 'start'), 
			$kac->Dates('HUMAN', 'start'));
}

$table->EndTable();

page_footer();
?>
