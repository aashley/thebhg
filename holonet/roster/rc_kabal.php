<?php
function title() {
	return 'Recent Credit Awards By Division';
}

function output() {
	global $roster, $page;

	roster_header();
//	echo '<table border=0 width="100%"><tr valign="top"><td>';

	if ($_REQUEST['days']) {
		$days = $_REQUEST['days'];
	}
	else {
		$days = 7;
	}
	$start_time = time() - ($days * 86400);

	$result = mysql_query('SELECT roster_divisions.name, roster_roster.division, roster_history.person, SUM(roster_history.item2) AS credits FROM roster_divisions, roster_history, roster_roster WHERE roster_roster.id=roster_history.person AND roster_roster.division=roster_divisions.id AND roster_history.type=6 AND roster_history.date>=' . $start_time . ' GROUP BY roster_roster.division ORDER BY roster_divisions.name ASC', $roster->roster_db);
	echo mysql_error($roster->roster_db);
	if ($result && mysql_num_rows($result)) {
		$table = new Table();
		$table->StartRow();
		$table->AddHeader('Division');
		$table->AddHeader('Credits');
		$table->AddHeader('Per Hunter');
		$table->EndRow();
		while ($row = mysql_fetch_array($result)) {
			$div = $roster->GetDivision($row['division']);
			$hunters = $div->GetMemberCount();
			$table->AddRow('<a href="' . internal_link('division', array('id'=>$div->GetID())) . '">' . $div->GetName() . '</a>', '<div style="text-align: right">' . number_format($row['credits']) . '</div>', '<div style="text-align: right">' . number_format($row['credits'] / $hunters) . '</div>');
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

//	echo '</td><td width=400><img src="roster/graphs/rc_kabal.php?start_time=' . $start_time . '" alt="Recent Credits Graph" width=400 height=300 border=0></td></tr></table>';

	roster_footer();
}
?>
