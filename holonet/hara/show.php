<?php
$result = mysql_query('SELECT * FROM '.$prefix.'shows WHERE id=' . $_REQUEST['id'], $db);
$row = mysql_fetch_array($result);

function title() {
	global $row;
	return 'Show :: ' . stripslashes($row['name']);
}

function output() {
	global $db, $row, $prefix, $roster;

	echo 'Broadcast on ' . date('j F Y \a\t G:i:s T', $row['time']) . '.';

	$seg_result = mysql_query('SELECT * FROM '.$prefix.'segments WHERE `show`=' . $row['id'], $db);
	if ($seg_result && mysql_num_rows($seg_result)) {
		hr();
		$table = new Table('Segments', true);
		$table->StartRow();
		$table->AddHeader('Name');
		$table->AddHeader('Created By');
		$table->EndRow();
		while ($seg_row = mysql_fetch_array($seg_result)) {
			$creator = $roster->GetPerson($seg_row['creator']);
			
			$table->StartRow();
			$table->AddCell(stripslashes($seg_row['name']));
			$table->AddCell('<a href="' . internal_link('hunter', array('id'=>$creator->GetID()), 'roster') . '">' . $creator->GetName() . '</a>');
			$table->EndRow();
		}
		$table->EndRow();
	}

	$pl_result = mysql_query('SELECT * FROM '.$prefix.'songs WHERE `show`=' . $row['id'], $db);
	if ($pl_result && mysql_num_rows($pl_result)) {
		hr();
		$table = new Table('Playlist', true);
		$table->StartRow();
		$table->AddHeader('Artist');
		$table->AddHeader('Title');
		$table->AddHeader('Length');
		$table->EndRow();
		while ($pl_row = mysql_fetch_array($pl_result)) {
			$table->AddRow(stripslashes($pl_row['artist']), stripslashes($pl_row['title']), format_time($pl_row['length']));
		}
		$table->EndTable();
	}
}
?>
