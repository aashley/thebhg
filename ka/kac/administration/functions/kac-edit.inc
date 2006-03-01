<?php

function output(){
	global $ka;
	
	if ($_REQUEST['delete']){
		
		if (isset($_REQUEST['kac'])){
			
			$kac = new KAC($_REQUEST['kac']);
			
			if ($kac->DeleteHandler($_REQUEST['del_flag'])){
				echo 'KAC successfully '.strtolower($_REQUEST['del_flag']).'d.';
			} else {
				echo $kac->Error();
			}
			
		} else {
			echo 'Error passing the required KAC field';
		}
		
	} elseif ($_REQUEST['submit']){
		
		if (isset($_REQUEST['kac'])){
			
			$kac = new KAC($_REQUEST['kac']);
			$errors = array();
		
			if (parse_date_box('start') > parse_date_box('end')){
				$errors[] = 'Your season can not start after it ends.';
			}
			
			if ($_REQUEST['maximum'] < $_REQUEST['minimum']){
				$errors[] = 'Your maximum points can not be smaller than your minimum points.';
			}
			
			if ($_REQUEST['kabal_count'] <= 0){
				$errors[] = 'You must have a positive kabal count amount, or the season won\'t work.';
			}
			
			if (!count($errors)){
			
				$edits = Array('season_id'=>$_REQUEST['id'], 'start'=>parse_date_box('start'), 'end'=>parse_date_box('end'), 
							'maximum'=>$_REQUEST['maximum'], 'minimum'=>$_REQUEST['minimum'], 'kabal_count'=>$_REQUEST['kabal_count']);
				
				$edit_errors = 0;
												
				foreach ($edits as $table=>$value){
					if (!$kac->SetPiece($table, $value)){
						$edit_errors++;
					}
				}
				
				if ($edit_errors){
					echo $edit_errors.' errors were made when trying to complete the Edit. Please tell a Coder as soon as possible.';
					echo '<br /><br />'.$kac->Error();
				} else {
					echo 'KAC edited successfully.';
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
			
			$form->AddSectionTitle('Season Delete Management');
			
			if ($kac->Deleted('CHECK')){
				$prefix = 'This KAC is currently listed as <b>ACTIVE</b>';
				$button = 'Delete';
				$form->AddHidden('del_flag', 'DELETE');
			} else {
				$prefix = 'This KAC was <b>DELETED</b> on '.$kac->Deleted('HUMAN');
				$button = 'Undelete';
				$form->AddHidden('del_flag', 'UNDELETE');
			}
			
			$form->AddHidden('kac', $_REQUEST['kac']);
			
			$form->table->AddRow($prefix);
			$form->table->AddRow('<input type="submit" value="'.$button.' This KAC" name="delete">');
			$form->EndForm();
			
			hr();
	
			$form = new Form($_SERVER['PHP_SELF']);
			
			$form->AddSectionTitle('Edit Season Stats');
			
			$form->AddTextBox('Last KAG Season', 'id', $kac->GetSeasonID(), 5);
			$form->AddDateBox('Start', 'start', $kac->Dates('SYSTEM', 'start'), true);
			$form->AddDateBox('End', 'end', $kac->Dates('SYSTEM', 'end'), true);
			$form->AddTextBox('Maximum Points', 'maximum', $kac->GetMaximum(true), 5);
			$form->AddTextBox('Minimum Points', 'minimum', $kac->GetMinimum(true), 5);
			$form->AddTextBox('Top Finishers Per Kabal', 'kabal_count', $kac->GetKabalCount(), 5);
				
			$form->AddHidden('kac', $_REQUEST['kac']);
			
			$form->AddSubmitButton('submit', 'Make Modifications');
			$form->EndForm();
			
			echo "
			Notes:
			<ul>
				<li><b>Last KAG Season Number</b>: This is the number which corresponds to the last season of the KAG and is used to generate the brackets. If you just finished KAG 70, enter 70 in this box.</li>
				<li><b>Maximum Points</b>: The number of points which is maximum for hunters, plus one for events. So if you want 10 points (the standard) the max points are 11.</li>
				<li><b>Minimum Points</b>: The minimum number of points hunters will get for completing an event. If you want zero, put 1, just as with maximum.</li>
				<li><b>Top Finishers per Kabal</b>: Usually 5, it is the number of entries received per kabal when tabulating kabal vs. kabal ranks.</li>
			</ul>
			";
			
		} else {
			echo 'KAC required.';
		}
	
	} else {
	
		$form = new Form($_SERVER['PHP_SELF']);
		
		$form->StartSelect('Select KAC', 'kac');
		foreach ($ka->AllSeasons() as $type){
			$form->AddOption($type->GetID(), 'Season '.roman($type->GetID()));
		}
		$form->EndSelect();
		
		$form->AddSubmitButton('next', 'Continue to Edit >>');
		$form->EndForm();
		
	}
	
}

?>