<?php
include_once('header.php');

page_header('Edit KAG Events');

if ($level == 3) {
	if ($_REQUEST['submit']) {
		foreach ($_REQUEST['events'] as $i=>$name) {
			$event =& $ka->GetEvent($i);
			if (!$event->SetName($name) || !$event->SetTime(parse_date_box("events{$i}_start"), parse_date_box("events{$i}_end"))) {
				echo 'Error saving event ID ' . $i . '.<br />';
			}
		}
		echo 'Events saved.';
	}
	elseif ($_REQUEST['id']) {
		$kag =& $ka->GetKAG($_REQUEST['id']);
		$form = new Form($_SERVER['PHP_SELF']);
		$row = 0;
		foreach ($kag->GetEvents() as $event) {
			$form->table->StartRow();
			$form->table->AddHeader('Event ' . (++$row), 2);
			$form->table->EndRow();

			$form->AddTextBox('Name:', 'events[' . $event->GetID() . ']', $event->GetName());
			$form->AddDateBox('Start Date:', 'events' . $event->GetID() . '_start', $event->GetStart(), true);
			$form->AddDateBox('End Date:', 'events' . $event->GetID() . '_end', $event->GetEnd(), true);
		}
		$form->AddSubmitButton('submit', 'Save Events');
		$form->EndForm();
	}
	else {
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->StartSelect('KAG:', 'id');
		foreach (array_reverse($ka->GetKAGs()) as $kag) {
			$form->AddOption($kag->GetID(), roman($kag->GetID()));
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit Events');
		$form->EndForm();
	}
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>
