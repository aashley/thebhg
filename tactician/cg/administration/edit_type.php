<?php
include_once('header.php');

page_header('Edit Event Type');

if ($level == 3) {
	
	if ($_REQUEST['delete']){
		
		if (isset($_REQUEST['event'])){
			
			$event = new CGType($_REQUEST['event'], $db);
			
			if ($event->DeleteHandler($_REQUEST['del_flag'])){
				echo 'Event successfully '.strtolower($_REQUEST['del_flag']).'d.';
			} else {
				echo "Error from Delete Handler";
			}
			
		} else {
			echo 'Error passing the required event field';
		}
		
	} elseif ($_REQUEST['submit']){
		
		if (isset($_REQUEST['event'])){
			
			$event = new CGType($_REQUEST['event'], $db);
		
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
			} else {
				echo 'Event Type edited successfully.';
			}
			
		} else {
			echo 'Error passing the required event field';
		}
		
	} elseif ($_REQUEST['next']){
	
		if (isset($_REQUEST['event'])){
			$event = new CGType($_REQUEST['event'], $db);
			
			$form = new Form($PHP_SELF);
			
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
			
			$form = new Form($PHP_SELF);
		
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
			
			echo <<<EON
Notes:
<ul>
	<li><b>Event Name</b>: The name of the event type.</li>
	<li><b>Abbreviation</b>: The abbreviation for the hunt, used in image reference.</li>
	<li><b>Description</b>: A basic description of the event.</li>
	<li><b>Uses Images?</b>: Essentially, this is to establish if the hunt uses images. All uploads will be referenced via this. Click if uses images.</li>
	<li><b>Questions</b>: The number of questions the hunt asks. Use 1 if the hunt is an image hunt.</li>
	<li><b>Answers</b>: The number of answers to the event.</li>
</ul>
EON;
			
		} else {
			echo 'Event required.';
		}
		
	} else {
	
		$form = new Form($PHP_SELF);
		
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
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>
