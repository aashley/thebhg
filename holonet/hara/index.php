<?php
function title() {
	return 'Latest Show';
}

function output() {
	global $db, $prefix;

	$result = mysql_query('SELECT id FROM ' . $prefix . 'shows ORDER BY time DESC LIMIT 1', $db);
	if ($result && mysql_num_rows($result)) {
		header('Location: http://' . $_SERVER['HTTP_HOST'] . str_replace('&amp;', '&', internal_link('show', array('id'=>mysql_result($result, 0, 'id')))));
	}
	else {
		echo 'Unable to find the latest show.';
	}
}
?>
