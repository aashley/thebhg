<?php
$pleb = $roster->GetPerson($_REQUEST['id']);

function title() {
	global $pleb;

	return 'History :: ' . $pleb->GetName();
}

function output() {
	global $pleb, $page;

	if (empty($_REQUEST['month']) || empty($_REQUEST['year'])) {
		$month = date('m');
		$year = date('Y');
	}
	else {
		$month = $_REQUEST['month'];
		$year = $_REQUEST['year'];
	}

	roster_header();

	hr();

	$table = new Table('', true);
	$table->StartRow();
	$table->AddHeader('Date');
	$table->AddHeader('Event');
	$table->EndRow();

	$history = new PersonHistory($pleb->GetID());
	$history->Load(mktime(0, 0, 0, $month, 1, $year), mktime(23, 59, 59, $month + 1, 0, $year), array(), (isset($_REQUEST['month']) ? 'ASC' : 'DESC'));
	if ($history->Count()) {
		do {
			$item = $history->GetItem();
			$table->AddRow(date('j F Y', $item->GetDate()), html_escape($item->GetReadable(false)));
		} while ($history->Next());
	}
	else {
		$table->StartRow();
		$table->AddCell('Nothing happened that month for this person.', 2);
		$table->EndRow();
	}

	$table->EndTable();

	hr();

	$form = new Form($page, 'get');
	$form->AddHidden('id', $pleb->GetID());
	$form->StartSelect('Month:', 'month', $month);
	for ($i = 1; $i <= 12; $i++) {
		$m = mktime(0, 0, 0, $i, 1);
		$form->AddOption(date('n', $m), date('F', $m));
	}
	$form->EndSelect();
	$form->StartSelect('Year:', 'year', $year);
	$jd = $pleb->GetJoinDate();
	$jd = getdate($jd);
	$now = getdate(time());
	for ($i = $jd['year']; $i <= $now['year']; $i++) {
		$form->AddOption($i, $i);
	}
	$form->EndSelect();
	$form->AddSubmitButton('', 'View Month');
	$form->EndForm();
	
	roster_footer();
}
?>
