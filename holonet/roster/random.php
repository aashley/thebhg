<?php
function title() {
	return 'Random Hunter';
}

function output() {
	global $roster;

	$rand_result = mysql_query('SELECT id FROM roster_roster WHERE division NOT IN (0, 16) ORDER BY RAND() LIMIT 1', $roster->roster_db);
	$pleb = $roster->GetPerson(mysql_result($rand_result, 0, 'id'));
	header('Location: http://' . $_SERVER['HTTP_HOST'] . str_replace('&amp;', '&', internal_link('hunter', array('id'=>mysql_result($rand_result, 0, 'id')))));
}
?>
