<?php
$pos = new Position($_REQUEST['id']);

function title() {
	global $pos;

	return 'Position :: ' . html_escape($pos->GetName());
}

function output() {
	global $pos, $roster;

	roster_header();
	echo 'Abbreviation: ' . html_escape($pos->GetAbbrev()) . '<br>';
	if ($pos->GetIncome() > 0) {
		echo 'Salary: ' . number_format($pos->GetIncome()) . ' ICs per month.<br>';
	}

	if ($pos->GetID() < 10) {
		$reports = mysql_query('SELECT * FROM hn_reports WHERE position=' . $pos->GetID() . ' ORDER BY time DESC', $roster->roster_db);
		if ($reports && mysql_num_rows($reports)) {
			hr();
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
	}
	
	hr();
	echo '<a href="#" onClick="history.go(-1); return false;">Back</a>';
	roster_footer();
}
?>
