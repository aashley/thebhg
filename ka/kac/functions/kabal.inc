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
	
		$kabal = new Division($_REQUEST['kabal']);
		
		add_menu(array('KAC '.roman($kac->GetID())=>'kac/stats.php?flag=kac&season='.$kac->GetSeasonID(), $kabal->GetName().'\'s Long Term Stats'=>'kac/stats/info.php?flag=kabal&kabal='.$kabal->GetID()));
		
		$table = new Table();
			
		$table->StartRow();
		create_sort_headers($table, array('name'=>'Name', 'points'=>'Points', 'events'=>'Events', '1'=>'1st', '2'=>'2nd', '3'=>'3rd', 'credits'=>'Credits'));
		$table->EndRow();
		
		$stats = array();
		
		foreach ($ka->GetHunters($kac->GetID(), '', $kabal->GetID()) as $hunter){
			$stat = $ka->Stats($hunter, $kac->GetID(), '', $kabal->GetID());
			
			$person = new Person($hunter);
			
			$stat['name'] = $person->GetName();
			$stat['person'] = $person;
			$stat['events'] = count($stat['events']);
			$stats[$hunter] = $stat;
		}
		
		uasort($stats, sort_result_array);
		foreach ($stats as $stat) {
			$table->StartRow();
			$table->AddCell('<a href="/kac/stats.php?flag=hunter&season=' . $kac->GetSeasonID() . '&hunter=' . $stat['person']->GetID() . '">' . $stat['person']->GetName() . '</a>');
			$table->AddCell('<div style="text-align: right">' . number_format($stat['points']) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($stat['events']) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($stat[1]) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($stat[2]) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($stat[3]) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($stat['credits']) . '</div>');
			$table->EndRow();
		}
		
		$table->EndTable();
		
	} else {
		echo 'Invalid Kabal Authority Cup season';
	}
}

?>