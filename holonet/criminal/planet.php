<?php
$skill_result = mysql_query("SELECT * FROM planets WHERE id=" . $_REQUEST['id'], $db);
if ($skill_result && mysql_num_rows($skill_result)) {
	$skill = mysql_fetch_array($skill_result);
}

function title() {
	global $skill;
	return 'Planet :: ' . stripslashes($skill['name']);
}

function output() {
	global $skill;

	echo stripslashes($skill['description']) . '<br><br>';
	echo '<A HREF="#" onClick="history.go(-1); return false;">Back</A>';
}
?>
