<?php
$title = 'Administration :: Add Event';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 1)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

if ($_REQUEST['submit']) {
	$title = $_REQUEST['title'];
	if ($_REQUEST['use_end'] == 'on') {
		$title .= ' (Start)';
	}
	if ($calendar->AddEvent($_REQUEST['section'], $my_user->GetID(), parse_date_box('time'), $title, $_REQUEST['content'])) {
		if ($_REQUEST['use_end'] == 'on') {
			$calendar->AddEvent($_REQUEST['section'], $my_user->GetID(), parse_date_box('end_time'), $_REQUEST['title'] . ' (End)', $_REQUEST['content']);
		}
		echo 'Event added successfully.';
	}
	else {
		echo 'Error adding event.';
	}
}
else {
	$form = new Form($_SERVER['PHP_SELF']);
	$form->AddTextBox('Title:', 'title');
	$form->AddTextArea('Event Text:', 'content', '', 10, 60);
	$form->StartSelect('Section:', 'section');
	$sections = $news->GetAvailableSections();
	foreach ($sections as $section) {
		$form->AddOption($section['id'], $section['name']);
	}
	$form->EndSelect();
	$form->AddDateBox('Event Time:', 'time', time(), true);
	$form->table->StartRow();
	$form->table->AddCell('To just add the event above, you can ignore the two items below and add the event now. Otherwise, to add an extra calendar item to mark the end of your event, tick the box below and fill in the end time.', 2);
	$form->table->EndRow();
	$form->AddCheckBox('Use End Time:', 'use_end', 'on');
	$form->AddDateBox('End Time:', 'end_time', time(), true);
	$form->AddSubmitButton('submit', 'Add Event');
	$form->EndForm();
}

include('../../footer.php');
?>
