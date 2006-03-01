<?php

function output(){
	global $ka;
	
	if ($_REQUEST['delete']){
		
		if (isset($_REQUEST['event'])){
			
			$event = new Type($_REQUEST['event']);
			
			if ($event->DeleteHandler($_REQUEST['del_flag'])){
				echo 'Event successfully '.strtolower($_REQUEST['del_flag']).'d.';
			} else {
				echo $event->Error();
			}
			
		} else {
			echo 'Error passing the required event field';
		}
		
	} elseif ($_REQUEST['submit']){
		
		if (isset($_REQUEST['event'])){
			
			$event = new Type($_REQUEST['event']);
		
			$edits = Array('name'=>addslashes($_REQUEST['name']), 'desc'=>addslashes($_REQUEST['desc']), 'abbr'=>addslashes($_REQUEST['abbr']),
								'picture'=>$_REQUEST['picture'], 'questions'=>$_REQUEST['questions'], 'answers'=>$_REQUEST['answers']);
			
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
				echo 'Event Type edited successfully.';
			}
			
		} else {
			echo 'Error passing the required event field';
		}
		
	} elseif ($_REQUEST['next']){
	
		if (isset($_REQUEST['event'])){
			$event = new Type($_REQUEST['event']);
			
			$form = new Form($_SERVER['PHP_SELF']);
			
			$form->AddSectionTitle('Event Type Delete Management');
			
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
			
			$form = new Form($_SERVER['PHP_SELF']);
		
			$form->AddSectionTitle('Edit Event Type Stats');
			
			$form->AddTextBox('Event Name', 'name', $event->GetName());
			$form->AddTextBox('Abbreviation', 'abbr', $event->GetAbbr());
			$form->AddTextArea('Description', 'desc', $event->GetEdit());
			$form->AddCheckBox('Uses Images?', 'picture', 1, $event->HasImage());
			$form->AddTextBox('Questions', 'questions', $event->GetQuestions());
			$form->AddTextBox('Answers', 'answers', $event->GetAnswers());
			
			$form->AddHidden('event', $_REQUEST['event']);
				
			$form->AddSubmitButton('submit', 'Make Modifications');
			$form->EndForm();
			
			echo "
			Notes:
			<ul>
				<li><b>Event Name</b>: The name of the event type.</li>
				<li><b>Abbreviation</b>: Used really only as convenience in non-picture events. Image events use this as reference, so do not change the Abbr once an event has started, or the image will not show up.</li>
				<li><b>Description</b>: A reminder to you (or whoever comes after you) of what to fill in the fields for each event.</li>
				<li><b>Uses Images?</b>: Check if this is an image-based hunt.</li>
				<li><b>Questions</b>: Number of questions for the event. Please set to 1 if it is an image hunt.</li>
				<li><b>Answers</b>: The number of answers for the event.</li>
			</ul>
			";
		} else {
			echo 'Event required.';
		}
		
	} else {
	
		$form = new Form($_SERVER['PHP_SELF']);
		
		$form->AddSectionTitle('Select Event Type');
		
		$form->StartSelect('Select Event', 'event');
		foreach ($ka->AllTypes() as $type){
			$form->AddOption($type->GetID(), $type->GetName());
		}
		$form->EndSelect();
		
		$form->AddSubmitButton('next', 'Continue to Edit >>');
		$form->EndForm();
		
	}
		
}

?>