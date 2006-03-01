<?php
function make_rfc2822_address($name, $address) {
	$name = preg_replace('/[^A-Za-z0-9!#$%&\'*+\\-\\/=?^_`{}|~ ]/', '', $name);
	$address = preg_replace('/[^A-Za-z0-9!#$%&\'*+\\-\\/=?^_`{}|~.@]/', '', $address);
	return $name . ' <' . $address . '>';
}

include_once('header.php');

page_header('E-mail Hunters');

if ($level == 3) {
	if ($_REQUEST['message']) {
		$addresses = array();
		if ($_REQUEST['by'] == 'event') {
			$event =& $ka->GetEvent($_REQUEST['event']);
			$signups =& $event->GetSignups();
		}
		else {
			$kag =& $ka->GetKAG($_REQUEST['kag']);
			$signups =& $kag->GetSignups();
		}
		
		foreach ($signups as $signup) {
			$person =& $signup->GetPerson();
			if (preg_match('/\\S+@\\S+\\.\\S+/', $person->GetEmail())) {
				$addresses[$person->GetID()] = make_rfc2822_address($person->GetName(), $person->GetEmail());
			}
		}

		if ($_REQUEST['cc']) {
			$addresses[$judicator->GetID()] = make_rfc2822_address($judicator->GetName(), $judicator->GetEmail());
		}
		
		for ($i = 0; $i < count($addresses); $i += 10) {
			mail(implode(', ', array_slice($addresses, $i, 10)), $_REQUEST['subject'], $_REQUEST['message'], "From: Tactician Towers <tactician@thebhg.org>\r\nReply-To: unanswered@thebhg.org\r\nX-Mailer: PHP/" . phpversion());
		}
		
		$table = new Table();
		$table->StartRow();
		$table->AddCell('E-mail sent. Details follow.', 2);
		$table->EndRow();
		$table->AddRow('From:', htmlspecialchars('Tactician <tactician@thebhg.org>'));
		$table->AddRow('To:', htmlspecialchars(implode(', ', $addresses)));
		$table->AddRow('Subject:', $_REQUEST['subject']);
		$table->AddRow('Message:', '<pre>' . $_REQUEST['message'] . '</pre>');
		$table->EndTable();
	}
	elseif ($_REQUEST['kag']) {
		if ($_REQUEST['by'] == 'event' && empty($_REQUEST['event'])) {
			$kag =& $ka->GetKAG($_REQUEST['kag']);
			$events =& $kag->GetEvents();
			$form = new Form($_SERVER['PHP_SELF'], 'get');
			$form->AddHidden('by', $_REQUEST['by']);
			$form->AddHidden('kag', $_REQUEST['kag']);
			$form->StartSelect('Event:', 'event');
			foreach ($events as $event) {
				if ($event->IsTimed()){
					$type = $event->GetTypes();
					$name = $type->GetName();
				} else {
					$name = $event->GetName();
				}
				$form->AddOption($event->GetID(), $name);
			}
			$form->EndSelect();
			$form->AddSubmitButton('', 'Next >>');
			$form->EndForm();
		}
		else {
			$form = new Form($_SERVER['PHP_SELF'], 'post');
			$form->AddHidden('by', $_REQUEST['by']);
			$form->AddHidden('kag', $_REQUEST['kag']);
			if ($_REQUEST['by'] == 'event') {
				$form->AddHidden('event', $_REQUEST['event']);
			}
			$form->AddTextBox('Subject:', 'subject', '', 40);
			$form->AddTextArea('Message:', 'message', '', 10, 60);
			$form->AddCheckBox('Copy to Tactician:', 'cc', 'on', true);
			$form->AddSubmitButton('', 'Send');
			$form->EndForm();
		}
	}
	else {
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->AddHidden('by', $_REQUEST['by']);
		$form->StartSelect('KAG:', 'kag');
		foreach (array_reverse($ka->GetKAGs()) as $kag) {
			$form->AddOption($kag->GetID(), roman($kag->GetID()));
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
