<?php
include_once('header.php');

$title = 'Edit Signups';
if (isset($_REQUEST['id'])) {
	$kag =& $ka->GetKAG($_REQUEST['id']);
	$title .= ' :: KAG ' . roman($kag->GetID());
}
page_header($title);

if ($level >= 1) {
	if ($_REQUEST['submit']) {
		$kag =& $ka->GetKAG($_REQUEST['id']);
		if ($kag->GetSignupStart() <= time() && $kag->GetSignupEnd() >= time()) {
			$signups =& $kag->GetHunterSignups($user);
			if ($signups) {
				foreach ($signups as $signup) {
					$signup->DeleteSignup();
				}
			}
			if ($_REQUEST['events']) {
				foreach ($_REQUEST['events'] as $eid=>$status) {
					$event =& $ka->GetEvent($eid);
					$event->AddSignup($user);
				}
			}
			$kag->EmailSignups($user);
			echo 'KAG signups altered.';
		}
		else {
			echo 'You cannot sign up for that KAG.';
		}
	}
	elseif ($_REQUEST['id']) {
		$kag =& $ka->GetKAG($_REQUEST['id']);
		if ($kag->GetSignupStart() <= time() && $kag->GetSignupEnd() >= time()) {
			$signups =& $kag->GetHunterSignups($user);
			$form = new Form($_SERVER['PHP_SELF']);
			$form->AddHidden('id', $kag->GetID());
			foreach ($kag->GetEvents() as $event) {
				$form->AddCheckBox($event->GetName() . ':', 'events[' . $event->GetID() . ']', 'on', isset($signups[$event->GetID()]));
			}
			$form->AddSubmitButton('submit', 'Save Signups');
			$form->EndForm();
		}
		else {
			echo 'You cannot sign up for that KAG.';
		}
	}
	else {
		$kags =& $ka->GetOpenKAGs();
		if ($kags === false) {
			echo 'There are no KAGs currently open for signups.';
		}
		elseif (count($kags) == 1) {
			$kag = current($kags);
			header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?id=' . $kag->GetID());
		}
		else {
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
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>
