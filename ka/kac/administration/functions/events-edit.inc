<?php

function output(){
	global $ka, $uploaddir;
	
	if ($_REQUEST['delete']){
		
		if (isset($_REQUEST['event'])){
			
			$event = new Event($_REQUEST['event']);
			
			if ($event->DeleteHandler($_REQUEST['del_flag'])){
				echo 'Event successfully '.strtolower($_REQUEST['del_flag']).'d.';
			} else {
				echo $event->Error();
			}
			
		} else {
			echo 'Error passing the required event field';
		}
		
	} elseif ($_REQUEST['submit']){
		
		if (isset($_REQUEST['round']) && isset($_REQUEST['event'])){
			$round = new Rounds($_REQUEST['round']);
			$event = new Event($_REQUEST['event']);
			
			$season = $round->GetSeason();
			$type = $event->GetTypes();			
			
			$content['questions'] = $_REQUEST['question'];
			$content['answers'] = $_REQUEST['answer'];
			$errors = array();

			if ($type->HasImage()){
				if ($_FILES['uploadhunt']['error'][1] != 4){
					$uploadfile = $uploaddir . $type->GetAbbr(). '-'. $round->GetID() . '-' . $season->GetID() . '.jpg';
	        		if (!(move_uploaded_file($_FILES['uploadpic']['tmp_name'][1], $uploadfile)) && !(chmod($uploadfile, 0777))){
		        		$errors[] = 'Uploaded file is invalid. Follow all rules and try again. If you\'re sure you did, please report this to a Coder.';
	        		}
	    		} 
    		}
    		
    		if (parse_date_box('start') <= 0 || parse_date_box('end') <= 0){
				$errors[] = 'You must have valid start and end dates for your event.';
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
			
			if (count($errors)){
				echo implode('<br />', $errors);
			} else {			
				
				$edits = Array('type'=>$type->GetID(), 'start'=>parse_date_box('start'), 'end'=>parse_date_box('end'), 
							'content'=>$ka->ConditionContent($content));
				
				$edit_errors = 0;
												
				foreach ($edits as $table=>$value){
					if (!$event->SetPiece($table, $value)){
						$edit_errors++;
					}
				}
				
				if ($edit_errors){
					echo $edit_errors.' errors were made when trying to complete the Edit. Please tell a Coder as soon as possible.';
					echo '<br /><br />'.$event->Error();
				} else {
					echo 'Event edited successfully.';
				}
			}
			
		} else {
			echo 'Round and Event required.';
		}
		
	} elseif ($_REQUEST['getevent']){
		
		if (isset($_REQUEST['round'])){
			$round = new Rounds($_REQUEST['round']);
			
			if ($round->GetEvents()){
			
				$form = new Form($_SERVER['PHP_SELF']);
					
				$form->AddSectionTitle('Select Event');
				
				$form->StartSelect('Select Event', 'event');
				foreach ($round->AllEvents() as $event){
					$type = $event->GetTypes();
					$form->AddOption($event->GetID(), $type->GetName());
				}
				$form->EndSelect();
				
				$form->AddHidden('round', $_REQUEST['round']);
				
				$form->AddSubmitButton('editevent', 'Continue to Edit >>');
				$form->EndForm();
				
			} else {
				echo 'This round has no events.';
			}
		} else {
			echo 'Missing required Round.';
		}
		
	} elseif ($_REQUEST['next']){
		
		if (isset($_REQUEST['kac'])){
			$kac = new KAC($_REQUEST['kac']);
			
			$form = new Form($_SERVER['PHP_SELF']);
				
			$form->AddSectionTitle('Select Round');
			
			$form->StartSelect('Select Round', 'round');
			foreach ($kac->OpenRounds() as $type){
				$form->AddOption($type->GetID(), 'Round '.$type->GetRoundID());
			}
			$form->EndSelect();
			
			$form->AddSubmitButton('getevent', 'Select Event >>');
			$form->EndForm();
		} else {
			echo 'Missing required Season.';
		}
		
	} elseif ($_REQUEST['editevent']){
	
		if (isset($_REQUEST['round']) && isset($_REQUEST['event'])){
			$event = new Event($_REQUEST['event']);
			$round = new Rounds($_REQUEST['round']);
			
			$type = $event->GetTypes();
			$season = $round->GetSeason();
			
			$content = $event->GetContent();
		    $question = $content['questions'];
		    $answer = $content['answers'];
		    
		    $form = new Form($_SERVER['PHP_SELF']);
			
			$form->AddSectionTitle('Event Delete Management');
			
			if ($event->Deleted('CHECK')){
				$prefix = 'This event is currently listed as <b>ACTIVE</b>';
				$button = 'Delete';
				$form->AddHidden('del_flag', 'DELETE');
			} else {
				$prefix = 'This event was <b>DELETED</b> on '.$event->Deleted('HUMAN');
				$button = 'Undelete';
				$form->AddHidden('del_flag', 'UNDELETE');
			}
			
			$form->AddHidden('event', $_REQUEST['event']);
			
			$form->table->AddRow($prefix);
			$form->table->AddRow('<input type="submit" value="'.$button.' This Event" name="delete">');
			$form->EndForm();
			
			hr();
		    
			echo 'Round Starts on: '.$round->Dates('HUMAN', 'start');
			echo '<br />Round Ends on: '.$round->Dates('HUMAN', 'end');
		
			hr();
			
			$form = new Form($_SERVER['PHP_SELF'], 'post', '', 'multipart/form-data');
			
			$form->AddSectionTitle('Edit Event Stats');
			
			$form->AddHidden('event', $_REQUEST['event']);
			$form->AddHidden('round', $_REQUEST['round']);
			
			$form->table->AddRow('Event Type', $type->GetName().' ('.$type->GetAbbr().')');
			$form->table->AddRow('Event Description', $type->GetDesc());
			
			$form->AddDateBox('Start', 'start', $event->Dates('SYSTEM', 'start'), true);
			$form->AddDateBox('End', 'end', $event->Dates('SYSTEM', 'end'), true);
			
			if ($type->HasImage()){
				$form->table->AddRow('Current Image', '<center><img src="/kac/event_images/'.$type->GetAbbr(). '-'. $round->GetID() . '-' 
							. $season->GetID() . '.jpg">');
				$form->AddHidden('MAX_FILE_SIZE', 300000);
				for ($i = 1; $i <= $type->GetQuestions(); $i++) {
					$form->AddFile('Upload Picture (.jpg and under 300KB)', 'uploadpic['.$i.']');
					$form->AddTextBox('Hunt Answer '.$i.'/'.$type->GetAnswers(), 'answer['.$i.']', stripslashes($answer[$i]), 70);
				}
			} else {
				if ($type->GetQuestions() == $type->GetAnswers()){
					for ($i = 1; $i <= $type->GetAnswers(); $i++) {
						$form->AddTextBox('Hunt Question '.$i.'/'.$type->GetQuestions(), 'question['.$i.']', stripslashes($question[$i]), 70);
				        $form->AddTextBox('Hunt Answer '.$i.'/'.$type->GetAnswers(), 'answer['.$i.']', stripslashes($answer[$i]), 70);
			        }
		        } else {
			        for ($i = 1; $i <= $type->GetQuestions(); $i++) {
						$form->AddTextBox('Hunt Question '.$i.'/'.$type->GetQuestions(), 'question['.$i.']', stripslashes($question[$i]), 70);
			        }
			        for ($i = 1; $i <= $type->GetAnswers(); $i++) {
				        $form->AddTextBox('Hunt Answer '.$i.'/'.$type->GetAnswers(), 'answer['.$i.']', stripslashes($answer[$i]), 70);
			        }
		        }
	        }			
							
			$form->AddSubmitButton('submit', 'Edit Event');
			$form->EndForm();
		} else {
			echo 'Missing required Round or Event.';
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
			
			if (count($events)){
			
				$form = new Form($_SERVER['PHP_SELF']);
				
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