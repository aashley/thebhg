<?php

function output(){
	global $ka;
	
	if (empty($_REQUEST['order'])) {
		$_REQUEST['order'] = 'points';
		$_REQUEST['sort'] = 'desc';
	}
	
	if ($_REQUEST['kabal']){
	
		$kabal = new Division($_REQUEST['kabal']);
		
		$table = new Table();
		
		$table->StartRow();
		$table->AddHeader('<center>KACs</center>', 3);
		$table->EndRow();
		
		$table->StartRow();
		$table->AddHeader('KAC Season');
		$table->AddHeader('Points');
		$table->AddHeader('Total Submissions');
		$table->EndRow();
		
		foreach ($ka->GetSeasons() as $season){
			$submissions = 0;
			foreach ($season->GetRounds() as $round){
				foreach ($round->NormalEvents() as $event){
					$submissions += count($event->GetSubmissionsByKabal($kabal->GetID()));
				}
			}
			$kabals = $ka->GetKabals($season->GetID(), '', $kabal->GetID());
			$table->AddRow('<a href="/kac/stats.php?flag=kac&season='.$season->GetSeasonID().'">KAC '.roman($season->GetSeasonID()).'</a>', 
				number_format($kabals[$kabal->GetID()]), $submissions);
		}
		
		$table->EndTable();
		
		$table = new Table();
			
		$table->StartRow();
		$table->AddHeader('<center>Hunters</center>', 5);
		$table->EndRow();
		
		$table->StartRow();
		create_sort_headers($table, array('name'=>'Name', 'points'=>'Points', 'events'=>'Events', 'complete'=>'Completed Events', 'ptsvt'=>'Pts/Event'));
		$table->EndRow();
		
		$stats = array();
		
		foreach ($ka->GetHunters('', '', $kabal->GetID()) as $hunter){
			$stat = $ka->Stats($hunter, '', '', $kabal->GetID());
			
			$person = new Person($hunter);
			
			$marked = 0;
			
			foreach ($stat['events'] as $info){
				$event = new Event($info);

				if ($event->IsGraded()){
					$marked++;
				}
			}
			
			$stat['name'] = $person->GetName();
			$stat['person'] = $person;
			$stat['events'] = count($stat['events']);
			$stat['points'] = $stat['points'];
			$stat['ptsvt'] = round($stat['points']/$stat['events']);
			$stat['complete'] = $marked;
			$stats[$hunter] = $stat;
		}
		
		uasort($stats, sort_result_array);
		foreach ($stats as $stat) {
			$table->StartRow();
			$table->AddCell('<a href="/kac/stats/info.php?flag=hunter&hunter=' . $stat['person']->GetID() . '">' . $stat['person']->GetName() . '</a>');
			$table->AddCell('<div style="text-align: right">' . number_format($stat['points']) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($stat['events']) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($stat['complete']) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($stat['ptsvt']) . '</div>');
			$table->EndRow();
		}
		
		$table->EndTable();
		
	} else {
		
		$info = array();
		
		$winners = $ka->WinningKabals();
		
		foreach ($ka->GetKabals() as $kabal=>$total){
			$kabal = new Division($kabal);
			
			$info[$kabal->GetID()] = array('name'=>$kabal->GetName(), 'kabal'=>$kabal, 'points'=>$total, 'wins'=>$winners[$kabal->GetID()]);
		}
		
		$table = new Table();
		
		$table->StartRow();
		create_sort_headers($table, array('name'=>'Name', 'wins'=>'Wins', 'points'=>'Points'));
		$table->EndRow();
		
		uasort($info, sort_result_array);
			foreach ($info as $kabal) {
				$table->StartRow();
				$table->AddCell('<a href="/kac/stats/info.php?flag=kabal&kabal=' . $kabal['kabal']->GetID() . '">' . $kabal['kabal']->GetName() . '</a>');
				$table->AddCell('<div style="text-align: right">' . number_format($kabal['wins']) . '</div>');
				$table->AddCell('<div style="text-align: right">' . number_format($kabal['points']) . '</div>');
				$table->EndRow();
			}
			
		$table->EndTable();
		
	}
}

?>