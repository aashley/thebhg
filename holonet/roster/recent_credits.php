<?php
function title() {
	return 'Recent Credit Awards';
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

	$result = mysql_query('SELECT person, SUM(item2) AS credits FROM roster_history WHERE type=6 AND date>=' . $start_time . ' GROUP BY person ORDER BY credits DESC', $roster->roster_db);
	if ($result && mysql_num_rows($result)) {
		$table = new Table();
		$table->StartRow();
		$table->AddHeader('&nbsp;');
		$table->AddHeader('Hunter');
		$table->AddHeader('Credits');
		$table->EndRow();
		$row_n = 0;
		$last_disp = 0;
		$last_credits = -1;
		while ($row = mysql_fetch_array($result)) {
			$row_n++;
			if ($last_credits != $row['credits']) {
				$last_credits = $row['credits'];
				$last_disp = $row_n;
			}
			$pleb = $roster->GetPerson($row['person']);
			$table->AddRow('<div style="text-align: right">' . number_format($last_disp) . '</div>', '<a href="' . internal_link('hunter', array('id'=>$pleb->GetID())) . '">' . $pleb->GetName() . '</a>', '<div style="text-align: right">' . number_format($row['credits']) . '</div>');
		}
		$table->EndTable();
	}
	else {
		echo 'No-one has had credits awarded to them in the last ' . $days . ' day' . ($days != 1 ? 's' : '') . '.';
	}

	hr();

	$form = new Form($page, 'get');
	$form->AddTextBox('Days to Show:', 'days', $days, 3);
	$form->AddSubmitButton('', 'Go');
	$form->EndForm();

	roster_footer();
}
?>
