<?php
include('header.php');
page_header();

function do_form($section = 0) {
	global $db_name, $db, $PHP_SELF, $prefix;
	if ($section == 0) {
		echo <<<EOAFQ1
<FORM NAME="addfaq" METHOD="post" ACTION="$PHP_SELF">
Section: <SELECT NAME="section">
EOAFQ1;
		$sec_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'faq_sections ORDER BY after ASC', $db);
		while ($sec = mysql_fetch_array($sec_result)) {
			echo '<OPTION VALUE="' . $sec['id'] . '">' . htmlspecialchars(stripslashes($sec['name'])) . '</OPTION>';
		}
		echo '</SELECT><BR><BR><INPUT TYPE="submit" VALUE="Add FAQ"> <INPUT TYPE="reset"></FORM>';
	}
	elseif (empty($question)) {
		echo <<<EOAFS1
<FORM NAME="addfaq" METHOD="post" ACTION="$PHP_SELF">
<INPUT TYPE="hidden" NAME="section" VALUE="$section">
Question: <INPUT TYPE="text" NAME="question" SIZE="40"><BR>
Answer: <TEXTAREA ROWS="5" COLS="60" NAME="answer"></TEXTAREA><BR>
Position: <SELECT NAME="after"><OPTION VALUE="0">At start</OPTION>
EOAFS1;
		$sec_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix."faq WHERE section=$section ORDER BY after ASC", $db);
		$row = 0;
		while ($sec = mysql_fetch_array($sec_result)) {
			echo '<OPTION VALUE="' . $sec['id'] . '"' . (++$row == mysql_num_rows($sec_result) ? ' SELECTED' : '') . '>After ' . htmlspecialchars(stripslashes($sec['question'])) . '</OPTION>';
		}
		echo <<<EOAFS2
</SELECT><BR><BR>
<INPUT TYPE="submit" VALUE="Add Question"> <INPUT TYPE="reset">
</FORM>
EOAFS2;
	}
}

echo '<H1>Add FAQ</H1><HR>';

if (empty($section)) {
	do_form(0);
}
elseif (empty($question)) {
	do_form($section);
}
else {
	$question = addslashes($question);
	$answer = addslashes($answer);
	$after = $after ? "$after" : '0';
	if (mysql_db_query($db_name, 'INSERT INTO '.$prefix."faq (section, question, answer, after) VALUES ($section, '$question', '$answer', $after)", $db)) {
		if ($after == '0') {
			$ns_id = mysql_insert_id($db);
			mysql_db_query($db_name, 'UPDATE '.$prefix."faq SET after=$ns_id WHERE after=0 AND id<>$ns_id AND section=$section", $db);
		}
		echo 'Question added.';
	}
	else {
		echo 'Error adding question: ' . mysql_error($db);
	}
	echo '<HR NOSHADE SIZE=2>';
	do_form($section);
}

page_footer();
?>
