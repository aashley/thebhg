<?php
function title() {
	return 'New Medals';
}

function output() {
	global $mb, $page;

	if (empty($_REQUEST['days'])) {
		$days = 7;
	}
	else {
		$days = $_REQUEST['days'];
	}

	mb_header();

	$table = new Table('', true);
	$table->StartRow();
	$table->AddHeader('Date');
	$table->AddHeader('Recipient');
	$table->AddHeader('Awarder');
	$table->AddHeader('Medal');
	$table->AddHeader('Reason');
	$table->EndRow();

	$medals = $mb->GetRecentMedals($days);
	if ($medals) {
		foreach ($medals as $am) {
			$medal = $am->GetMedal();
			$group = $medal->GetGroup();
			$awarder = $am->GetAwarder();
			$recip = $am->GetRecipient();
			if ($recip->GetName()) {
				$table->AddRow(date('j F Y', $am->GetDate()), '<a href="' . internal_link('hunter', array('id'=>$recip->GetID()), 'roster') . '">' . $recip->GetName() . '</a>', '<a href="' . internal_link('hunter', array('id'=>$awarder->GetID()), 'roster') . '">' . $awarder->GetName() . '</a>', '<a href="' . internal_link('browse', array('group'=>$group->GetID()), 'mb') . '">' . html_escape($medal->GetName()) . '</a>', ($am->GetReason() ? ucfirst($am->GetReason()) . (substr($am->GetReason(), -1) == '.' ? '' : '.') : '&nbsp;'));
			}
		}
	}
	else {
		$table->StartRow();
		$table->AddCell('No medals have been awarded in the last ' . $days . ' day(s).', 5);
		$table->EndRow();
	}

	$table->EndTable();

	echo '<br>';
	$form = new Form($page, 'get');
	echo 'Days to show: ';
	$form->AddTextBox('Days to Show:', 'days', $days, 2);
	echo ' ';
	$form->AddSubmitButton('', 'Go!');
	$form->EndForm();
	
	mb_footer();
}
?>
