<?php
include_once('header.php');

page_header('Delete An Event From A KAG');

if ($level == 3) {
	if ($_REQUEST['submit']) {
		$event =& $ka->GetEvent($_REQUEST['event']);
		if ($event->DeleteEvent()) {
			echo 'Event deleted successfully.';
		}
		else {
			echo 'Error deleting event.';
		}
	}
	elseif ($_REQUEST['id']) {
		$kag =& $ka->GetKAG($_REQUEST['id']);
		$form = new Form($_SERVER['PHP_SELF']);
		$form->StartSelect('Event:', 'event');
		foreach ($kag->GetEvents() as $event) {
			$form->AddOption($event->GetID(), $event->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Delete Event');
		$form->EndForm();
	}
	else {
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->StartSelect('KAG:', 'id');
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
