<?php

function output(){
	global $ka;
	
	if ($_REQUEST['delete']){
		
		if (isset($_REQUEST['kac'])){
			
			$kac = new KAC($_REQUEST['kac']);
			
			$dels = 0;
			
			foreach ($kac->AllRounds() as $round){
				
				if ($_REQUEST['process_'.$round->GetRoundID()]){
					if ($round->DeleteHandler($_REQUEST['del_flag_'.$round->GetRoundID()])){
						echo 'Round '.$round->GetRoundID().' successfully '.strtolower($_REQUEST['del_flag_'.$round->GetRoundID()]).'d.';
					} else {
						echo $round->Error();
					}
					echo '<br />';
					$dels++;
				}
				
			}
			
			if ($dels == 0){
				echo 'No changes to status of rounds.';
			}
			
		} else {
			echo 'Error passing the required KAC field';
		}
		
	} elseif ($_REQUEST['submit']){
		
		if (isset($_REQUEST['kac'])){
			
			$kac = new KAC($_REQUEST['kac']);
			$errors = array();
		
			foreach ($kac->AllRounds() as $round){
			
				if (parse_date_box('start_'.$round->GetRoundID()) <= 0 || parse_date_box('end_'.$round->GetRoundID()) <= 0){
					$errors[] = 'You must have valid start and end dates for your round. (Round '.$round->GetRoundID().')';
				}
				
				if (parse_date_box('start_'.$round->GetRoundID()) > parse_date_box('end_'.$round->GetRoundID())){
					$errors[] = 'Your round can not start after it ends. (Round '.$round->GetRoundID().')';
				}
				
				if (parse_date_box('start_'.$round->GetRoundID()) < $kac->Dates('SYSTEM', 'start')){
					$errors[] = 'Your round can not start before the KAC itself. (Round '.$round->GetRoundID().')';
				}
				
				if (parse_date_box('end_'.$round->GetRoundID()) > $kac->Dates('SYSTEM', 'end')){
					$errors[] = 'Your round can not end after the KAC itself. (Round '.$round->GetRoundID().')';
				}
				
				if (parse_date_box('end_'.$round->GetRoundID()) < $kac->Dates('SYSTEM', 'start')){
					$errors[] = 'Your round can not end before the KAC itself starts. (Round '.$round->GetRoundID().')';
				}
				
				if (parse_date_box('start_'.$round->GetRoundID()) > $kac->Dates('SYSTEM', 'end')){
					$errors[] = 'Your round can not start after the KAC itself ends. (Round '.$round->GetRoundID().')';
				}
				
			}
			
			if (!count($errors)){
			
				foreach ($kac->AllRounds() as $round){
				
					$edits = Array('round_id'=>$round->GetRoundID(), 'start'=>parse_date_box('start_'.$round->GetRoundID()),
								'end'=>parse_date_box('end_'.$round->GetRoundID()));
					
					$edit_errors = 0;
													
					foreach ($edits as $table=>$value){
						if (!$round->SetPiece($table, $value)){
							$edit_errors++;
						}
					}
					
					if ($edit_errors){
						echo $edit_errors.' errors were made when trying to complete the Edit. Please tell a Coder as soon as possible.';
						echo '<br /><br />'.$ka->Error();
					} else {
						echo 'Round '.$round->GetRoundID().' edited successfully.<br />';
					}
					
				}
				
			} else {
				echo implode('<br />', $errors);
			}
			
		} else {
			echo 'Error passing the required KAC field';
		}
		
	} elseif ($_REQUEST['next']){
		
		if (isset($_REQUEST['kac'])){
			$kac = new KAC($_REQUEST['kac']);
			
			$form = new Form($_SERVER['PHP_SELF']);
			
			$form->AddSectionTitle('Round Delete Management');
			
			foreach ($kac->AllRounds() as $round){
			
				if ($round->Deleted('CHECK')){
					$prefix = 'This Round (Round '.$round->GetRoundID().') is currently listed as <b>ACTIVE</b>';
					$button = 'Delete';
					$form->AddHidden('del_flag_'.$round->GetRoundID(), 'DELETE');
				} else {
					$prefix = 'This Round (Round '.$round->GetRoundID().') was <b>DELETED</b> on '.$round->Deleted('HUMAN');
					$button = 'Undelete';
					$form->AddHidden('del_flag_'.$round->GetRoundID(), 'UNDELETE');
				}
				
				$form->table->AddRow('Round Status: ', $prefix);
				$form->AddRadioButton($button.' Round '.$round->GetRoundID(), 'process_'.$round->GetRoundID(), 1);
				$form->AddRadioButton('Make No Change to Round '.$round->GetRoundID(), 'process_'.$round->GetRoundID(), 0, true);
				
			}
			
			$form->AddHidden('kac', $_REQUEST['kac']);
			
			$form->table->StartRow();
			$form->table->AddCell('<input type="submit" value="Process Delete Actions" name="delete">', 2);
			$form->table->EndRow();
			$form->EndForm();
			
			hr();

			$form = new Form($_SERVER['PHP_SELF']);
			
			$form->AddSectionTitle('Edit Round Stats');
			
			foreach ($kac->AllRounds() as $round){

				$form->table->AddRow('Round ID ', $round->GetRoundID());
				$form->AddDateBox('Start', 'start_'.$round->GetRoundID(), $round->Dates('SYSTEM', 'start'), true);
				$form->AddDateBox('End', 'end_'.$round->GetRoundID(), $round->Dates('SYSTEM', 'end'), true);

			}
			
			$form->AddHidden('kac', $_REQUEST['kac']);
			
			$form->AddSubmitButton('submit', 'Make Modifications');
			$form->EndForm();
			
		} else {
			echo 'KAC required.';
		}
	
	} else {
		
		$events = array();
		
		if (count($ka->GetNextKACs()) || count($ka->GetOpenKACs())){
			
			foreach ($ka->GetNextKACs() as $type){
				if (count($type->AllRounds())){
					$events[] = $type;
				}
			}
			
			foreach ($ka->GetOpenKACs() as $type){
				if (count($type->AllRounds())){
					$events[] = $type;
				}
			}
			
			if (count($events)){
			
				$form = new Form($_SERVER['PHP_SELF']);
				
				$form->AddSectionTitle('Select Season');
				
				$form->StartSelect('Select KAC', 'kac');
				foreach ($events as $type){
					$form->AddOption($type->GetID(), 'Season '.roman($type->GetID()));
				}
				$form->EndSelect();
				
				$form->AddSubmitButton('next', 'Continue to Edit >>');
				$form->EndForm();
				
			} else {
				echo 'There are no seasons with rounds to edit.';	
			}
		} else {
			echo 'There are no open seasons.';
		}
		
	}
	
}

?>