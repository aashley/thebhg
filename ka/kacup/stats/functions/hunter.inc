<?php

function output(){
	global $ka;
	
	if (empty($_REQUEST['order'])) {
		$_REQUEST['order'] = 'points';
		$_REQUEST['sort'] = 'desc';
	}
	
	if ($_REQUEST['hunter']){
		
			$stat = $ka->Stats($_REQUEST['hunter'], '', '', '', '', 1);
			
			$person = new Person($_REQUEST['hunter']);
			
			$stat['person'] = $person;
	
			$events = array();
			$kabals = array();
			
			$i = 0;
			$unmarked = 0;
			$marked = 0;
			
			foreach ($stat['kabals'] as $kabal){
				$kabal = new Division($kabal);
				
				$kabals[$kabal->GetID()] = $kabal->GetName();
			}			
	
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
			$table->AddHeader('<center>Overall Statistics for '.$stat['person']->GetName().'</center>', 2);
			$table->EndRow();
			
			asort($kabals);
			$table->StartRow();
			$table->AddCell('Kabal' . ((count($kabals) == 1) ? '' : 's'), 1, count($kabals));
			$first = true;
			foreach ($kabals as $kid=>$name) {
				if ($first) {
					$first = false;
				}
				else {
					$table->StartRow();
				}
				$table->AddCell('<a href="info.php?flag=kabal&kabal=' . $kid . '">' . $name . '</a>');
				$table->EndRow();
			}
			
			$season_data = $stat['season'];
			asort($season_data);
			$first = new KAC(array_shift($season_data));
			
			$season_data = $stat['season'];			
			arsort($season_data);			
			$last = new KAC(array_shift($season_data));
			
			$table->AddRow('First KAC', $first->GetID());
			$table->AddRow('Most Recent KAC', $last->GetID());
			$table->AddRow('Total Events', number_format(count($stat['events'])));
			$table->AddRow('Total Points', number_format($stat['points']));
			$table->AddRow('Average Points per Event', number_format($stat['points']/count($stat['events'])));
			$table->AddRow('Unmarked Events', $unmarked);
			$table->AddRow('Completed Events', $marked);
			$table->AddRow('No Efforts', $stat['no_effort']);
			$table->AddRow('Total Credits', number_format($stat['credits']));
			$table->AddRow('Master\'s Shields', number_format($stat[1]));
			
			$table->EndTable();
			
			$table = new Table();
			
			$table->StartRow();
			$table->AddHeader('<center>KACs</center>', 5);
			$table->EndRow();
			
			$table->StartRow();
			$table->AddHeader('KAC');
			$table->AddHeader('Kabal');
			$table->AddHeader('Points');
			$table->AddHeader('Completed Events');
			$table->AddHeader('Points/Event');
			$table->EndRow();
			
			foreach ($stat['season'] as $season){
				$season = new KAC($season);
				$stats = $ka->Stats($person->GetID(), $season->GetID());
				
				$marked = 0;
			
				foreach ($stats['events'] as $info){
					$event = new Event($info);
	
					if ($event->IsGraded()){
						$marked++;
					}
				}
				
				$kabal = array_pop($stat['kabals']);
				
				$kabal = new Division($kabal);
				
				$table->AddRow('<a href="/kac/stats.php?flag=hunter&hunter='.$person->GetID().'&season='.$season->GetSeasonID().'">KAC '.
					roman($season->GetID()).'</a>', '<a href="/kac/stats.php?flag=kabal&kabal='.$kabal->GetID().'&season='.$season->GetSeasonID()
					.'">'.$kabal->GetName().'</a>', number_format($stat['points']), number_format($marked), number_format($stat['points']/$marked));
			}
			
			$table->EndTable();
			
			$table = new Table();
			
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
				
				$events[$event->GetID()] = array('kac'=>$round->GetSeason(), 'type'=>$type->GetName(), 'round'=>$round->GetID(), 'status'=>$status, 
					'place'=>$stat['places'][$i], 'credits'=>$awards->GetCredits('SYSTEM'), 'points'=>$stat['point'][$i], 'event'=>$event);
				
				$i++;
			}
			
			$table->StartRow();
			create_sort_headers($table, array('kac'=>'KAC', 'type'=>'Event', 'round'=>'Round', 'status'=>'Status', 'points'=>'Points', 'place'=>'Rank', 'credits'=>'Credits'));
			$table->EndRow();
			
			$stats = array();
			
			uasort($events, sort_result_array);
			foreach ($events as $event) {
				$round = $event['event']->GetRound();
				$table->StartRow();
				$table->AddCell('<a href="/kac/stats.php?flag=kac&season=' . $event['kac']->GetID() . '">KAC '.roman($event['kac']->GetID()).'</a>');
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
		
		$table = new Table();
			
		$table->StartRow();
		$table->AddHeader('<center>Hunters</center>', 5);
		$table->EndRow();
		
		$table->StartRow();
		create_sort_headers($table, array('name'=>'Name', 'points'=>'Points', 'events'=>'Events', 'complete'=>'Completed Events', 'ptsvt'=>'Pts/Event'));
		$table->EndRow();
		
		$stats = array();
		
		foreach ($ka->GetHunters() as $hunter){
			$stat = $ka->Stats($hunter);
			
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
		
	}
}

?>