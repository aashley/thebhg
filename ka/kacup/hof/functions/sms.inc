<?php

function output(){
	global $ka;
	
	echo '<div><h2>KAC Hall of Fame :: Most Master\'s Shields (Single KAC)</h2><p>Dominating a KAC is no easy feat. Dominating it to such an extent'
		.' that a hunter wins more than one Master\'s Shield is even harder. The hunters below have managed just that.</p></div>';
	
	$table = new Table();
	
	$table->StartRow();
	$table->AddHeader('&nbsp;');
	$table->AddHeader('Hunter');
	$table->AddHeader('Kabal');
	$table->AddHeader('KAC');
	$table->AddHeader('Master\'s Shields');
	$table->AddHeader('Completed Events');
	$table->EndRow();
	
	$stats = array();
	$points = array();
	
	foreach ($ka->GetSeasons() as $season){
		foreach ($ka->GetHunters($season->GetID()) as $hunter){
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
			$stat['season'] = $season;
			$stat['complete'] = $marked;
			$stat['kabal'] = new Division($stat['kabals'][0]);
			$stats[$hunter] = $stat;
			
			$points[$hunter] = $stat[1];
		}
	}

	arsort($points);
	
	$keys = array_keys($points);
	
	if (count($stats) > 10){
		$run = 10;
	} else {
		$run = count($stats);
	}
	
	for ($i = 1; $i <= $run; $i++){
		
		$key = $keys[$i-1];
		
		$point = $points[$key];
		$stat = $stats[$key];
		
		$table->StartRow();
		$table->AddCell($i);
		$table->AddCell('<a href="/kac/stats/info.php?flag=hunter&hunter=' . $stat['person']->GetID() . '">' . $stat['person']->GetName() . '</a>');
		$table->AddCell('<a href="/kac/stats/info.php?flag=kabal&kabal=' . $stat['kabal']->GetID() . '">' . $stat['kabal']->GetName() . '</a>');
		$table->AddCell('<a href="/kac/stats.php?flag=kac&season=' . $stat['season']->GetSeasonID() . '">'.roman($stat['season']->GetSeasonID()).'</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($point) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($stat['complete']) . '</div>');
		$table->EndRow();
	}
	
	$table->EndTable();
		
}

?>