<?php
$result = mysql_query('SELECT name, help FROM cs_fields WHERE id=' . $_REQUEST['id'], $sheet_db);
$name = nl2br(html_escape(stripslashes(mysql_result($result, 0, 'name'))));
$help = nl2br(html_escape(stripslashes(mysql_result($result, 0, 'help'))));

function title() {
	global $name;
	return 'Character Sheets :: Help :: Fields :: ' . $name;
}

function output() {
	global $help;
	
	roster_header();
	echo $help;
	hr();
	echo '<a href="#" onClick="history.go(-1)">Back</a>';
	roster_footer();
}
?>
