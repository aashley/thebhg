<?php
function title() {
	return 'Reports';
}

function output() {
	global $roster, $page, $arena;

	arena_header();

	if (isset($_REQUEST['position'])) {
		$reports = mysql_query('SELECT * FROM arena_reports WHERE admin="' . $_REQUEST['position'] . '" ORDER BY time DESC', $arena->connect);
		echo mysql_num_rows($reports);
		if ($reports && mysql_num_rows($reports)) {
			$first=  mysql_fetch_array($reports);
			$table = new Table($arena->ArenaPosition($reports['admin']).' Reports', true);
			$table->StartRow();
			$table->AddHeader('Date');
			$table->AddHeader('Author');
			$table->EndRow();
			while ($report = mysql_fetch_array($reports)) {
				$author = $roster->GetPerson($report['author']);
				$table->AddRow('<a href="' . internal_link('report', array('id'=>$report['id'])) . '">' . date('j F Y', $report['time']) . '</a>', '<a href="' . internal_link('atn_general', array('id'=>$report['author'])) . '">' . $author->GetName() . '</a>');
			}
			$table->EndTable();
		}
		else {
			echo 'No reports have been lodged for this position.';
		}
	}
	else {
		$table = new Table();
		$table->StartRow();
		$table->AddHeader('Position');
		$table->AddHeader('Reports');
		$table->AddHeader('Last Report');
		$table->EndRow();

		foreach ($arena->ArenaPositions() as $key=>$t) {
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link($page, array('position'=>$key)) . '">' . $arena->ArenaPosition($key) . '</a>');
			$result = mysql_query('SELECT id, time FROM arena_reports WHERE admin="' . $key . '" ORDER BY time DESC', $arena->connect);
			$table->AddCell(mysql_num_rows($result));
			if (mysql_num_rows($result)) {
				$table->AddCell('<a href="' . internal_link('report', array('id'=>mysql_result($result, 0, 'id'))) . '">' . date('j F Y', mysql_result($result, 0, 'time')) . '</a>');
			}
			else {
				$table->AddCell('N/A');
			}
			$table->EndRow();
		}

		$table->EndTable();
	}

	arena_footer();
}
?>
