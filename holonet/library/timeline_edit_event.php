<?php
function title() {
	return 'Administration :: Edit Timeline Event';
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
		if ($event->SetCategories($_REQUEST['category']) &&
		    $event->SetTime($_REQUEST['date_day'], $_REQUEST['date_month'], $_REQUEST['date_year']) &&
		    $event->SetContent($_REQUEST['content'])) {
			echo 'Event saved successfully.';
		}
		else {
			echo 'Error saving event.';
		}
	}
	elseif ($_REQUEST['id']) {
		$event = $timeline->GetEvent($_REQUEST['id']);
		$elcid = array();
		foreach ($event->GetCategories() as $ecat) {
			$elcid[] = $ecat->GetID();
		}
		
		$form = new Form($page);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->StartSelect('Category(-ies):', 'category[]', $elcid, 10, true);
		foreach ($timeline->GetCategories() as $cat) {
			$form->AddOption($cat->GetID(), $cat->GetName());
		}
		$form->EndSelect();
		$form->AddDateBox('Date:', 'date', $event->GetTimestamp());
		$form->AddTextArea('Content:', 'content', $event->GetContent(), 10, 60);
		$form->AddSubmitButton('submit', 'Save Event');
		$form->EndForm();
	}
	else {
		$form = new Form($page, 'get');
		$form->StartSelect('Event:', 'id', false, 10);
		foreach ($timeline->GetAllEvents() as $event) {
			if ($_REQUEST['show'] == 'uncategorised' && $event->IsCategorised()) {
				continue;
			}
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
		$form->AddSubmitButton('', 'Edit Event');
		$form->EndForm();
	}

	timeline_admin_footer();
}
?>
