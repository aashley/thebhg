<?php
$sec_result = mysql_query('SELECT * FROM '.$prefix."faq_sections WHERE id=" . $_REQUEST['id'], $db);
$sec = mysql_fetch_array($sec_result);

function title() {
	global $sec;

	return 'Frequently Asked Questions :: ' . $sec['name'];
}

function output() {
	global $db, $prefix;
	
	$q_result = mysql_query('SELECT * FROM '.$prefix."faq WHERE section=" . $_REQUEST['id'] . " ORDER BY after ASC", $db);
	$row = 0;
	if ($q_result && mysql_num_rows($q_result)) {
		while ($q = mysql_fetch_array($q_result)) {
			hr();
			echo '<OL TYPE="a" START="' . ++$row . '"><LI><A NAME="' . $q['id'] . '">' . htmlspecialchars(stripslashes($q['question'])) . '</A><BR><SMALL>' . nl2br(stripslashes($q['answer'])) . '</SMALL></OL>';
		}
	}
	else {
		echo 'There are no questions in this section.';
	}
}
?>
