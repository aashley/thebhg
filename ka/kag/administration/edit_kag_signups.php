<?php
include_once('header.php');

page_header('Edit KAG Signups');

if ($level == 3) {
	if ($_REQUEST['submit']) {
		$kag =& $ka->GetKAG($_REQUEST['id']);
		$hunter =& $roster->GetPerson($_REQUEST['person']);
		$signups =& $kag->GetHunterSignups($hunter);
		if ($signups) {
			foreach ($signups as $signup) {
				$signup->DeleteSignup();
			}
		}
		if ($_REQUEST['events']) {
			foreach ($_REQUEST['events'] as $eid=>$status) {
				$event =& $ka->GetEvent($eid);
				$event->AddSignup($hunter);
			}
		}
		if ($jud = $roster->SearchPosition(6)) {
			$jud = $jud[0];
		}
		else {
			if ($jud = $roster->SearchPosition(8)) {
				$jud = $jud[0];
			}
			else {
				$jud = $roster->GetPerson(1000);
			}
		}
		$kag->EmailSignups($hunter, $jud);
		echo 'KAG signups altered.';
	}
	elseif ($_REQUEST['person']) {
		$kag =& $ka->GetKAG($_REQUEST['id']);
		$hunter =& $roster->GetPerson($_REQUEST['person']);
		$signups =& $kag->GetHunterSignups($hunter);
		$form = new Form($_SERVER['PHP_SELF']);
		$form->AddHidden('id', $kag->GetID());
		$form->AddHidden('person', $hunter->GetID());
		foreach ($kag->GetEvents() as $event) {
			if ($event->IsTimed()){
				$type = $event->GetTypes();
				$name = $type->GetName();
			} else {
				$name = $event->GetName();
			}
			$form->AddCheckBox($name . ':', 'events[' . $event->GetID() . ']', 'on', isset($signups[$event->GetID()]));
		}
		$form->AddSubmitButton('submit', 'Save Signups');
		$form->EndForm();
	}
	elseif ($_REQUEST['id']) {
		$kag =& $ka->GetKAG($_REQUEST['id']);
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->AddHidden('id', $kag->GetID());
		$form->StartSelect('Hunter:', 'person');
		foreach ($roster->GetDivisions('name') as $div) {
			if ($div->GetID() != 0 && $div->GetID() != 16 && $div->GetMemberCount() > 0) {
				foreach ($div->GetMembers('name') as $hunter) {
					$form->AddOption($hunter->GetID(), $div->GetName() . ': ' . $hunter->GetName());
				}
			}
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Next >>');
		$form->EndForm();
	}
	else {
		$kags =& $ka->GetKAGs();
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->StartSelect('KAG:', 'id');
		foreach (array_reverse($ka->GetKAGs()) as $kag) {
			$form->AddOption($kag->GetID(), roman($kag->GetID()));
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Next >>');
		$form->EndForm();
	}
}
else {
	echo 'You are not authorised to view this page.';
}

page_footer();
?>

