<?php

function output(){
	global $ka;
	
	if (empty($_REQUEST['order'])) {
		$_REQUEST['order'] = 'points';
		$_REQUEST['sort'] = 'desc';
	}
	
	if ($_REQUEST['season']){
		$season = $_REQUEST['season'];
	} else {
		$ladder = new Ladder();
		$season = $ladder->CurrentSeason();
	}
	
	$kac = $ka->KACBySeason($season);
	
	if (is_object($kac)){
	
		if ($_REQUEST['hunter']){
		
			$stat = $ka->Stats($_REQUEST['hunter'], $kac->GetID(), '', '', '', 1);
			
			$person = new Person($_REQUEST['hunter']);
			
			$stat['person'] = $person;
	
			$events = array();
			
			$i = 0;
			$unmarked = 0;
			$marked = 0;
	
			foreach ($stat['events'] as $info){
				$event = new Event($info);
				
				$round = $event->GetRound();
				
				$type = $event->GetTypes();
				
				$status = ($event->IsGraded() ? 'Completed' : 'Unmarked');
				
				if ($event->IsGraded()){
					$marked++;
				} else {
					$unmarked++;
				}
				
				$awards = new Awards($stat['awards'][$i]);
				
				$events[$event->GetID()] = array('type'=>$type->GetName(), 'round'=>$round->GetID(), 'status'=>$status, 'place'=>$stat['places'][$i], 
							'credits'=>$awards->GetCredits('SYSTEM'), 'points'=>$stat['point'][$i], 'event'=>$event);
				
				$i++;
			}
			
			$table = new Table();
			
			$table->StartRow();
			$table->AddHeader('<center>Season Statistics for '.$stat['person']->GetName().'</center>', 2);
			$table->EndRow();
			
			$table->AddRow('Total Events', count($stat['events']));
			$table->AddRow('Unmarked Events', $unmarked);
			$table->AddRow('Completed Events', $marked);
			$table->AddRow('No Efforts', $stat['no_effort']);
			$table->AddRow('Total Credits', number_format($stat['credits']));
			
			$table->EndTable();
			
			hr();
			
			$kabal = new Division($stat['kabals'][0]);
			
			add_menu(array('KAC '.roman($kac->GetID())=>'kac/stats.php?flag=kac&season='.$kac->GetSeasonID(), 
					$stat['person']->GetName().'\'s Long Term Stats'=>'kac/stats/info.php?flag=hunter&hunter='.$stat['person']->GetID(), 
					$kabal->GetName().' Kabal'=>'kac/stats.php?flag=kabal&season='.$kac->GetSeasonID().'&kabal='.$kabal->GetID()));
			
			$table = new Table();
				
			$table->StartRow();
			create_sort_headers($table, array('type'=>'Event', 'round'=>'Round', 'status'=>'Status', 'points'=>'Points', 'place'=>'Rank', 'credits'=>'Credits'));
			$table->EndRow();
			
			$stats = array();
			
			uasort($events, sort_result_array);
			foreach ($events as $event) {
				$round = $event['event']->GetRound();
				$table->StartRow();
				$table->AddCell('<a href="/kac/stats.php?flag=event&event=' . $event['event']->GetID() . '">' . $event['type'] . '</a>');
				$table->AddCell('<a href="/kac/stats.php?flag=round&round=' . $round->GetID() . '">Round ' . $round->GetID() . '</a>');
				$table->AddCell('<div style="text-align: right">' . $event['status'] . '</div>');
				$table->AddCell('<div style="text-align: right">' . number_format($event['points']) . '</div>');
				$table->AddCell('<div style="text-align: right">' . number_format($event['place']) . '</div>');
				$table->AddCell('<div style="text-align: right">' . number_format($event['credits']) . '</div>');
				$table->EndRow();
			}
			
			$table->EndTable();
			
		} else {
			
			$top = array();
			$kabals = array();
			
			foreach ($ka->GetHunters($kac->GetID()) as $hunter){
				$stats = $ka->Stats($hunter, $kac->GetID());
				
				$top[$hunter] = $stats['points'];
				
				$key = key($stats['kabals']);
				
				$kabals[$hunter] = $stats['kabals'][$key];
			}
			
			add_menu(array('KAC '.roman($kac->GetID())=>'kac/stats.php?flag=kac&season='.$kac->GetSeasonID()));
			
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
			
			$i = 1;
			
			foreach ($top as $hunter=>$info){
				$kabal = new Division($kabals[$hunter]);
				$person = new Person($hunter);
				$table->AddRow($i, '<a href="/kac/stats.php?flag=hunter&season='.$kac->GetSeasonID().'&hunter='.$person->GetID().'">'.$person->GetName()
						.'</a>', '<a href="/kac/stats.php?flag=kabal&season='.$kac->GetSeasonID().'&kabal='.$kabal->GetID().'">'.$kabal->GetName().'</a>', number_format($info));
						
				$i++;
			}
			
			$table->EndTable();
		}
		
	} else {
		echo 'Invalid Kabal Authority Cup season';
	}
}

?>