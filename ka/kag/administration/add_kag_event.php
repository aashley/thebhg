<?php
include_once('header.php');

page_header('Add Event To KAG');

if ($level == 3) {
	if ($_REQUEST['submit']) {
		$kag =& $ka->GetKAG($_REQUEST['id']);
		if ($kag->AddEvent($_REQUEST['name'], parse_date_box('start'), parse_date_box('end'))) {
			echo 'Event added successfully.';
		}
		else {
			echo 'Error adding event.';
		}
	}
	else {
		$form = new Form($_SERVER['PHP_SELF']);
		$form->StartSelect('KAG:', 'id');
		foreach (array_reverse($ka->GetKAGs()) as $kag) {
			$form->AddOption($kag->GetID(), roman($kag->GetID()));
		}
		$form->EndSelect();
		$form->AddTextBox('Name:', 'name');
		$form->AddDateBox('Start Date:', 'start', false, true);
		$form->AddDateBox('End Date:', 'end', false, true);
		$form->AddSubmitButton('submit', 'Add Event');
		$form->EndForm();
	}
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>
