<?php

function output(){
	global $ka;
	
	if ($_REQUEST['event']){
		$event = new Event($_REQUEST['event']);
	
		$type = $event->GetTypes();
		
		$round = $event->GetRound();
		$season = $round->GetSeason();
		
		echo '<div><h2>KAC '.roman($season->GetID()).' Round '.$round->GetRoundID().' - '.$type->GetName().' ('.$type->GetAbbr().')</h2><p>'.
		$type->GetDesc().'</p></div>';
		
		add_menu(array('KAC '.roman($season->GetID())=>'kac/stats.php?flag=kac&season='.$season->GetSeasonID()));
		
		$ladder = new Ladder($season->GetSeasonID());
		
		$combat = $ladder->CombatKabals($round->GetRoundID());
		
		$kabals = array();
		$readout = array();
		
		if ($event->IsGraded()){
			$order = '`points` DESC';
			$use = 1;
		} else {
			$order = '`submitted` ASC';
			$use = 0;
		}
		
		foreach ($event->GetSubmissions($order) as $sub){
			$kabal = $sub->GetKabal();
			$kabals[$kabal->GetID()][($use ? $sub->GetPoints() : $sub->Dates('SYSTEM', 'submitted'))][] = $sub;
		}
		
		foreach ($combat as $bracket=>$data){
			foreach ($data as $kabal){
				if (isset($kabals[$kabal])){
					foreach ($kabals[$kabal] as $points=>$sub){
						$readout[$bracket][$points][] = $sub;							
					}
				}
			}
		}
		
		$fin = array();
		
		foreach ($readout as $bracket=>$data){
			($use ? krsort($data) : ksort($data));
			$fin[$bracket] = $data;
		}
		
		$readout = $fin;

		foreach ($readout as $bracket=>$datm){
			
			$table = new Table();
			
			$kabalface = $combat[$bracket];
			
			$kabals = array();
			
			foreach ($kabalface as $kab){
				$kabal = new Division($kab);
				$kabals[] = $kabal->GetName();
			}
			
			$table->StartRow();
			$table->AddHeader('<center>'.implode(' vs. ', $kabals).'</center>', 4);
			$table->EndRow();
			
			$table->StartRow();
			$table->AddHeader('Name');
			$table->AddHeader('Kabal');
			$table->AddHeader('Points');
			$table->AddHeader('Credits');
			$table->EndRow();
			
			foreach ($datm as $data){
				
				foreach ($data as $datum){
					foreach ($datum as $sub){
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
				}
			}
			$table->EndTable();
		}
		
	} else {
		echo 'Invalid Kabal Authority Cup event';
	}
}

?>