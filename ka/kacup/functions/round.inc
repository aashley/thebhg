<?php

function output(){
	global $ka;
	
	if ($_REQUEST['round']){
		$round = new Rounds($_REQUEST['round']);
		
		$season = $round->GetSeason();
		
		$table = new Table();
		
		$table->StartRow();
		$table->AddHeader('Event');
		$table->AddHeader('Status');
		$table->AddHeader('Start');
		$table->AddHeader('End');
		$table->EndRow();
		
		add_menu(array('KAC '.roman($season->GetSeasonID())=>'kac/stats.php?flag=kac&season='.$season->GetSeasonID()));
		
		foreach ($round->NormalEvents() as $event){
			$type = $event->GetTypes();
			$status = ($event->IsGraded() ? 'Completed' : 'Unmarked');
			$table->AddRow('<a href="/kac/stats.php?flag=event&event=' . $event->GetID() . '">' . $type->GetName() . '</a>', 
					$status, $event->Dates('HUMAN', 'start'), $event->Dates('HUMAN', 'end'));
		}
		
		$table->EndTable();
		
	} else {
		echo 'Invalid Kabal Authority Cup event';
	}
}

?>