<?php
include_once('header.php');

page_header('Grade Event');

if ($level == 3) {
	if ($_REQUEST['submit']) {
		foreach ($_REQUEST['signup'] as $sid=>$info) {
			$signup =& $ka->GetSignup($sid);
			$signup->SetState($info['state']);
			if ($info['state'] == 1 || $info['state'] == 4) {
				$signup->SetRank($info['rank']);
			}
		}
		echo 'Event graded.';
	}
	elseif ($_REQUEST['event']) {
		$event =& $ka->GetEvent($_REQUEST['event']);
		$signups =& $event->GetSignups();
		$form = new Form($_SERVER['PHP_SELF']);
		$form->table->StartRow();
		$form->table->AddHeader('Name');
		$form->table->AddHeader('Status');
		$form->table->AddHeader('Rank');
		$form->table->EndRow();
		$sups = array();
		foreach ($signups as $signup) {
			$pleb = $signup->GetPerson();
			$sups[$pleb->GetName()] = $signup;
		}
		ksort($sups);
		foreach ($sups as $signup) {
			$pleb = $signup->GetPerson();
			$form->table->StartRow();
			$form->table->AddCell($pleb->GetName());
			$form->table->AddCell('<select name="signup[' . $signup->GetID() . '][state]" size="1"><option value="1"' . ($signup->GetState() == 1 ? ' selected="selected"' : '') . '>Use the rank given</option><option value="2"' . ($signup->GetState() == 2 ? ' selected="selected"' : '') . '>DNP</option><option value="3"' . ($signup->GetState() == 3 ? ' selected="selected"' : '') . '>No effort</option><option value="4"' . ($signup->GetState() == 4 ? ' selected="selected"' : '') . '>Use rank with penalty</option></select>');
			$form->table->AddCell('<input type="text" name="signup[' . $signup->GetID() . '][rank]" size="5"' . (($signup->GetState() == 1 || $signup->GetState() == 4) ? ' value="' . $signup->GetRank() . '"' : '') . ' />');
			$form->table->EndRow();
		}
		$form->table->StartRow();
		$form->table->AddCell('<input type="submit" name="submit" value="Save Scores" />', 3);
		$form->table->EndRow();
		$form->EndForm();

		echo <<<EON
Notes:
<ul>
	<li><b>Status</b>: This allows you to select whether the hunter had a DNP, a no effort submission, or just a regular submission. If there was a DNP or no effort, then the rank is disregarded. If &quot;Use rank with penalty&quot; is selected, then the rank will be used in the same way as a regular submission, but the points given to the hunter will be reduced by the amount set for the CG (usually 5 points).</li>
	<li><b>Rank</b>: This is the rank of the participant in the event. First place would be 1, second place is 2, and so on. Ties can be entered as the same event. For example, say you had the following results:
EON;
		$table = new Table('', true);
		$table->StartRow();
		$table->AddHeader('Name');
		$table->AddHeader('Score');
		$table->EndRow();
		$table->AddRow('Jernai', '40');
		$table->AddRow('Bob', '50');
		$table->AddRow('Koral', '30');
		$table->AddRow('Ehart', '40');
		$table->AddRow('Coursca', '10');
		$table->EndTable();
		echo '<br />The ranks would be as follows:';
		$table = new Table('', true);
		$table->StartRow();
		$table->AddHeader('Name');
		$table->AddHeader('Rank');
		$table->EndRow();
		$table->AddRow('Bob', '1');
		$table->AddRow('Jernai', '2');
		$table->AddRow('Ehart', '2');
		$table->AddRow('Koral', '4');
		$table->AddRow('Coursca', '5');
		$table->EndTable();
		echo <<<EON
	<br />This allows for easy recalculation of results in the event that there is a change in maximum or minimum score.</li>
</ul>
EON;
	}
	elseif ($_REQUEST['cg']) {
		$cg =& $ka->GetCG($_REQUEST['cg']);
		$events =& $cg->GetEvents();
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->StartSelect('Event:', 'event');
		foreach ($events as $event) {
			$form->AddOption($event->GetID(), $event->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Next >>');
		$form->EndForm();
	}
	else {
		$cgs =& $ka->GetCGs();
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->StartSelect('CG:', 'cg');
		foreach (array_reverse($ka->GetCGs()) as $cg) {
			$form->AddOption($cg->GetID(), roman($cg->GetID()));
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
