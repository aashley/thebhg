<?php
function hunter_sort($a, $b) {
	if ($a['kabal']->GetName() > $b['kabal']->GetName()) {
		return 1;
	}
	elseif ($a['kabal']->GetName() < $b['kabal']->GetName()) {
		return -1;
	}
	elseif ($a['person']->GetName() > $b['person']->GetName()) {
		return 1;
	}
	elseif ($a['person']->GetName() < $b['person']->GetName()) {
		return -1;
	}
	else {
		return 0;
	}
}

include_once('header.php');

page_header('View Signups');

if ($level >= 2) {
	if (isset($_REQUEST['event'])) {
		if ($level == 3) {
			$kid = (int) $_REQUEST['kabal'];
		}
		else {
			$kabal = $user->GetDivision();
			$kid = $kabal->GetID();
		}
		
		$kag =& $ka->GetKAG($_REQUEST['kag']);
		if ($_REQUEST['event'] == 0) {
			$signups =& $kag->GetSignups();
		}
		else {
			$event =& $ka->GetEvent($_REQUEST['event']);
			$signups =& $event->GetSignups();
		}

		$hunters = array();
		foreach ($signups as $signup) {
			$person = $signup->GetPerson();
			$kabal = $signup->GetKabal();
			if ($kid == 0 || $kabal->GetID() == $kid) {
				$hunters[$person->GetID()]['person'] = $person;
				$hunters[$person->GetID()]['kabal'] = $kabal;
			}
		}

		$table = new Table();
		$table->StartRow();
		$table->AddHeader('Hunter');
		$table->AddHeader('Kabal');
		if ($_REQUEST['event'] == 0) {
			$table->AddHeader('Events');
		}
		$table->EndRow();

		uasort($hunters, hunter_sort);
		foreach ($hunters as $id=>$person) {
			$table->StartRow();
			$table->AddCell($person['person']->GetName());
			$table->AddCell($person['kabal']->GetName());
			if ($_REQUEST['event'] == 0) {
				$signups =& $kag->GetHunterSignups($id);
				$events = array();
				foreach ($signups as $signup) {
					$event =& $signup->GetEvent();
					$events[] = $event->GetName();
				}
				sort($events);
				$table->AddCell(implode(', ', $events));
			}
			$table->EndRow();
		}

		$table->EndTable();
	}
	elseif (isset($_REQUEST['kag'])) {
		$kag =& $ka->GetKAG($_REQUEST['kag']);
		$events =& $kag->GetEvents();
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->AddHidden('kag', $_REQUEST['kag']);
		$form->StartSelect('Event:', 'event', '0');
		$form->AddOption('0', 'All Events');
		foreach ($events as $event) {
			$form->AddOption($event->GetID(), $event->GetName());
		}
		$form->EndSelect();
		if ($level == 3) {
			$form->StartSelect('Kabal:', 'kabal', '0');
			$form->AddOption('0', 'All Kabals');
			foreach ($roster->GetKabals() as $kabal) {
				$form->AddOption($kabal->GetID(), $kabal->GetName());
			}
			$form->EndSelect();
		}
		$form->AddSubmitButton('', 'View Signups');
		$form->EndForm();
	}
	else {
		$form = new Form($_SERVER['PHP_SELF'], 'get');
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
