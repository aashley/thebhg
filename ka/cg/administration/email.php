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
			$cg =& $ka->GetCG($_REQUEST['cg']);
			$signups =& $cg->GetSignups();
		}
		
		foreach ($signups as $signup) {
			$person =& $signup->GetPerson();
			if (preg_match('/\\S+@\\S+\\.\\S+/', $person->GetEmail())) {
				$addresses[$person->GetID()] = make_rfc2822_address($person->GetName(), $person->GetEmail());
			}
		}

		if ($_REQUEST['cc']) {
			$addresses[$judicator->GetID()] = make_rfc2822_address($judicator->GetName(), $judicator->GetEmail());
			$addresses[$proctor->GetID()] = make_rfc2822_address($proctor->GetName(), $proctor->GetEmail());
		}
		
		for ($i = 0; $i < count($addresses); $i += 10) {
			mail(implode(', ', array_slice($addresses, $i, 10)), $_REQUEST['subject'], $_REQUEST['message'], "From: Kabal Authority <ka@thebhg.org>\r\nReply-To: unanswered@thebhg.org\r\nX-Mailer: PHP/" . phpversion());
		}
		
		$table = new Table();
		$table->StartRow();
		$table->AddCell('E-mail sent. Details follow.', 2);
		$table->EndRow();
		$table->AddRow('From:', htmlspecialchars('Kabal Authority <ka@thebhg.org>'));
		$table->AddRow('To:', htmlspecialchars(implode(', ', $addresses)));
		$table->AddRow('Subject:', $_REQUEST['subject']);
		$table->AddRow('Message:', '<pre>' . $_REQUEST['message'] . '</pre>');
		$table->EndTable();
	}
	elseif ($_REQUEST['cg']) {
		if ($_REQUEST['by'] == 'event' && empty($_REQUEST['event'])) {
			$cg =& $ka->GetCG($_REQUEST['cg']);
			$events =& $cg->GetEvents();
			$form = new Form($_SERVER['PHP_SELF'], 'get');
			$form->AddHidden('by', $_REQUEST['by']);
			$form->AddHidden('cg', $_REQUEST['cg']);
			$form->StartSelect('Event:', 'event');
			foreach ($events as $event) {
				$form->AddOption($event->GetID(), $event->GetName());
			}
			$form->EndSelect();
			$form->AddSubmitButton('', 'Next >>');
			$form->EndForm();
		}
		else {
			$form = new Form($_SERVER['PHP_SELF'], 'post');
			$form->AddHidden('by', $_REQUEST['by']);
			$form->AddHidden('cg', $_REQUEST['cg']);
			if ($_REQUEST['by'] == 'event') {
				$form->AddHidden('event', $_REQUEST['event']);
			}
			$form->AddTextBox('Subject:', 'subject', '', 40);
			$form->AddTextArea('Message:', 'message', '', 10, 60);
			$form->AddCheckBox('Copy to JUD/PR:', 'cc', 'on', true);
			$form->AddSubmitButton('', 'Send');
			$form->EndForm();
		}
	}
	else {
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->AddHidden('by', $_REQUEST['by']);
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
