<?php
include_once('header.php');

page_header('Add Event To CG');

if ($level == 3) {
	if ($_REQUEST['submit']) {
		$cg =& $ka->GetCG($_REQUEST['id']);
		if ($cg->AddEvent($_REQUEST['name'], parse_date_box('start'), parse_date_box('end'))) {
			echo 'Event added successfully.';
		}
		else {
			echo 'Error adding event.';
		}
	}
	else {
		$form = new Form($_SERVER['PHP_SELF']);
		$form->StartSelect('CG:', 'id');
		foreach (array_reverse($ka->GetCGs()) as $cg) {
			$form->AddOption($cg->GetID(), roman($cg->GetID()));
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
