<?php
include_once('header.php');

page_header('Add New CG');

if ($level == 3) {
	if ($_REQUEST['add_events']) {
		$cg =& $ka->GetCG($_REQUEST['cg']);
		foreach ($_REQUEST['events'] as $i=>$name) {
			$start = parse_date_box("events{$i}_start");
			$end = parse_date_box("events{$i}_end");
			if (!$cg->AddEvent($name, $start, $end, false, (isset($_REQUEST['teams'][$i]) ? 1 : 0))) {
				echo 'Error adding event ' . $i . '.<br />';
			}
		}
		echo 'CG and events added successfully.';
	}
	elseif ($_REQUEST['submit']) {
		$start = parse_date_box('start');
		$end = parse_date_box('end');
		if ($cg =& $ka->AddCG($_REQUEST['id'], parse_date_box('signup_start'), parse_date_box('signup_end'), $start, $end, $_REQUEST['maximum'], $_REQUEST['minimum'], $_REQUEST['dnp'], $_REQUEST['noeffort'], $_REQUEST['penalty'])) {
			$form = new Form($_SERVER['PHP_SELF']);
			$form->AddHidden('cg', $cg->GetID());
			for ($i = 0; $i < $_REQUEST['events']; $i++) {
				$form->table->StartRow();
				$form->table->AddHeader('Event ' . ($i + 1), 2);
				$form->table->EndRow();

				$form->AddTextBox('Name:', "events[$i]");
				$form->AddCheckBox('Team Event?', "teams[$i]", 1, $event->IsTeam());
				$form->AddDateBox('Start Date:', "events{$i}_start", $start, true);
				$form->AddDateBox('End Date:', "events{$i}_end", $end, true);
			}
			$form->AddSubmitButton('add_events', 'Add CG and Events');
			$form->EndForm();
		}
		else {
			echo 'Error adding CG.<br /><br />';
			echo mysql_error($db);
		}
	}
	else {
		$form = new Form($_SERVER['PHP_SELF']);
		$form->AddTextBox('CG Number:', 'id', false, 5);
		$form->AddTextBox('Maximum Points:', 'maximum', '30', 5);
		$form->AddTextBox('Minimum Points:', 'minimum', '0', 5);
		$form->AddTextBox('DNP Points:', 'dnp', '0', 5);
		$form->AddTextBox('No Effort Points:', 'noeffort', '0', 5);
		$form->AddTextBox('Penalty Points:', 'penalty', '5', 5);
		$form->AddTextBox('Number of <b>NON-TIMED</b> Events:', 'events', false, 5);
		$form->AddDateBox('Start of Signup Period:', 'signup_start', 0, true);
		$form->AddDateBox('End of Signup Period:', 'signup_end', 0, true);
		$form->AddDateBox('Start of CG:', 'start', 0, true);
		$form->AddDateBox('End of CG:', 'end', 0, true);
		$form->AddSubmitButton('submit', 'Next >>');
		$form->EndForm();

		echo <<<EON
Notes:
<ul>
	<li><b>CG Number</b>: At present, this must be a number and not Roman numerals.</li>
	<li><b>Maximum Points</b>: The number of points the first placed hunter will get for his/her cadre. Typically 30.</li>
	<li><b>Minimum Points</b>: The minimum number of points hunters will get for completing an event. Presently 0.</li>
	<li><b>DNP Points</b>: The point value of a DNP. This is generally 0.</li>
	<li><b>No Effort Points</b>: The number of points a hunter will receive for not putting any effort into a submission. Currently 0.</li>
	<li><b>Penalty Points</b>: The number of points deducted from a hunter's score when he/she fails to follow the rules for an event.</li>
</ul>
EON;
	}
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>
