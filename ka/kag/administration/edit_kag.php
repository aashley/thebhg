<?php
include_once('header.php');

page_header('Edit KAG');

if ($level == 3) {
	if ($_REQUEST['submit']) {
		$kag = $ka->GetKAG($_REQUEST['id']);

		if ($kag->SetMaximum($_REQUEST['maximum']) &&
		    $kag->SetMinimum($_REQUEST['minimum']) &&
		    $kag->SetDNP($_REQUEST['dnp']) &&
		    $kag->SetNoEffort($_REQUEST['noeffort']) &&
		    $kag->SetPenalty($_REQUEST['penalty']) &&
		    $kag->SetSignup(parse_date_box('signup_start'), parse_date_box('signup_end')) &&
		    $kag->SetTime(parse_date_box('start'), parse_date_box('end'))) {
			echo 'KAG saved.';
		}
		else {
			echo 'Error saving KAG.';
		}
	}
	elseif ($_REQUEST['id']) {
		$kag = $ka->GetKAG($_REQUEST['id']);

		$form = new Form($_SERVER['PHP_SELF']);
		$form->AddHidden('id', $kag->GetID());
		$form->AddTextBox('Maximum Points:', 'maximum', $kag->GetMaximum(), 5);
		$form->AddTextBox('Minimum Points:', 'minimum', $kag->GetMinimum(), 5);
		$form->AddTextBox('DNP Points:', 'dnp', $kag->GetDNP(), 5);
		$form->AddTextBox('No Effort Points:', 'noeffort', $kag->GetNoEffort(), 5);
		$form->AddTextBox('Penalty Points:', 'penalty', $kag->GetPenalty(), 5);
		$form->AddDateBox('Start of Signup Period:', 'signup_start', $kag->GetSignupStart(), true);
		$form->AddDateBox('End of Signup Period:', 'signup_end', $kag->GetSignupEnd(), true);
		$form->AddDateBox('Start of KAG:', 'start', $kag->GetStart(), true);
		$form->AddDateBox('End of KAG:', 'end', $kag->GetEnd(), true);
		$form->AddSubmitButton('submit', 'Save KAG');
		$form->EndForm();

		echo <<<EON
Notes:
<ul>
	<li><b>Maximum Points</b>: The number of points the first placed hunter will get for his/her kabal. Typically 30.</li>
	<li><b>Minimum Points</b>: The minimum number of points hunters will get for completing an event. As of KAG 17, this is 0.</li>
	<li><b>DNP Points</b>: The point value of a DNP. This has been -15 and -10 in the past, but is presently -5.</li>
	<li><b>No Effort Points</b>: The number of points a hunter will receive for not putting any effort into a submission. Currently 0.</li>
	<li><b>Penalty Points</b>: The number of points deducted from a hunter's score when he/she fails to follow the rules for an event.</li>
</ul>
EON;
	}
	else {
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->StartSelect('KAG:', 'id');
		foreach (array_reverse($ka->GetKAGs()) as $kag) {
			$form->AddOption($kag->GetID(), roman($kag->GetID()));
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit KAG');
		$form->EndForm();
	}
}
else {
	echo 'You are not authorised to view this page.';
}

page_footer();
?>
