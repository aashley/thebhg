<?php
function title() {
	return 'Administration :: Delete Timeline Event';
}

function auth($user) {
	$pos = $user->GetPosition();
	return ($pos->GetID() == 4 || $user->GetID() == 666);
}

function output() {
	global $timeline, $page;

	menu_header();

	if ($_REQUEST['submit']) {
		$event = $timeline->GetEvent($_REQUEST['id']);
		if ($event->DeleteEvent()) {
			echo 'Event deleted successfully.';
		}
		else {
			echo 'Error deleting event.';
		}
	}
	else {
		$form = new Form($page);
		$form->StartSelect('Event:', 'id', false, 10);
		foreach ($timeline->GetAllEvents() as $event) {
			$label = '[' . $event->GetDay() . '/' . $event->GetMonth() . '/' . $event->GetYear() . '] ';
			if (strlen($event->GetContent()) < 40) {
				$label .= $event->GetContent();
			}
			else {
				$label .= substr($event->GetContent(), 0, 40) . '...';
			}
			$form->AddOption($event->GetID(), $label);
		}
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Delete Event');
		$form->EndForm();
	}

	timeline_admin_footer();
}
?>
