<?php
function title() {
	return 'Show Archive';
}

function output() {
	global $db, $prefix;

	$result = mysql_query('SELECT * FROM ' . $prefix . 'shows ORDER BY time DESC', $db);
	if ($result && mysql_num_rows($result)) {
		$table = new Table('', true);
		$table->StartRow();
		$table->AddHeader('Name');
		$table->AddHeader('Date/Time');
		$table->EndRow();
		while ($row = mysql_fetch_array($result)) {
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link('show', array('id'=>$row['id'])) . '">' . stripslashes($row['name']) . '</a>');
			$table->AddCell(date('j F Y \a\t G:i:s T', $row['time']));
			$table->EndRow();
		}
		$table->EndTable();
	}
	else {
		echo 'No shows found.';
	}
}
?>
