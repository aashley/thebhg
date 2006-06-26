<?php
include_once('header.php');

page_header('Edit CG Events');

if ($level == 3) {
	if ($_REQUEST['submit']) {
		foreach ($_REQUEST['events'] as $i=>$name) {
			$event =& $ka->GetEvent($i);
			
			if ($event->IsTimed()){
				$type = $event->GetTypes();
			} else {
				$type = '';
			}
			
			if (is_object($type)){
				$content['questions'] = $_REQUEST['question'][$event->GetID()];
				$content['answers'] = $_REQUEST['answer'][$event->GetID()];
				
				if (!$event->SetTeam(isset($_REQUEST['teams'][$event->getID()]) ? 1 : 0) || !$event->SetContent($ka->ConditionContent($content)) || !$event->SetTime(parse_date_box("events{$i}_start"), parse_date_box("events{$i}_end"))){
					echo 'Error saving event ID ' . $i . '.<br />';
				}
				
				if ($type->HasImage()){
					if ($_FILES['uploadhunt']['error'][$event->GetID()] != 4){
						$uploadfile = $uploaddir . $type->GetAbbr(). '-'. $_REQUEST['id'] . '-' . $event->GetID() . '.jpg';
		        		if (!(move_uploaded_file($_FILES['uploadpic']['tmp_name'][$event->GetID()], $uploadfile)) && !(chmod($uploadfile, 0777))){
			        		echo 'Uploaded file is invalid. Follow all rules and try again. If you\'re sure you did, please report this to a Coder.<br />';
		        		}
		    		} 
	    		}
    		} else {
	    		if (!$event->SetTeam(isset($_REQUEST['teams'][$event->getID()]) ? 1 : 0) || !$event->SetName($name) || !$event->SetTime(parse_date_box("events{$i}_start"), parse_date_box("events{$i}_end"))) {
					echo 'Error saving event ID ' . $i . '.<br />';
				}
			}
		}
		echo 'Events saved.';
	}
	elseif ($_REQUEST['id']) {
		$CG =& $ka->GetCG($_REQUEST['id']);
		$form = new Form($_SERVER['PHP_SELF'], 'post', '', 'multipart/form-data');
		$row = 0;
		
		$form->AddHidden('id', $_REQUEST['id']);
		
		foreach ($CG->GetEvents() as $event) {
			$form->table->StartRow();
			$form->table->AddHeader('Event ' . (++$row), 2);
			$form->table->EndRow();

			if ($event->IsTimed()){
				$form->AddHidden('events[' . $event->GetID() . ']', 'Die!');
				$type = $event->GetTypes();
				$form->table->AddRow('Event Type', $type->GetName().' ('.$type->GetAbbr().')');
				$content = $event->GetContent();
				$answer = $content['answers'];
				$question = $content['questions'];
				if ($type->HasImage()){
					$form->table->AddRow('Current Image', '<center><img src="/CG/hunt_images/'.$type->GetAbbr(). '-'. $CG->GetID() . '-' 
								. $event->GetID() . '.jpg">');
					$form->AddHidden('MAX_FILE_SIZE', 300000);
					for ($i = 1; $i <= $type->GetQuestions(); $i++) {
						$form->AddFile('Upload Picture (.jpg and under 300KB)', 'uploadpic[' . $event->GetID() .']');
						$form->AddTextBox('Hunt Answer '.$i.'/'.$type->GetAnswers(), 'answer[' . $event->GetID() .']['.$i.']', stripslashes($answer[$i]), 70);
					}
				} else {
					if ($type->GetQuestions() == $type->GetAnswers()){
						for ($i = 1; $i <= $type->GetAnswers(); $i++) {
							$form->AddTextBox('Hunt Question '.$i.'/'.$type->GetQuestions(), 'question[' . $event->GetID() .']['.$i.']', stripslashes($question[$i]), 70);
					        $form->AddTextBox('Hunt Answer '.$i.'/'.$type->GetAnswers(), 'answer[' . $event->GetID() .']['.$i.']', stripslashes($answer[$i]), 70);
				        }
			        } else {
				        for ($i = 1; $i <= $type->GetQuestions(); $i++) {
							$form->AddTextBox('Hunt Question '.$i.'/'.$type->GetQuestions(), 'question[' . $event->GetID() .']['.$i.']', stripslashes($question[$i]), 70);
				        }
				        for ($i = 1; $i <= $type->GetAnswers(); $i++) {
					        $form->AddTextBox('Hunt Answer '.$i.'/'.$type->GetAnswers(), 'answer[' . $event->GetID() .']['.$i.']', stripslashes($answer[$i]), 70);
				        }
			        }
		        }
			} else {
				$form->AddTextBox('Name:', 'events[' . $event->GetID() . ']', $event->GetName());
			}
			$form->AddDateBox('Start Date:', 'events' . $event->GetID() . '_start', $event->GetStart(), true);
			$form->AddDateBox('End Date:', 'events' . $event->GetID() . '_end', $event->GetEnd(), true);
			if ($event->IsTimed()){
				$form->AddHidden("teams[" . $event->getID() . ']', 0);
			} else {
				$form->AddCheckBox('Team Event?', "teams[" . $event->getID() . ']', 1, $event->IsTeam());
			}
		}
		$form->AddSubmitButton('submit', 'Save Events');
		$form->EndForm();
	}
	else {
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->StartSelect('CG:', 'id');
		foreach (array_reverse($ka->GetCGs()) as $CG) {
			$form->AddOption($CG->GetID(), roman($CG->GetID()));
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit Events');
		$form->EndForm();
	}
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>
