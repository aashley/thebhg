<?php
function title() {
	return 'Current Staff';
}

function output() {
	global $roster;

	$commission = $roster->GetDivision(10);
	$ca = $roster->GetDivision(9);
	$members = array_merge($commission->GetMembers(), $ca->GetMembers());
	$table = new Table();
	$table->StartRow();
	$table->AddHeader('<a href="' . internal_link('division', array('id'=>$commission->GetID()), 'roster') . '">' . $commission->GetName() . '</a>', 2);
	$table->EndRow();
	foreach ($members as $pleb) {
		$pos = $pleb->GetPosition();
		$table->StartRow();
		$table->AddCell('<a href="' . internal_link('position', array('id'=>$pos->GetID()), 'roster') . '">' . $pos->GetName() . '</a>');
		$table->AddCell('<a href="' . internal_link('hunter', array('id'=>$pleb->GetID()), 'roster') . '">' . $pleb->GetName() . '</a>');
		$table->EndRow();
	}
	$table->EndTable();

	hr();

	$chs = $roster->SearchPosition(11);
	$wards = $roster->SearchPosition(10);
	$plebs = array_merge($wards, $chs);
	foreach ($plebs as $chief) {
		if (is_a($chief, 'Person')) {
			$kabal = $chief->GetDivision();
			$pos = $chief->GetPosition();
			$chiefs[$pos->GetWeight() . $kabal->GetName()] = $chief;
		}
	}
	ksort($chiefs);
	$table = new Table();
	$table->StartRow();
	$table->AddHeader('Chiefs/Wardens', 2);
	$table->EndRow();
	foreach ($chiefs as $pleb) {
		if (is_a($pleb, 'Person')) {
			$kabal = $pleb->GetDivision();
			$pos = $pleb->GetPosition();
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link('division', array('id'=>$kabal->GetID()), 'roster') . '">' . $kabal->GetName() . '</a> <a href="' . internal_link('position', array('id'=>$pos->GetID()), 'roster') . '">' . $pos->GetName() . '</a>');
			$table->AddCell('<a href="' . internal_link('hunter', array('id'=>$pleb->GetID()), 'roster') . '">' . $pleb->GetName() . '</a>');
			$table->EndRow();
		}
	}
	$table->EndTable();
}
?>
