<?php
include_once('header.php');

page_header('Edit CG');

if ($level == 3) {
	if ($_REQUEST['submit']) {
		$cg = $ka->GetCG($_REQUEST['id']);

		if ($cg->SetMaximum($_REQUEST['maximum']) &&
		    $cg->SetMinimum($_REQUEST['minimum']) &&
		    $cg->SetDNP($_REQUEST['dnp']) &&
		    $cg->SetNoEffort($_REQUEST['noeffort']) &&
		    $cg->SetPenalty($_REQUEST['penalty']) &&
		    $cg->SetSignup(parse_date_box('signup_start'), parse_date_box('signup_end')) &&
		    $cg->SetTime(parse_date_box('start'), parse_date_box('end'))) {
			echo 'CG saved.';
		}
		else {
			echo 'Error saving CG.';
		}
	}
	elseif ($_REQUEST['id']) {
		$cg = $ka->GetCG($_REQUEST['id']);

		$form = new Form($_SERVER['PHP_SELF']);
		$form->AddHidden('id', $cg->GetID());
		$form->AddTextBox('Maximum Points:', 'maximum', $cg->GetMaximum(), 5);
		$form->AddTextBox('Minimum Points:', 'minimum', $cg->GetMinimum(), 5);
		$form->AddTextBox('DNP Points:', 'dnp', $cg->GetDNP(), 5);
		$form->AddTextBox('No Effort Points:', 'noeffort', $cg->GetNoEffort(), 5);
		$form->AddTextBox('Penalty Points:', 'penalty', $cg->GetPenalty(), 5);
		$form->AddDateBox('Start of Signup Period:', 'signup_start', $cg->GetSignupStart(), true);
		$form->AddDateBox('End of Signup Period:', 'signup_end', $cg->GetSignupEnd(), true);
		$form->AddDateBox('Start of CG:', 'start', $cg->GetStart(), true);
		$form->AddDateBox('End of CG:', 'end', $cg->GetEnd(), true);
		$form->AddSubmitButton('submit', 'Save CG');
		$form->EndForm();

		echo <<<EON
Notes:
<ul>
	<li><b>Maximum Points</b>: The number of points the first placed hunter will get for his/her cadre. Typically 30.</li>
	<li><b>Minimum Points</b>: The minimum number of points hunters will get for completing an event. As of CG 17, this is 0.</li>
	<li><b>DNP Points</b>: The point value of a DNP. This has been -15 and -10 in the past, but is presently -5.</li>
	<li><b>No Effort Points</b>: The number of points a hunter will receive for not putting any effort into a submission. Currently 0.</li>
	<li><b>Penalty Points</b>: The number of points deducted from a hunter's score when he/she fails to follow the rules for an event.</li>
</ul>
EON;
	}
	else {
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->StartSelect('CG:', 'id');
		foreach (array_reverse($ka->GetCGs()) as $cg) {
			$form->AddOption($cg->GetID(), roman($cg->GetID()));
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit CG');
		$form->EndForm();
	}
}
else {
	echo 'You are not authorised to view this page.';
}

page_footer();
?>
