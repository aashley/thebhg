<?php

function make_rfc2822_address($name, $address) {
	$name = preg_replace('/[^A-Za-z0-9!#$%&\'*+\\-\\/=?^_`{}|~ ]/', '', $name);
	$address = preg_replace('/[^A-Za-z0-9!#$%&\'*+\\-\\/=?^_`{}|~.@]/', '', $address);
	return $name . ' <' . $address . '>';
}

function output(){
	global $ka, $uploaddir, $judicator, $proctor;
	
	if ($_REQUEST['send']) {
		
		if (isset($_REQUEST['message']) && isset($_REQUEST['round']) && isset($_REQUEST['kac'])){
			$addresses = array();
			
			$ladder = new Ladder($_REQUEST['kac']);
			$kabals = $ladder->RoundKabals($_REQUEST['round']);
			
			foreach ($kabals as $kabal) {
				if (preg_match('/\\S+@\\S+\\.\\S+/', $kabal->GetMailingList())) {
					$addresses[$kabal->GetID()] = make_rfc2822_address($kabal->GetName(), $kabal->GetMailingList());
				}
			}
	
			if ($_REQUEST['cc']) {
				$addresses[$judicator->GetID()] = make_rfc2822_address($judicator->GetName(), $judicator->GetEmail());
				$addresses[$proctor->GetID()] = make_rfc2822_address($proctor->GetName(), $proctor->GetEmail());
			}
			
			for ($i = 0; $i < count($addresses); $i += 10) {
				//mail(implode(', ', array_slice($addresses, $i, 10)), $_REQUEST['subject'], $_REQUEST['message'], "From: Kabal Authority <ka@thebhg.org>\r\nReply-To: unanswered@thebhg.org\r\nX-Mailer: PHP/" . phpversion());
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
		} else {
			echo 'Missing either message, round, kac, or all of the above. Go back and try again.';
		}
	} elseif ($_REQUEST['emailround']) {
		
		if (isset($_REQUEST['round'])){
			$form = new Form($PHP_SELF);
			
			$form->AddSectionTitle('Compose eMail');
			
			$round = new Rounds($_REQUEST['round']);
				
			$form->AddHidden('round', $_REQUEST['round']);
			$form->AddHidden('kac', $_REQUEST['kac']);
			$form->AddTextBox('Subject:', 'subject', '', 40);
			$form->AddTextArea('Message:', 'message', '', 10, 60);
			$form->AddCheckBox('Copy to JUD/PR:', 'cc', 'on', true);
			$form->AddSubmitButton('send', 'Send eMail');
			$form->EndForm();
		} else {
			echo 'Missing required round.';
		}
	} elseif ($_REQUEST['next']){
		
		if (isset($_REQUEST['kac'])){
			$kac = new KAC($_REQUEST['kac']);
			
			$form = new Form($PHP_SELF);
				
			$form->AddSectionTitle('Select Round');
			
			$form->StartSelect('Select Round', 'round');
			foreach ($kac->GetRounds() as $type){
				$form->AddOption($type->GetID(), 'Round '.$type->GetRoundID());
			}
			$form->EndSelect();
			
			$form->AddSubmitButton('emailround', 'Send eMail to all Kabals in Round');
			$form->EndForm();
		} else {
			echo 'Missing required Season.';
		}
		
	} else {
		$events = array();
		
		if (count($ka->GetOpenKACs())){
			
			foreach ($ka->GetOpenKACs() as $type){
				if (count($type->GetRounds())){
					$events[] = $type;
				}
			}
			
			if (count($events)){
			
				$form = new Form($PHP_SELF);
				
				$form->AddSectionTitle('Select Season');
				
				$form->StartSelect('Select KAC', 'kac');
				foreach ($events as $type){
					$form->AddOption($type->GetID(), 'Season '.roman($type->GetID()));
				}
				$form->EndSelect();
				
				$form->AddSubmitButton('next', 'Get Round');
				$form->EndForm();
				
			} else {
				echo 'There are no seasons with established rounds.';	
			}
		} else {
			echo 'There are no open seasons.';
		}
	}	
}

?>