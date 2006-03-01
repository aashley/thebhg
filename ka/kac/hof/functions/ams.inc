<?php

function output(){
	global $ka;
	
	echo '<div><h2>KAC Hall of Fame :: Most Master\'s Shields (All-Time)</h2><p>Winning even one Master\'s Shield is a massive achievement. It '
		.'demonstrates that a hunter is among the best in the entire BHG in their chosen field, and is a force to be reckoned with. Therefore, one'
		.' can immediately tell that a hunter who has won multiple Master\'s Shields is truly one of the greats. Below is a list of the greatest.'
		.'</p></div>';
	
	$table = new Table();
	
	$table->StartRow();
	$table->AddHeader('&nbsp;');
	$table->AddHeader('Hunter');
	$table->AddHeader('Master\'s Shields');
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
		
		$stat['name'] = $person->GetName();
		$stat['person'] = $person;
		$stat['seasons'] = count($stat['season']);
		$stat['complete'] = $marked;
		$stats[$hunter] = $stat;
		
		$points[$hunter] = $stat[1];
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
		$table->AddCell('<div style="text-align: right">' . number_format($stat['seasons']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($stat['complete']) . '</div>');
		$table->EndRow();
	}
	
	$table->EndTable();
		
}

?>