<?php

function output(){
	global $ka;
	
	echo '<div><h2>KAC Hall of Fame :: Most Points (All-Time)</h2><p>Some hunters prefer to specialise in their own pet events, rather than '
		.'competing in a broad range of events. This is reflected by their high average of points per event, although they may not have a high '
		.'overall point total. This table shows the hunters who have the highest average of all.</p></div>';
	
	$table = new Table();
	
	$table->StartRow();
	$table->AddHeader('&nbsp;');
	$table->AddHeader('Hunter');
	$table->AddHeader('Point Average');
	$table->AddHeader('Points');
	$table->AddHeader('KACs');
	$table->AddHeader('Completed Events');
	$table->EndRow();
	
	$stats = array();
	$points = array();
		
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
		
		if ($marked > 10){
		
			$stat['name'] = $person->GetName();
			$stat['person'] = $person;
			$stat['seasons'] = count($stat['season']);
			$stat['complete'] = $marked;
			$stat['points'] = $stat['points'];
			$stats[$hunter] = $stat;
			
			$points[$hunter] = round($stat['points']/$marked, 1);
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
		$table->AddCell('<div style="text-align: right">' . number_format($point) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($stat['points']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($stat['seasons']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($stat['complete']) . '</div>');
		$table->EndRow();
	}
	
	$table->EndTable();
		
}

?>