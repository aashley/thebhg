<?php

function output(){
	global $ka;
	
	if ($_REQUEST['season']){
		$season = $_REQUEST['season'];
	} else {
		$ladder = new Ladder();
		$season = $ladder->CurrentSeason();
	}
	
	$kac = $ka->KACBySeason($season);
	
	if (is_object($kac)){
	
		add_menu(array('View All Hunters'=>'kac/stats.php?flag=hunter&season=' . $kac->GetSeasonID()));
		
		echo '<center><b><a href="/kac/stats.php?flag=ladder&season='.$kac->GetSeasonID().'">View Season Ladder</a></b></center>';
		
		hr();
		
		if (count($kac->GetKabalTotals())){
		
			$table = new Table();
			
			$table->StartRow();
			$table->AddHeader('<center>Kabal Standings</center>', 2);
			$table->EndRow();
			
			$table->StartRow();
			$table->AddHeader('Kabal');
			$table->AddHeader('Points');
			$table->EndRow();
			
			foreach ($kac->GetKabalTotals() as $kabal=>$total){
				$kabal = new Division($kabal);
				$table->AddRow('<a href="/kac/stats.php?flag=kabal&season='.$kac->GetSeasonID().'&kabal='.$kabal->GetID().'">'.$kabal->GetName().'</a>', number_format($total));
			}
			
			$table->EndTable();
			
		}
		
		if (count($kac->GetRounds())){
		
			$table = new Table();
			
			$table->StartRow();
			$table->AddHeader('<center>Rounds</center>', 3);
			$table->EndRow();
			
			$table->StartRow();
			$table->AddHeader('Round');
			$table->AddHeader('Start');
			$table->AddHeader('End');
			$table->EndRow();
			
			foreach ($kac->GetRounds() as $round){
				$table->AddRow('<a href="/kac/stats.php?flag=round&round='.$round->GetID().'">Round '.$round->GetRoundID().'</a>',
					$round->Dates('HUMAN', 'start'), $round->Dates('HUMAN', 'end'));
			}
			
			$table->EndTable();
			
		}
		
		if (count($kac->GetRounds())){
		
			$table = new Table();
			
			$table->StartRow();
			$table->AddHeader('<center>Events</center>', 4);
			$table->EndRow();
			
			$table->StartRow();
			$table->AddHeader('Event');
			$table->AddHeader('Round');
			$table->AddHeader('Start');
			$table->AddHeader('End');
			$table->EndRow();
			
			foreach ($kac->GetRounds() as $round){
				foreach ($round->NormalEvents() as $event){
					$type = $event->GetTypes();
					$table->AddRow('<a href="/kac/stats.php?flag=event&event='.$event->GetID().'">'.$type->GetName().'</a>', 
					'<a href="/kac/stats.php?flag=round&round='.$round->GetID().'">Round '.$round->GetRoundID().'</a>', 
					$event->Dates('HUMAN', 'start'), $event->Dates('HUMAN', 'end'));
				}
			}
			
			$table->EndTable();
			
		}		
		
		if (count($ka->GetHunters($kac->GetID()))){
		
			$top = array();
			$kabals = array();
			
			foreach ($ka->GetHunters($kac->GetID()) as $hunter){
				$stats = $ka->Stats($hunter, $kac->GetID());
				
				$top[$hunter] = $stats['points'];
				
				$key = key($stats['kabals']);
				
				$kabals[$hunter] = $stats['kabals'][$key];
			}
			
			arsort($top);
			
			$table = new Table();
			
			$table->StartRow();
			$table->AddHeader('<center>Top Hunters</center>', 4);
			$table->EndRow();
			
			$table->StartRow();
			$table->AddHeader('&nbsp;');
			$table->AddHeader('Name');
			$table->AddHeader('Kabal');
			$table->AddHeader('Points');
			$table->EndRow();
			
			if (count($top) > 10){
				$run = 10;
			} else {
				$run = count($top);
			}
			
			$keys = array_keys($top);
			
			for ($i = 1; $i <= $run; $i++){
				$hunter = $keys[$i-1];
				$kabal = new Division($kabals[$hunter]);
				$person = new Person($hunter);
				$table->AddRow($i, '<a href="/kac/stats.php?flag=hunter&season='.$kac->GetSeasonID().'&hunter='.$person->GetID().'">'.$person->GetName()
						.'</a>', '<a href="/kac/stats.php?flag=kabal&season='.$kac->GetSeasonID().'&kabal='.$kabal->GetID().'">'.$kabal->GetName().'</a>', number_format($top[$hunter]));
			}
			
			$table->EndTable();
			
		}
		
	} else {
		echo 'Invalid Kabal Authority Cup season';
	}
}

?>