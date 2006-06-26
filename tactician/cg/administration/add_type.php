<?php
include_once('header.php');

page_header('Add New Event Type');

if ($level == 3) {
	if ($_REQUEST['submit']){
		if ($ka->NewEventType($_REQUEST['name'], $_REQUEST['desc'], $_REQUEST['abbr'], $_REQUEST['picture'], $_REQUEST['questions'], $_REQUEST['answers'])){
			echo 'New Event Type added successfully.';
		}
		hr();
	}
	
	$form = new Form($PHP_SELF);
	
	$form->AddSectionTitle('Enter Event Type Stats');
	
	$form->AddTextBox('Event Name', 'name');
	$form->AddTextBox('Abbreviation', 'abbr');
	$form->AddTextArea('Description', 'desc');
	$form->AddCheckBox('Uses Images?', 'picture', 1);
	$form->AddTextBox('Questions', 'questions');
	$form->AddTextBox('Answers', 'answers');
		
	$form->AddSubmitButton('submit', 'Add New Event Type');
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
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>
