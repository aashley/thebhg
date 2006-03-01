<?php
function hunter_sort($a, $b) {
	if ($a['cadre']->GetName() > $b['cadre']->GetName()) {
		return 1;
	}
	elseif ($a['cadre']->GetName() < $b['cadre']->GetName()) {
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
			$kid = (int) $_REQUEST['cadre'];
		}
		else {
			$cadre = $user->GetCadre();
			$kid = $cadre->GetID();
		}
		
		$cg =& $ka->GetCG($_REQUEST['cg']);
		if ($_REQUEST['event'] == 0) {
			$signups =& $cg->GetSignups();
		}
		else {
			$event =& $ka->GetEvent($_REQUEST['event']);
			$signups =& $event->GetSignups();
		}

		$hunters = array();
		foreach ($signups as $signup) {
			$person = $signup->GetPerson();
			$cadre = $signup->GetCadre();
			if ($kid == 0 || $cadre->GetID() == $kid) {
				$hunters[$person->GetID()]['person'] = $person;
				$hunters[$person->GetID()]['cadre'] = $cadre;
			}
		}

		$table = new Table();
		$table->StartRow();
		$table->AddHeader('Hunter');
		$table->AddHeader('Cadre');
		if ($_REQUEST['event'] == 0) {
			$table->AddHeader('Events');
		}
		$table->EndRow();

		uasort($hunters, hunter_sort);
		foreach ($hunters as $id=>$person) {
			$table->StartRow();
			$table->AddCell($person['person']->GetName());
			$table->AddCell($person['cadre']->GetName());
			if ($_REQUEST['event'] == 0) {
				$signups =& $cg->GetHunterSignups($id);
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
	elseif (isset($_REQUEST['cg'])) {
		$cg =& $ka->GetCG($_REQUEST['cg']);
		$events =& $cg->GetEvents();
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->AddHidden('cg', $_REQUEST['cg']);
		$form->StartSelect('Event:', 'event', '0');
		$form->AddOption('0', 'All Events');
		foreach ($events as $event) {
			$form->AddOption($event->GetID(), $event->GetName());
		}
		$form->EndSelect();
		if ($level == 3) {
			$form->StartSelect('Cadre:', 'cadre', '0');
			$form->AddOption('0', 'All Cadres');
			foreach ($roster->GetCadres() as $cadre) {
				$form->AddOption($cadre->GetID(), $cadre->GetName());
			}
			$form->EndSelect();
		}
		$form->AddSubmitButton('', 'View Signups');
		$form->EndForm();
	}
	else {
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
