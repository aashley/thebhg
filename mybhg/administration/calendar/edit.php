<?php
$title = 'Administration :: Edit Event';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 1)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

if ($_REQUEST['submit']) {
	$event = $calendar->GetEvent($_REQUEST['id']);
	$poster = $event->GetPoster();
	if (lookup_auth_level($my_user) == 2 || $poster->GetID() == $my_user->GetID()) {
		if ($event->SetTitle($_REQUEST['title']) &&
		    $event->SetContent($_REQUEST['body']) &&
		    $event->SetSection($_REQUEST['section']) &&
		    $event->SetTime(parse_date_box('time'))) {
			echo 'Event saved successfully.';
		}
		else {
			echo 'Error saving event.';
		}
	}
	else {
		echo 'You do not have permission to edit this event.';
	}
}
elseif ($_REQUEST['id']) {
	$event = $calendar->GetEvent($_REQUEST['id']);
	$poster = $event->GetPoster();
	if (lookup_auth_level($my_user) == 2 || $poster->GetID() == $my_user->GetID()) {
		$form = new Form($_SERVER['PHP_SELF']);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextBox('Title:', 'title', $event->GetTitle());
		$form->AddTextArea('Event Text:', 'body', $event->GetContent(), 10, 60);
		$form->StartSelect('Section:', 'section', $event->GetSection());
		$sections = $news->GetAvailableSections();
		foreach ($sections as $section) {
			$form->AddOption($section['id'], $section['name']);
		}
		$form->EndSelect();
		$form->AddDateBox('Event Time:', 'time', $event->GetTime(), true);
		$form->AddSubmitButton('submit', 'Save Event');
		$form->EndForm();
	}
	else {
		echo 'You do not have permission to edit this event.';
	}
}
else {
	$sections = $news->GetAvailableSections();
	$sid = array();
	foreach ($sections as $sec) {
		$sec_names[$sec['id']] = $sec['name'];
	}
	
	if (isset($_REQUEST['show'])) {
		$events = $calendar->GetAllEvents();
	}
	else {
		echo 'Note: In order to keep the size of this list down, only future events are shown. If you need to edit a past event, please <a href="' . $PHP_SELF . '?show=all">click here to show the full list</a>. Be aware that said list may take some time to load.';
		hr();
		$events = $calendar->GetEventsByTime(0);
	}

	if (count($events)) {
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->StartSelect('Event:', 'id');
		foreach ($events as $event) {
			$poster = $event->GetPoster();
			if (lookup_auth_level($my_user) == 2 || $poster->GetID() == $my_user->GetID()) {
				$form->AddOption($event->GetID(), '(' . $sec_names[$event->GetSection()] . ') ' . $event->GetTitle());
			}
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit Event');
		$form->EndForm();
	}
	else {
		echo 'No events found.';
	}
}

include('../../footer.php');
?>
