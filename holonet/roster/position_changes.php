<?php
if (empty($_REQUEST['month'])) {
	$month = date('m');
	$year = date('Y');
}
else {
	$month = $_REQUEST['month'];
	$year = $_REQUEST['year'];
}
$month_ts = mktime(0, 0, 0, $month, 1, $year);
$month_name = date('F Y', $month_ts);

function coders() {
	return array(666);
}

function title() {
	global $month_name;
	
	return 'Positional Changes :: ' . $month_name;
}

function output() {
	global $month, $year, $month_name, $roster, $page;

	roster_header();

	$result = mysql_query('SELECT date, person, item1, item2 FROM roster_history WHERE type=2 AND (item1 NOT IN (13, 14, 18, 19) OR item2 NOT IN (13, 14, 18, 19)) AND date BETWEEN '.mktime(0, 0, 0, $month, 1, $year).' AND '.mktime(0, 0, 0, $month + 1, 1, $year).' ORDER BY date ASC', $roster->roster_db);
	if ($result && mysql_num_rows($result)) {
		$table = new Table('Positional Changes');
		$table->StartRow();
		$table->AddHeader('Date');
		$table->AddHeader('Hunter');
		$table->AddHeader('Change');
		$table->EndRow();

		while ($row = mysql_fetch_array($result)) {
			$person = $roster->GetPerson($row['person']);
			$pos = array($roster->GetPosition($row['item1']), $roster->GetPosition($row['item2']));
			$posChange = $pos[0]->GetName() . ' -&gt; ' . $pos[1]->GetName();
			$table->AddRow(date('j F Y', $row['date']), '<a href="'.internal_link('hunter', array('id' => $person->GetID())).'">'.htmlspecialchars($person->GetName()).'</a>', $posChange);
		}

		$table->EndTable();
		
	}
	else {
		echo 'There were no positional changes in that month.';
	}

	hr();

	$form = new Form($page, 'get');
	$form->StartSelect('Month:', 'month', $month);
	for ($i = 1; $i <= 12; $i++) {
		$m = mktime(0, 0, 0, $i);
		$form->AddOption(date('n', $m), date('F', $m));
	}
	$form->EndSelect();
	$form->StartSelect('Year:', 'year', $year);
	for ($i = 2002; $i <= (int) date('Y'); $i++) {
		$form->AddOption($i, $i);
	}
	$form->EndSelect();
	$form->AddSubmitButton('', 'View Month');
	$form->EndForm();
	
	roster_footer();
	
}
?>
