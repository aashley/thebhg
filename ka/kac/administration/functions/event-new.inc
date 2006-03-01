<?php

function output(){
	global $ka;
	
	if ($_REQUEST['submit']){
		if ($ka->NewEventType($_REQUEST['name'], $_REQUEST['desc'], $_REQUEST['abbr'], $_REQUEST['picture'], $_REQUEST['questions'], $_REQUEST['answers'])){
			echo 'New Event Type added successfully.';
		} else {
			echo $ka->Error();
		}
		hr();
	}
	
	$form = new Form($_SERVER['PHP_SELF']);
	
	$form->AddSectionTitle('Enter Event Type Stats');
	
	$form->AddTextBox('Event Name', 'name');
	$form->AddTextBox('Abbreviation', 'abbr');
	$form->AddTextArea('Description', 'desc');
	$form->AddCheckBox('Uses Images?', 'picture', 1);
	$form->AddTextBox('Questions', 'questions');
	$form->AddTextBox('Answers', 'answers');
		
	$form->AddSubmitButton('submit', 'Add New Event Type');
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
	
}

?>