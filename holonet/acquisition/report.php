<?php
$dates = get_dates($_REQUEST['year'], $_REQUEST['week']);
$result = mysql_query('SELECT * FROM hn_reports WHERE id=' . $_REQUEST['id'], $roster->roster_db);
$row = mysql_fetch_array($result);

$all_result = mysql_query('SELECT id FROM hn_reports WHERE position=' . $row['position'] . ' AND division=' . $row['division'] . ' AND time ' . $dates['between'] . ' ORDER BY time ASC', $roster->roster_db);
if (mysql_num_rows($all_result) > 1) {
	$report = 1;
	while ($a_row = mysql_fetch_array($all_result)) {
		if ($a_row['id'] == $_REQUEST['id']) {
			break;
		}
		$report++;
	}
}

function title() {
	global $report, $row, $roster;

	if ($row['position'] <= 9) {
		$pos = $roster->GetPosition($row['position']);
		return 'Issue ' . $_REQUEST['year'] . '-' . $_REQUEST['week'] . ' :: ' . $pos->GetName() . ' Report' . ($report ? ' #' . $report : '');
	}
	elseif ($row['position'] == 10) {
		$wing = $roster->GetDivision($row['division']);
		return 'Issue ' . $_REQUEST['year'] . '-' . $_REQUEST['week'] . ' :: ' . $wing->GetName() . ' Report' . ($report ? ' #' . $report : '');
	}
	else {
		$kabal = $roster->GetDivision($row['division']);
		return 'Issue ' . $_REQUEST['year'] . '-' . $_REQUEST['week'] . ' :: ' . $kabal->GetName() . ' Kabal Report' . ($report ? ' #' . $report : '');
	}
}

function output() {
	global $row, $roster;
	
	issue_header();

	$author = $roster->GetPerson($row['author']);
	if ($row['html']) {
		$text = nl2br(stripslashes($row['report']));
	}
	else {
		$text = nl2br(html_escape(stripslashes($row['report'])));
	}
	
	$table = new Table();
	$table->AddRow('Date:', date('j F Y', $row['time']));
	$table->AddRow('Author:', '<a href="' . internal_link('hunter', array('id'=>$author->GetID()), 'roster') . '">' . $author->GetName() . '</a>');
	$table->EndRow();

	hr();
	
	echo $text;
	
	issue_footer($_REQUEST['year'], $_REQUEST['week']);
}
?>
