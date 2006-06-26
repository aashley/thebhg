<?php
include_once('header.php');

page_header('Add Event To CG');

if ($level == 3) {
	if ($_REQUEST['submit']) {
		
		if ($_REQUEST['event']){
			$type = new CGType($_REQUEST['event'], $db);
			
			$content['questions'] = $_REQUEST['question'];
			$content['answers'] = $_REQUEST['answer'];
				
			$type_id = $type->GetID();
		} else {
			$type_id = 0;
			$content = array();
		}
		
    	$CG =& $ka->GetCG($_REQUEST['id']);
    		
    	$event = $CG->AddEvent($_REQUEST['name'], parse_date_box('start'), parse_date_box('end'), false, (isset($_REQUEST['team']) ? 1 : 0), $ka->ConditionContent($content), $type_id);

		if ($event) {
			if (is_object($type)){
				if ($type->HasImage()){
					$uploadfile = $uploaddir . $type->GetAbbr(). '-'. $_REQUEST['id'] . '-' . $event->GetID() . '.jpg';
	        		if (!(move_uploaded_file($_FILES['uploadpic']['tmp_name'][1], $uploadfile)) && !(chmod($uploadfile, 0777))){
		        		echo 'Uploaded file is invalid. Follow all rules and try again. If you\'re sure you did, please report this to a Coder.<br />';
	        		}
	    		}
    		}
			echo 'Event added successfully.';
		}
		else {
			echo 'Error adding event.';
		}
	} 
	elseif ($_REQUEST['next']){
		$form = new Form($_SERVER['PHP_SELF'], 'post', '', 'multipart/form-data');
		
		$form->AddHidden('id', $_REQUEST['id']);
		
		$submit = false;
		
		if ($_REQUEST['timed']){
			if ($_REQUEST['event']){
				$form->AddHidden('event', $_REQUEST['event']);
				$submit = true;
				$type = new CGType($_REQUEST['event'], $db);
				$form->table->AddRow('CG:', roman($_REQUEST['id']));
				$form->table->AddRow('Event Type', $type->GetName().' ('.$type->GetAbbr().')');
				$form->table->AddRow('Event Description', $type->GetDesc());
				
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
			} else {
				$form->AddHidden('timed', 1);
				$form->StartSelect('Event Type', 'event');
				foreach ($ka->GetTypes() as $type){
					$form->AddOption($type->GetID(), $type->GetName().' ('.$type->GetAbbr().')');
				}
				$form->EndSelect();
				$form->AddSubmitButton('next', 'Enter Event Details');
			}
		} else {
			$form->table->AddRow('CG:', roman($_REQUEST['id']));
			$form->AddTextBox('Name:', 'name');
			$submit = true;
		}
		
		if ($submit){
			$form->AddCheckBox('Team Event?', "team", 1);
			$form->AddDateBox('Start Date:', 'start', false, true);
			$form->AddDateBox('End Date:', 'end', false, true);
			$form->AddSubmitButton('submit', 'Add Event');
		}
			$form->EndForm();
	}
	else {
		$form = new Form($_SERVER['PHP_SELF']);
		$form->StartSelect('CG:', 'id');
		foreach (array_reverse($ka->GetCGs()) as $CG) {
			$form->AddOption($CG->GetID(), roman($CG->GetID()));
		}
		$form->EndSelect();
		$form->AddCheckBox('Timed Event?', 'timed', 1);
		$form->AddSubmitButton('next', 'Make Event >>');
		$form->EndForm();
	}
	hr();
	
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>
