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
	
	if ($kabal->GetName()){
		$kab_stuff = '<a href="/kac/stats.php?flag=kabal&kabal='
			.$kabal->GetID().'&season='.$kac->GetSeasonID().'">'.$kabal->GetName().'</a>';
	} else {
		$kab_stuff = 'No Data';
	}
	
	$table->AddRow('<a href="/kac/stats.php?flag=kac&season='.$kac->GetSeasonID().'">Season '.roman($kac->GetID())
			.'</a> (<a href="/kac/stats.php?flag=ladder&season='.$kac->GetSeasonID().'">Ladder</a>)', $kab_stuff, $kac->Dates('HUMAN', 'start'), 
			$kac->Dates('HUMAN', 'start'));
}

$table->EndTable();

page_footer();
?>
