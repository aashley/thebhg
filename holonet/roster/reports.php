<?php
function title() {
	return 'Reports';
}

function output() {
	global $roster, $page;

	roster_header();

	if (isset($_REQUEST['position'])) {
		$reports = mysql_query('SELECT * FROM hn_reports WHERE position=' . $_REQUEST['position'] . ($_REQUEST['division'] ? ' AND division=' . $_REQUEST['division'] : '') . ' ORDER BY time DESC', $roster->roster_db);
		if ($reports && mysql_num_rows($reports)) {
			$table = new Table('Reports', true);
			$table->StartRow();
			$table->AddHeader('Date');
			$table->AddHeader('Author');
			$table->EndRow();
			while ($report = mysql_fetch_array($reports)) {
				$author = $roster->GetPerson($report['author']);
				$table->AddRow('<a href="' . internal_link('report', array('id'=>$report['id'])) . '">' . date('j F Y', $report['time']) . '</a>', '<a href="' . internal_link('hunter', array('id'=>$report['author'])) . '">' . $author->GetName() . '</a>');
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

		// Commission position IDs.
		$c_pids = array(1, 2, 3, 4, 5, 6, 29, 7, 8, 9);
		foreach ($c_pids as $i) {
			$pos = $roster->GetPosition($i);
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link($page, array('position'=>$i)) . '">' . $pos->GetName() . '</a>');
			$result = mysql_query('SELECT id, time FROM hn_reports WHERE position=' . $i . ' ORDER BY time DESC', $roster->roster_db);
			$table->AddCell(mysql_num_rows($result));
			if (mysql_num_rows($result)) {
				$table->AddCell('<a href="' . internal_link('report', array('id'=>mysql_result($result, 0, 'id'))) . '">' . date('j F Y', mysql_result($result, 0, 'time')) . '</a>');
			}
			else {
				$table->AddCell('N/A');
			}
			$table->EndRow();
		}

		$citadel = $roster->GetDivisionCategory(1);
		$wings = $citadel->GetDivisions();
		$warden = $roster->GetPosition(10);
		foreach ($wings as $wing) {
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link($page, array('position'=>$warden->GetID(), 'division'=>$wing->GetID())) . '">' . $wing->GetName() . ' ' . $warden->GetName() . '</a>');
			$result = mysql_query('SELECT id, time FROM hn_reports WHERE position=' . $warden->GetID() . ' AND division=' . $wing->GetID() . ' ORDER BY time DESC', $roster->roster_db);
			$table->AddCell(mysql_num_rows($result));
			if (mysql_num_rows($result)) {
				$table->AddCell('<a href="' . internal_link('report', array('id'=>mysql_result($result, 0, 'id'))) . '">' . date('j F Y', mysql_result($result, 0, 'time')) . '</a>');
			}
			else {
				$table->AddCell('N/A');
			}
			$table->EndRow();
		}

		$ka = $roster->GetDivisionCategory(2);
		$kabals = $ka->GetDivisions();
		$chief = $roster->GetPosition(11);
		foreach ($kabals as $kabal) {
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link($page, array('position'=>$chief->GetID(), 'division'=>$kabal->GetID())) . '">' . $kabal->GetName() . ' ' . $chief->GetName() . '</a>');
			$result = mysql_query('SELECT id, time FROM hn_reports WHERE position=' . $chief->GetID() . ' AND division=' . $kabal->GetID() . ' ORDER BY time DESC', $roster->roster_db);
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

	roster_footer();
}
?>
