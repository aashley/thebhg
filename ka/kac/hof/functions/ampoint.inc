<?php

function output(){
	global $ka;
	
	echo '<div><h2>KAC Hall of Fame :: Most Points (All-Time)</h2><p>Some hunters accumulate their points steadily over many KACs, other flame '
		.'like a shooting star for a handful of KACs and seemingly gain points at will during that period. But whether they are a tortoise or a hare,'
		.' the hunters on this list have proven over time that they are the best of the best.</p></div>';
	
	$table = new Table();
	
	$table->StartRow();
	$table->AddHeader('&nbsp;');
	$table->AddHeader('Hunter');
	$table->AddHeader('Points');
	$table->AddHeader('Points Per Event');
	$table->AddHeader('Completed Events');
	$table->EndRow();
	
	$stats = $ka->GetHunterTotals(10);
	
	foreach ($stats as $stat){
		$points[$stat['person']->GetID()] = $stat['points'];
	}

	arsort($points);
	
	$keys = array_keys($points);
	$i = 1;
	
	foreach ($points as $guy=>$point){
		
		$stat = $stats[$guy];
		
		$table->StartRow();
		$table->AddCell($i);
		$table->AddCell('<a href="/kac/stats/info.php?flag=hunter&hunter=' . $stat['person']->GetID() . '">' . $stat['person']->GetName() . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($point) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($stat['ptsvt']) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($stat['events']) . '</div>');
		$table->EndRow();
		$i++;
	}
	
	$table->EndTable();
		
}

?>