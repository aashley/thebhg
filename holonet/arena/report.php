<?php
function title() {
	return 'View Report';
}

function output() {
	global $roster, $arena;

	arena_header();
	
	$result = mysql_query('SELECT * FROM arena_reports WHERE id=' . $_REQUEST['id'], $arena->connect);
	if ($result && mysql_num_rows($result)) {
		$report = mysql_fetch_array($result);
		$author = $roster->GetPerson($report['author']);
		$pos_text = $arena->ArenaPosition($report['admin']);
		if ($report['html']) {
			$text = nl2br(stripslashes($report['report']));
		}
		else {
			$text = nl2br(html_escape(stripslashes($report['report'])));
		}
		
		$table = new Table();
		$table->AddRow('Position:', $pos_text);
		$table->AddRow('Date:', date('j F Y', $report['time']));
		$table->AddRow('Author:', '<a href="' . internal_link('atn_general', array('id'=>$author->GetID())) . '">' . $author->GetName() . '</a>');
		$table->EndRow();

		hr();
		
		echo $text;
	}
	else {
		echo 'Unable to display report.';
	}

	arena_footer();
}
?>
