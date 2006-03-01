<?php

function output(){
	global $ka;
	
	if ($_REQUEST['submit']){
		
		if (isset($_REQUEST['kac'])){
			$kac = new KAC($_REQUEST['kac']);
			
			$errors = array();
			$run = 0; 
			
			if (!count($kac->GetRounds())){
				for ($i = 1; $i <= $_REQUEST['rounds']; $i++){
					
					if (parse_date_box('start_'.$i) <= 0 || parse_date_box('end_'.$i) <= 0){
						$errors[] = 'You must have valid start and end dates for your round. (Round '.$i.')';
					}
					
					if (parse_date_box('start_'.$i) > parse_date_box('end_'.$i)){
						$errors[] = 'Your round can not start after it ends. (Round '.$i.')';
					}
					
					if (parse_date_box('start_'.$i) < $kac->Dates('SYSTEM', 'start')){
						$errors[] = 'Your round can not start before the KAC itself. (Round '.$i.')';
					}
					
					if (parse_date_box('end_'.$i) > $kac->Dates('SYSTEM', 'end')){
						$errors[] = 'Your round can not end after the KAC itself. (Round '.$i.')';
					}
					
					if (parse_date_box('end_'.$i) < $kac->Dates('SYSTEM', 'start')){
						$errors[] = 'Your round can not end before the KAC itself starts. (Round '.$i.')';
					}
					
					if (parse_date_box('start_'.$i) > $kac->Dates('SYSTEM', 'end')){
						$errors[] = 'Your round can not start after the KAC itself ends. (Round '.$i.')';
					}
					
					if (!count($errors)){
						$run++;
					}
				}
				
			} else {
				echo 'This season already has rounds.';
			}
			
			if (count($errors)){
				echo implode('<br />', $errors);
			} else {
				for ($i = 1; $i <= $run; $i++){
					if ($kac->NewRound($i, parse_date_box('start_'.$i), parse_date_box('end_'.$i))){
						echo 'New Round (Round '.$i.') started successfully.';
					} else {
						echo $kac->Error();
					}
					
					echo '<br />';
				}
			}
			
		} else {
			echo 'Missing required Season data.';
		}
		
		hr();
		
	} elseif ($_REQUEST['next']){
	
		if (isset($_REQUEST['kac'])){
			$kac = new KAC($_REQUEST['kac']);
		
			if (!count($kac->GetRounds())){
				$form = new Form($_SERVER['PHP_SELF']);
				
				$form->AddSectionTitle('Enter Round Stats');
				
				if ($_REQUEST['rounds'] > 1){
					$s = 's';
				}
				
				echo 'Season starts: '.$kac->Dates('HUMAN', 'start');
				echo '<br />Season ends: '.$kac->Dates('HUMAN', 'end');
				
				hr();
				
				for ($i = 1; $i <= $_REQUEST['rounds']; $i++){
					$form->table->AddRow('Round ID ', $i);
					$form->AddDateBox('Start', 'start_'.$i, '', true);
					$form->AddDateBox('End', 'end_'.$i, '', true);
				}
					
				$form->AddHidden('kac', $_REQUEST['kac']);
				$form->AddHidden('rounds', $_REQUEST['rounds']);
				
				$form->AddSubmitButton('submit', 'Add Round'.$s);
				$form->EndForm();
			} else {
				echo 'There is already round data for this Season.';
			}
			
		} else {
			echo 'Missing required Season data.';
		}
	
	} else {
	
		if (count($ka->GetNextKACs())){
			$form = new Form($_SERVER['PHP_SELF']);
			
			$form->AddSectionTitle('Select Season & Establish Number of Rounds');
			
			$form->StartSelect('Select KAC', 'kac');
			foreach ($ka->GetNextKACs() as $type){
				$form->AddOption($type->GetID(), 'Season '.roman($type->GetID()));
			}
			$form->EndSelect();
			
			$form->AddTextBox('Number of Rounds', 'rounds', 3, 5);
			
			$form->AddSubmitButton('next', 'Add Round Data');
			$form->EndForm();
			
		} else {
			echo 'There are no KACs which have not yet begun, hence, you can add no rounds.';
		}
		
	}
	
}

?>