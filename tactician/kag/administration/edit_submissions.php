<?php
include_once('header.php');

page_header('Grade Event');

if ($level == 3) {
	if ($_REQUEST['submit']) {		
		if ($_REQUEST['event']){
			$errors = 0;
			foreach ($_REQUEST['answers'] as $sid=>$id){
				$signup = new KagSignup($sid, $db);
				if (!$signup->Edit(($_REQUEST['void'][$sid] ? 0 : parse_date_box('submitted_'.$sid)), $ka->ConditionContent($id))){
					$errors++;
				}
			}
			if ($errors){
				echo 'Error editing';
			} else {
				echo 'Edited events';
			}
		}
	}
	elseif ($_REQUEST['event']) {
		$event =& $ka->GetEvent($_REQUEST['event']);
		$signups =& $event->GetSignups();
		$kag = $event->GetKAG();
		
		if ($event->IsTimed()){
			$type = $event->GetTypes();
				
			$form = new Form($PHP_SELF);
			
			$content = $event->GetContent();
			$answers = $content['answers'];
			$questions = $content['questions'];
			$total_answers = count($answers);
			$total_questions = count($questions);
			
			$form->AddSectionTitle($type->GetName());
			
			if ($type->HasImage()){
				$form->table->StartRow();
				$form->table->AddCell('<center><center><img src="/kag/event_images/'.$type->GetAbbr(). '-'. $kag->GetID() . '-' 
								. $event->GetID() . '.jpg">', 2);
				$form->table->EndRow();
				for ($i = 1; $i <= $total_answers; $i++) {
					$form->table->AddRow('Hunt Answers '.$i.'/'.$total_answers, stripslashes($answers[$i]));
				}
			} else {
				if ($total_questions == $total_answers){
					for ($i = 1; $i <= $total_answers; $i++) {
						$form->table->AddRow('Hunt Question '.$i.'/'.$total_questions, stripslashes($questions[$i]));
				        $form->table->AddRow('Hunt Answers '.$i.'/'.$total_answers, stripslashes($answers[$i]));
			        }
		        } else {
			        for ($i = 1; $i <= $total_questions; $i++) {
						$form->table->AddRow('Hunt Question '.$i.'/'.$total_questions, stripslashes($questions[$i]));
			        }
			        for ($i = 1; $i <= $total_answers; $i++) {
				        $form->table->AddRow('Hunt Answers '.$i.'/'.$total_answers, stripslashes($answers[$i]));
			        }
		        }
	        }	
	        
	        $form->EndForm();
	        
	        hr();
	        
	        $form = new Form($PHP_SELF);
			
			foreach ($signups as $sub){
				if ($sub->GetSubmitted()){					
					$hunter = $sub->GetPerson();
					$kabal = $sub->GetKabal();
					$sub_answers = $sub->GetContent();
					$sid = $sub->GetID();
					
					$total_answers = count($sub_answers);
					
					$form->AddSectionTitle($hunter->GetName().' for '.$kabal->GetName());
					$form->table->AddRow('IP Address', $sub->GetIP());
					
					for ($i = 1; $i <= $total_answers; $i++) {
						$form->table->AddRow('Correct Answers '.$i.'/'.$total_answers, stripslashes($answers[$i]));
				        $form->AddTextBox('Hunt Answers '.$i.'/'.$total_answers, 'answers['.$sid.']['.$i.']', stripslashes($sub_answers[$i]), 60);
			        }
			        
			        $form->AddDateBox('Submitted:', 'submitted_'.$sid, $sub->GetSubmitted(), true);
			        $form->AddCheckBox('Erase Submission', 'void['.$sid.']', 1);
		        }
			}
			
			
			
			$form->AddHidden('event', $_REQUEST['event']);
			
	        $form->AddSubmitButton('submit', 'Submit Grades');
	        
			$form->EndForm();
		}
	}
	elseif ($_REQUEST['kag']) {
		$kag =& $ka->GetKAG($_REQUEST['kag']);
		$events =& $kag->GetEvents();
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->StartSelect('Event:', 'event');
		foreach ($events as $event) {
			if ($event->IsTimed()){
				$type = $event->GetTypes();
				$name = $type->GetName();
				$form->AddOption($event->GetID(), $name);
			}			
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Next >>');
		$form->EndForm();
	}
	else {
		$kags =& $ka->GetKAGs();
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->StartSelect('KAG:', 'kag');
		foreach (array_reverse($ka->GetKAGs()) as $kag) {
			$form->AddOption($kag->GetID(), roman($kag->GetID()));
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Next >>');
		$form->EndForm();
	}
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>
