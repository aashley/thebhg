<?php

function output(){
	global $ka, $user;
	
	$kabal = $user->GetDivision();
	
	$events = array();
	$errors = array();
	
	foreach ($ka->GetOpenKACs() as $kac){
		foreach ($kac->GetOpenRounds() as $round){
			foreach ($round->GetOpenEvents() as $event){
				$kabal_check = $ka->Stats($user->GetID(), $round->GetID(), $kac->GetID());
				
				if (count($kabal_check['kabals'])){
					$value = $kabal_check['kabals'][0];
				} else {
					$value = $kabal->GetID();
				}
				
				if ($event->CanSubmit($user->GetID(), $value, true)){
					$events[] = $event;
				} else {
					$errors[] = $event->Error();
				}
			}
		}
	}
		
	if (count($events)){
		
		$kabal = new Division($value);
		
		$table = new Table('', true);
			
		$table->StartRow();
		$table->AddHeader('Events you can Submit for - '.$user->GetName().' of '.$kabal->GetName(), 2);
		$table->EndRow();
		
		$table->AddRow('Ends', 'Event');
		
		foreach ($events as $event){
			$type = $event->GetTypes();
			$round = $event->GetRound();
			$table->AddRow($event->Dates('HUMAN', 'end'), '<a href="'.$_SERVER['PHP_SELF'].'?function=event&flag=submit&id='.$event->GetID().'">Round '
					.$round->GetRoundID().' '.$type->GetName().'</a>');
		}
		
		$table->EndRow();
		$table->EndTable();
	} else {
		$errors[] = 'There are no events for you to submit for.';
		
		$errors = array_unique($errors);
	
		if (count($errors)){
			echo implode('<br />', $errors);
		}	
	}			
		
}

?>