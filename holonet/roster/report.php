<?php
function title() {
	return 'View Report';
}

function output() {
	global $roster;

	roster_header();
	
	$result = mysql_query('SELECT * FROM hn_reports WHERE id=' . $_REQUEST['id'], $roster->roster_db);
	if ($result && mysql_num_rows($result)) {
		$report = mysql_fetch_array($result);
		$author = $roster->GetPerson($report['author']);
		$pos = $roster->GetPosition($report['position']);
		$pos_text = '<a href="' . internal_link('position', array('id'=>$pos->GetID())) . '">' . $pos->GetName() . '</a>';
		if ($report['position'] >= 10) {
			$div = $roster->GetDivision($report['division']);
			$pos_text = '<a href="' . internal_link('division', array('id'=>$div->GetID())) . '">' . $div->GetName() . '</a> ' . $pos_text;
		}
		if ($report['html']) {
			$text = nl2br(stripslashes($report['report']));
		}
		else {
			$text = nl2br(html_escape(stripslashes($report['report'])));
		}
		
		$table = new Table();
		$table->AddRow('Date:', date('j F Y', $report['time']));
		$table->AddRow('Author:', '<a href="' . internal_link('hunter', array('id'=>$author->GetID())) . '">' . $author->GetName() . '</a>');
		$table->AddRow('Position:', $pos_text);
		$table->EndRow();

		hr();
		
		echo $text;
	}
	else {
		echo 'Unable to display report.';
	}

	roster_footer();
}
?>
