<?php
$title = 'Administration :: Delete Event';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 1)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

if ($_REQUEST['submit']) {
	$event = $calendar->GetEvent($_REQUEST['id']);
	$poster = $event->GetPoster();
	if (lookup_auth_level($my_user) == 2 || $poster->GetID() == $my_user->GetID()) {
		if ($event->DeleteEvent()) {
			echo 'Event deleted successfully.';
		}
		else {
			echo 'Error deleting event.';
		}
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
		$form = new Form($_SERVER['PHP_SELF']);
		$form->StartSelect('Event:', 'id');
		foreach ($events as $event) {
			$poster = $event->GetPoster();
			if (lookup_auth_level($my_user) == 2 || $poster->GetID() == $my_user->GetID()) {
				$form->AddOption($event->GetID(), '(' . $sec_names[$event->GetSection()] . ') ' . $event->GetTitle());
			}
		}
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Delete Event');
		$form->EndForm();
	}
	else {
		echo 'No events found.';
	}
}

include('../../footer.php');
?>
