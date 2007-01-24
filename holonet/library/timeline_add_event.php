<?php
function title() {
	return 'Administration :: Add Timeline Event';
}

function auth($user) {
	$pos = $user->GetPosition();
	return ($pos->GetID() == 4 || $pos->GetID() == 1 || $pos->GetID() == 10 || $user->GetID() == 666);
}

function output() {
	global $timeline, $page;

	menu_header();

	if ($_REQUEST['submit']) {
		if ($timeline->AddEvent($_REQUEST['date_day'], $_REQUEST['date_month'], $_REQUEST['date_year'], $_REQUEST['content'], $_REQUEST['category'])) {
			echo 'Event added successfully.';
		}
		else {
			echo 'Error adding event.';
		}
	}
	else {
		$form = new Form($page);
		$form->StartSelect('Category(-ies):', 'category[]', false, 10, true);
		timeline_form_categories($timeline->GetCategories(), 0, $form);
		$form->EndSelect();
		$form->AddDateBox('Date:', 'date');
		$form->AddTextArea('Content:', 'content', '', 10, 60);
		$form->AddSubmitButton('submit', 'Add Event');
		$form->EndForm();
	}

	timeline_admin_footer();
}

?>
