<?php

function output(){
	global $ka;
	
	if ($_REQUEST['event']){
		$event = new Event($_REQUEST['event']);
	
		$round = $event->GetRound();
		$season = $round->GetSeason();
		
		$table = new Table();
		
		$table->StartRow();
		$table->AddHeader('Name');
		$table->AddHeader('Kabal');
		$table->AddHeader('Points');
		$table->AddHeader('Credits');
		$table->EndRow();
		
		add_menu(array('KAC '.roman($season->GetID())=>'kac/stats.php?flag=kac&season='.$season->GetSeasonID()));
		
		foreach ($event->GetSubmissions('`points` DESC') as $sub){
			$hunter = $sub->GetHunter();
			$kabal = $sub->GetKabal();
			if ($sub->GetPlace() > -1){
				$award = $ka->GetAward($sub->GetPlace(), 0);
			} else {
				$award = $ka->GetAward($sub->GetPlace(), $info['correct']);
			}	
			$table->AddRow('<a href="/kac/stats.php?flag=hunter&season='.$season->GetSeasonID().'&hunter='.$hunter->GetID().'">'.$hunter->GetName()
						.'</a>', '<a href="/kac/stats.php?flag=kabal&season='.$season->GetSeasonID().'&kabal='.$kabal->GetID().'">'.$kabal->GetName()
						.'</a>', number_format($sub->GetPoints()), $award->GetCredits());
		}
		
		$table->EndTable();
		
	} else {
		echo 'Invalid Kabal Authority Cup event';
	}
}

?>