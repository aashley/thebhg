<?php
function title() {
	return 'Recent Promotions';
}

function output() {
	global $roster, $page;

	roster_header();

	if (isset($_REQUEST['days'])) {
		$days = $_REQUEST['days'];
	}
	else {
		$days = 7;
	}
	$start_time = time() - ($days * 86400);

	$result = mysql_query('SELECT person, item2 AS rankid, date FROM roster_history WHERE type=1 AND date>=' . $start_time . ' AND item1<>item2 ORDER BY date DESC', $roster->roster_db);
	if ($result && mysql_num_rows($result)) {
		$table = new Table();
		$table->StartRow();
		$table->AddHeader('Date');
		$table->AddHeader('Hunter');
		$table->AddHeader('New Rank');
		$table->EndRow();
		while ($row = mysql_fetch_array($result)) {
			$pleb = $roster->GetPerson($row['person']);
			$rank = new Rank($row['rankid']);
			$table->AddRow(date('j F Y', $row['date']), '<a href="' . internal_link('hunter', array('id'=>$pleb->GetID())) . '">' . $pleb->GetName() . '</a>', '<a href="' . internal_link('rank', array('id'=>$rank->GetID())) . '">' . $rank->GetName() . '</a>');
		}
		$table->EndTable();
	}
	else {
		echo 'No-one has been promoted in the last ' . $days . ' day' . ($days != 1 ? 's' : '') . '.';
	}

	hr();

	$form = new Form($page);
	$form->AddTextBox('Days to Show:', 'days', $days, 3);
	$form->AddSubmitButton('', 'Go');
	$form->EndForm();

	roster_footer();
}
?>
