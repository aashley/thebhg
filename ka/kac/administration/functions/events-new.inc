<?php

function output(){
	global $ka, $uploaddir;
	
	if ($_REQUEST['submit']){
		
		if (isset($_REQUEST['round']) && isset($_REQUEST['type'])){
			$round = new Rounds($_REQUEST['round']);
			$type = new Type($_REQUEST['type']);
			$season = $round->GetSeason();
			
			$content['questions'] = $_REQUEST['question'];
			$content['answers'] = $_REQUEST['answer'];
			$errors = array();
			
			if ($type->HasImage()){
				$uploadfile = $uploaddir . $type->GetAbbr(). '-'. $round->GetID() . '-' . $season->GetID() . '.jpg';
        		if (!(move_uploaded_file($_FILES['uploadpic']['tmp_name'][1], $uploadfile)) && !(chmod($uploadfile, 0777))){
	        		$errors[] = 'Uploaded file is invalid. Follow all rules and try again. If you\'re sure you did, please report this to a Coder.';
        		}
    		}
			
			if (parse_date_box('start') > parse_date_box('end')){
				$errors[] = 'Your season can not start after it ends.';
			}
			
			if (parse_date_box('start') < $round->Dates('SYSTEM', 'start')){
				$errors[] = 'Your season can not start before the round.';
			}
			
			if (parse_date_box('start') > $round->Dates('SYSTEM', 'end')){
				$errors[] = 'Your season can not start after the round end.';
			}
			
			if (parse_date_box('end') < $round->Dates('SYSTEM', 'start')){
				$errors[] = 'Your season can not end before the round.';
			}
			
			if (parse_date_box('end') > $round->Dates('SYSTEM', 'end')){
				$errors[] = 'Your event can not end after the round.';
			}
			
			if (parse_date_box('start') <= 0 || parse_date_box('end') <= 0){
				$errors[] = 'You must have valid start and end dates for your event.';
			}
			
			if (count($errors)){
				echo implode('<br />', $errors);
			} else {			
				if ($round->NewEvent($type->GetID(), parse_date_box('start'), parse_date_box('end'), $ka->ConditionContent($content))){
					echo 'New Event added successfully.';
				} else {
					echo $round->Error();
				}
			}
			
		} else {
			echo 'Round and Type required.';
		}
		
	} elseif ($_REQUEST['next']){
		
		if (isset($_REQUEST['kac'])){
			$kac = new KAC($_REQUEST['kac']);
			
			$form = new Form($PHP_SELF);
				
			$form->AddSectionTitle('Select Round and Event Type');
			
			$form->StartSelect('Select Round', 'round');
			foreach ($kac->OpenRounds() as $type){
				$form->AddOption($type->GetID(), 'Round '.$type->GetRoundID());
			}
			$form->EndSelect();
			
			$form->StartSelect('Event Type', 'type');
			foreach ($ka->GetTypes() as $type){
				$form->AddOption($type->GetID(), $type->GetName().' ('.$type->GetAbbr().')');
			}
			$form->EndSelect();
			
			$form->AddSubmitButton('makeevent', 'Make Event >>');
			$form->EndForm();
		} else {
			echo 'Missing required Season.';
		}
		
	} elseif ($_REQUEST['makeevent']){
	
		if (isset($_REQUEST['round']) && isset($_REQUEST['type'])){
			$type = new Type($_REQUEST['type']);
			$round = new Rounds($_REQUEST['round']);
			
			echo 'Round Starts on: '.$round->Dates('HUMAN', 'start');
			echo '<br />Round Ends on: '.$round->Dates('HUMAN', 'end');
		
			hr();
			
			$form = new Form($PHP_SELF, 'post', '', 'multipart/form-data');
			
			$form->AddSectionTitle('Enter Event Stats');
			
			$form->AddHidden('type', $_REQUEST['type']);
			$form->AddHidden('round', $_REQUEST['round']);
			
			$form->table->AddRow('Event Type', $type->GetName().' ('.$type->GetAbbr().')');
			$form->table->AddRow('Event Description', $type->GetDesc());
			
			$form->AddDateBox('Start', 'start', '', true);
			$form->AddDateBox('End', 'end', '', true);
			
			if ($type->HasImage()){
				$form->AddHidden('MAX_FILE_SIZE', 300000);
				for ($i = 1; $i <= $type->GetQuestions(); $i++) {
					$form->AddFile('Upload Picture (.jpg and under 300KB)', 'uploadpic['.$i.']');
					$form->AddTextBox('Hunt Answer '.$i.'/'.$type->GetAnswers(), 'answer['.$i.']', '', 70);
				}
			} else {
				if ($type->GetQuestions() == $type->GetAnswers()){
					for ($i = 1; $i <= $type->GetAnswers(); $i++) {
						$form->AddTextBox('Hunt Question '.$i.'/'.$type->GetQuestions(), 'question['.$i.']', '', 70);
				        $form->AddTextBox('Hunt Answer '.$i.'/'.$type->GetAnswers(), 'answer['.$i.']', '', 70);
			        }
		        } else {
			        for ($i = 1; $i <= $type->GetQuestions(); $i++) {
						$form->AddTextBox('Hunt Question '.$i.'/'.$type->GetQuestions(), 'question['.$i.']', '', 70);
			        }
			        for ($i = 1; $i <= $type->GetAnswers(); $i++) {
				        $form->AddTextBox('Hunt Answer '.$i.'/'.$type->GetAnswers(), 'answer['.$i.']', '', 70);
			        }
		        }
	        }			
							
			$form->AddSubmitButton('submit', 'Add Event');
			$form->EndForm();
		} else {
			echo 'Missing required Round or Event Type.';
		}
	
	} else {
		
		$events = array();
		
		if (count($ka->GetNextKACs()) || count($ka->GetOpenKACs())){
			
			foreach ($ka->GetNextKACs() as $type){
				if (count($type->OpenRounds())){
					$events[] = $type;
				}
			}
			
			foreach ($ka->GetOpenKACs() as $type){
				if (count($type->OpenRounds())){
					$events[] = $type;
				}
			}
			
			$events = array_unique($events);
			
			if (count($events)){
			
				$form = new Form($PHP_SELF);
				
				$form->AddSectionTitle('Select Season');
				
				$form->StartSelect('Select KAC', 'kac');
				foreach ($events as $type){
					$form->AddOption($type->GetID(), 'Season '.roman($type->GetID()));
				}
				$form->EndSelect();
				
				$form->AddSubmitButton('next', 'Select Round >>');
				$form->EndForm();
				
			} else {
				echo 'There are no seasons with rounds to make events for.';	
			}
		} else {
			echo 'There are no open seasons.';
		}
		
	}
	
}

?>