<?php
$pleb = $roster->GetPerson($_REQUEST['id']);

function title() {
	global $pleb;

	return 'Reports :: ' . $pleb->GetName();
}

function output() {
	global $pleb, $page, $roster;

	roster_header();

	$report_result = mysql_query('SELECT * FROM hn_reports WHERE author=' . $pleb->GetID() . ' ORDER BY time DESC', $roster->roster_db);
	if ($report_result && mysql_num_rows($report_result)) {
		while ($report = mysql_fetch_array($report_result)) {
			$reports[] = $report;
		}
	}

	$table = new Table();
	$table->StartRow();
	$table->AddHeader('Date');
	$table->AddHeader('Position');
	$table->EndRow();
	
	foreach ($reports as $report) {
		$pos = $roster->GetPosition($report['position']);
		$pos_text = '<a href="' . internal_link('position', array('id'=>$pos->GetID())) . '">' . $pos->GetName() . '</a>';
		if ($report['position'] >= 10) {
			$div = $roster->GetDivision($report['division']);
			$pos_text = '<a href="' . internal_link('division', array('id'=>$div->GetID())) . '">' . $div->GetName() . '</a> ' . $pos_text;
		}
		$table->AddRow('<a href="' . internal_link('report', array('id'=>$report['id'])) . '">' . date('j F Y', $report['time']) . '</a>', $pos_text);
	}

	$table->EndTable();

	roster_footer();
}
?>
