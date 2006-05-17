<?php
include_once('header.php');

page_header('Add New KAG');

if ($level == 3) {
	if ($_REQUEST['add_events']) {
		$kag =& $ka->GetKAG($_REQUEST['kag']);
		foreach ($_REQUEST['events'] as $i=>$name) {
			$start = parse_date_box("events{$i}_start");
			$end = parse_date_box("events{$i}_end");
			if (!$kag->AddEvent($name, $start, $end)) {
				echo 'Error adding event ' . $i . '.<br />';
			}
		}
		echo 'KAG and events added successfully.';
	}
	elseif ($_REQUEST['submit']) {
		$start = parse_date_box('start');
		$end = parse_date_box('end');
		if ($kag =& $ka->AddKAG($_REQUEST['id'], parse_date_box('signup_start'), parse_date_box('signup_end'), $start, $end, $_REQUEST['maximum'], $_REQUEST['minimum'], $_REQUEST['dnp'], $_REQUEST['noeffort'], $_REQUEST['penalty'])) {
			$form = new Form($_SERVER['PHP_SELF']);
			$form->AddHidden('kag', $kag->GetID());
			for ($i = 0; $i < $_REQUEST['events']; $i++) {
				$form->table->StartRow();
				$form->table->AddHeader('Event ' . ($i + 1), 2);
				$form->table->EndRow();

				$form->AddTextBox('Name:', "events[$i]");
				$form->AddDateBox('Start Date:', "events{$i}_start", $start, true);
				$form->AddDateBox('End Date:', "events{$i}_end", $end, true);
			}
			$form->AddSubmitButton('add_events', 'Add KAG and Events');
			$form->EndForm();
		}
		else {
			echo 'Error adding KAG.<br /><br />';
			echo mysql_error($db);
		}
	}
	else {
		$form = new Form($_SERVER['PHP_SELF']);
		$form->AddTextBox('KAG Number:', 'id', false, 5);
		$form->AddTextBox('Maximum Points:', 'maximum', '50', 5);
		$form->AddTextBox('Minimum Points:', 'minimum', '0', 5);
		$form->AddTextBox('DNP Points:', 'dnp', '-5', 5);
		$form->AddTextBox('No Effort Points:', 'noeffort', '0', 5);
		$form->AddTextBox('Penalty Points:', 'penalty', '5', 5);
		$form->AddTextBox('Number of <b>NON-TIMED</b> Events:', 'events', false, 5);
		$form->AddDateBox('Start of Signup Period:', 'signup_start', 0, true);
		$form->AddDateBox('End of Signup Period:', 'signup_end', 0, true);
		$form->AddDateBox('Start of KAG:', 'start', 0, true);
		$form->AddDateBox('End of KAG:', 'end', 0, true);
		$form->AddSubmitButton('submit', 'Next >>');
		$form->EndForm();
hr();
		echo <<<EON
<div><h2>Critical</h2>As of KAG 24, all <b>TIMED</b> events require a "release window". This allows for the events to be released at a static time (You set when it will actually be released), but the system will display a window only of when it will be released. <b>PLEASE NOTE: <i>THE SYSTEM WILL NOT CHECK TO ENSURE YOUR RELEASE TIME IS ACTUALLY IN YOUR WINDOW</i></b>. You get paid a salary, so if you muck it all up, it's on your head, not the code. I just want that known.</div>
Notes:
<ul>
	<li><b>KAG Number</b>: At present, this must be a number and not Roman numerals.</li>
	<li><b>Maximum Points</b>: The number of points the first placed hunter will get for his/her kabal. Typically 30.</li>
	<li><b>Minimum Points</b>: The minimum number of points hunters will get for completing an event. As of KAG 17, this is 0.</li>
	<li><b>DNP Points</b>: The point value of a DNP. This has been -15 and -10 in the past, but is presently -5.</li>
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
