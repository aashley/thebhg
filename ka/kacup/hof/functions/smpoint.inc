<?php

function output(){
	global $ka;
	
	echo '<div><h2>KAC Hall of Fame :: Most Points (Single KAC)</h2><p>High scoring hunters. Hunters love them when they\'re in the same kabal as'
		.' them, and hate them when they\'re in opposing kabals. The ability to dominate a KAC is a rare one, and can be the difference between a'
		.' kabal receiving the coveted Authority Cup or not. These hunters have shown that they can take a KAC by the scruff of the neck and '
		.'dominate it.</p></div>';
	
	$table = new Table();
	
	$table->StartRow();
	$table->AddHeader('&nbsp;');
	$table->AddHeader('Hunter');
	$table->AddHeader('Kabal');
	$table->AddHeader('Season');
	$table->AddHeader('Points');
	$table->AddHeader('Completed Events');
	$table->EndRow();
	
	$store = array();
	
	foreach ($ka->GetSeasons() as $kac){
		$stats = $kac->GetHunterTotals(10);
		
		foreach ($stats as $stat){
			$points[$kac->GetID().'_'.$stat['person']->GetID()] = $stat['points'];
		}
		
		$store[$kac->GetID()] = $stats;
	}

	arsort($points);
	
	$keys = array_keys($points);
	$i = 1;
	
	foreach ($points as $guy=>$point){
		
		$array = explode('_', $guy);
		$stats = $store[$array[0]];
		$stat = $stats[$array[1]];
		
		$table->StartRow();
		$table->AddCell($i);
		$table->AddCell('<a href="/kac/stats/info.php?flag=hunter&hunter=' . $stat['person']->GetID() . '">' . $stat['person']->GetName() . '</a>');
		$table->AddCell('<a href="/kac/stats/info.php?flag=kabal&kabal=' . $stat['kabal']->GetID() . '">' . $stat['kabal']->GetName() . '</a>');
		$table->AddCell('<a href="/kac/stats.php?flag=kac&season=' . $stat['season']->GetSeasonID() . '">'.roman($stat['season']->GetID()).'</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($point) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($stat['events']) . '</div>');
		$table->EndRow();
		$i++;
	}
	
	$table->EndTable();
		
}

?>