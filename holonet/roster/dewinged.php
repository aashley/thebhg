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

function title() {
	global $month_name;
	
	return 'Citadel Transfers :: ' . $month_name;
}

function output() {
	global $month, $year, $month_name, $roster, $page;

	roster_header();

	$divs = $roster->GetDivisions();
	foreach ($divs as $div) {
		if ($div->IsWing()) {
			$wings[] = $div->GetID();
		}
		elseif ($div->IsKabal()) {
			$kabals[] = $div->GetID();
		}
	}
	$result = mysql_query('SELECT date, person, item1 AS wing, item2 AS kabal FROM roster_history WHERE type=3 AND item1 IN (' . implode(',', $wings) . ') AND item2 IN (' . implode(',', $kabals) . ') AND date BETWEEN ' . mktime(0, 0, 0, $month, 1, $year) . ' AND ' . mktime(23, 59, 59, $month + 1, 0, $year), $roster->roster_db);
	if ($result && mysql_num_rows($result)) {
		$wing_result = mysql_query('SELECT COUNT(*) AS people, item1 AS wing FROM roster_history WHERE type=3 AND item1 IN (' . implode(',', $wings) . ') AND item2 IN (' . implode(',', $kabals) . ') AND date BETWEEN ' . mktime(0, 0, 0, $month, 1, $year) . ' AND ' . mktime(23, 59, 59, $month + 1, 0, $year) . ' GROUP BY item1 ORDER BY people DESC', $roster->roster_db);
		$table = new Table('Overall Transfers');
		$table->StartRow();
		$table->AddHeader('Wing');
		$table->AddHeader('Transfers');
		$table->EndRow();
		
		while ($wing_row = mysql_fetch_array($wing_result)) {
			$wing = $roster->GetDivision($wing_row['wing']);
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link('division', array('id'=>$wing->GetID())) . '">' . $wing->GetName() . '</a>');
			$table->AddCell(number_format($wing_row['people']));
			$table->EndRow();
		}

		$table->EndTable();

		hr();

		$table = new Table('Hunters Transferred');
		$table->StartRow();
		$table->AddHeader('Date');
		$table->AddHeader('Hunter');
		$table->AddHeader('Wing');
		$table->AddHeader('New Kabal');
		$table->EndRow();
		
		while ($row = mysql_fetch_array($result)) {
			$hunter = $roster->GetPerson($row['person']);
			$wing = $roster->GetDivision($row['wing']);
			$kabal = $roster->GetDivision($row['kabal']);

			$table->StartRow();
			$table->AddCell(date('j F Y', $row['date']));
			$table->AddCell('<a href="' . internal_link('hunter', array('id'=>$hunter->GetID())) . '">' . $hunter->GetName() . '</a>');
			$table->AddCell('<a href="' . internal_link('division', array('id'=>$wing->GetID())) . '">' . $wing->GetName() . '</a>');
			$table->AddCell('<a href="' . internal_link('division', array('id'=>$kabal->GetID())) . '">' . $kabal->GetName() . '</a>');
			$table->EndRow();
		}

		$table->EndTable();
	}
	else {
		echo 'There were no transfers out of the Citadel in ' . $month_name . '.';
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
