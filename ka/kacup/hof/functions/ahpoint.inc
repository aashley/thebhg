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
	$table->AddHeader('Completed Events');
	$table->EndRow();
	
	$stats = $ka->GetHunterTotals();
	
	foreach ($stats as $stat){
		if ($stat['events'] >= 10){
			$points[$stat['person']->GetID()] = $stat['ptsvt'];
		}
	}

	arsort($points);
	
	if (count($points) > 10){
		$points = array_slice($points, 0, 10, true);
	}
	$i = 1;
	
	foreach ($points as $guy=>$point){
		
		$stat = $stats[$guy];
		
		$table->StartRow();
		$table->AddCell($i);
		$table->AddCell('<a href="/kac/stats/info.php?flag=hunter&hunter=' . $stat['person']->GetID() . '">' . $stat['person']->GetName() . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($point) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($stat['points']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($stat['events']) . '</div>');
		$table->EndRow();
		$i++;
	}
	
	$table->EndTable();
		
}

?>