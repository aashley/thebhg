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
	$ladder = new Ladder($kac->GetSeasonID());
	if ($ladder->CurrentRound() <= 3){
		$round = $kac->RoundByID($ladder->CurrentRound());
		$kabals = $round->GetKabalPoints();
		$keys = array_keys($kabals);
		$leader = end($keys);
		$kabal = new Division($leader);
	} else {
		$kabal = new Division ($ladder->Champion($ladder->CurrentRound()));
	}
	
	if ($kabal->GetName()){
		$kab_stuff = '<a href="/kac/stats.php?flag=kabal&kabal='
			.$kabal->GetID().'&season='.$kac->GetSeasonID().'">'.$kabal->GetName().'</a>';
	} else {
		$kab_stuff = 'No Data';
	}
	
	$table->AddRow('<a href="/kac/stats.php?flag=kac&season='.$kac->GetSeasonID().'">Season '.roman($kac->GetID())
			.'</a> (<a href="/kac/stats.php?flag=ladder&season='.$kac->GetSeasonID().'">Ladder</a>)', $kab_stuff, $kac->Dates('HUMAN', 'start'), 
			$kac->Dates('HUMAN', 'end'));
}

$table->EndTable();

page_footer();
?>
