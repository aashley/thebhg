<?php
include_once('header.php');

$title = 'Edit Signups';
if (isset($_REQUEST['id'])) {
	$cg =& $ka->GetCG($_REQUEST['id']);
	$title .= ' :: CG ' . roman($cg->GetID());
}
page_header($title);

if ($level == 2) {
	$cadre =& $user->GetCadre();
}
elseif ($level == 3 && $_REQUEST['cadre']) {
	$cadre =& $roster->GetCadre($_REQUEST['cadre']);
}
else {
	$cadre = false;
}

if ($_REQUEST['submit']) {
	if ($signups =& $cg->GetCadreSignups($cadre)) {
		foreach ($signups as $signup) {
			$signup->DeleteSignup();
		}
	}
	$events = array();
	$team = array();
	foreach ($cg->GetEvents() as $event) {
		if ($event->isTeam())
			$team[] = $event;
		else
			$events[] = $event;
	}
	$i = 0;
	foreach ($cadre->GetMembers() as $member) {
		if ($i == 0){
			foreach ($team as $event) {
				$event->AddSignup($member);
			}
			$i++;
		}
		foreach ($events as $event) {
			$event->AddSignup($member);
		}
	}
	echo 'CG signups updated.';
}
elseif ($cadre && $cg) {
	$members =& $cadre->GetMembers();
	$form = new Form($_SERVER['PHP_SELF']);
	$form->AddHidden('cadre', $cadre->GetID());
	$form->AddHidden('id', $cg->GetID());
	$form->table->AddRow('Cadre:', $cadre->GetName());
	$form->table->AddRow('Cadre Leader:', $members[0]->GetName());
	
	$tomeet = $members[0]->getRank()->getWeight();
	$hasmet = false;
	$canplay = true;
	
	$form->table->StartRow();
	$form->table->AddCell('Cadre Members:');
	$names = array();
	foreach (array_slice($members, 1) as $member) {
		if ($tomeet > $member->getRank()->getWeight())
			$canplay = false;
		if ($tomeet == $member->getRank()->getWeight() && $hasmet)
			$canplay = false;
		if ($tomeet == $memeber->getRank()->getWeight() && !$hasmet)
			$hasmet = true;
			
		$names[] = $member->GetName();
	}
	$form->table->AddCell(implode(', ', $names));
	$form->table->EndRow();
	
	if (count($members) <= 5 && count($members) >= 2){
		if ($canplay){
			if ($members[0]->HasEstate()){
				$form->AddSubmitButton('submit', 'Update Signups');
			}
		}
	}
	$form->EndForm();
}
elseif ($level == 3 && $cg) {
	$form = new Form($_SERVER['PHP_SELF']);
	$form->AddHidden('id', $cg->GetID());
	$form->StartSelect('Cadre:', 'cadre');
	foreach ($roster->GetCadres() as $cadre) {
		$form->AddOption($cadre->GetID(), $cadre->GetName());
	}
	$form->EndSelect();
	$form->AddSubmitButton('', 'Next >>');
	$form->EndForm();
}
elseif ($level >= 2) {
	if ($level == 3) {
		$cgs =& $ka->GetCGs();
	}
	else {
		$cgs =& $ka->GetOpenCGs();
	}

	if ($cgs === false) {
		echo 'There are no CGs currently open for signups.';
	}
	elseif (count($cgs) == 1) {
		$cg = current($cgs);
		header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?id=' . $cg->GetID());
	}
	else {
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->StartSelect('CG:', 'id');
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
