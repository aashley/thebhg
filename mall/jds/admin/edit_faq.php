<?php
include('header.php');
page_header();

echo 'Edit FAQ<HR>';

if (empty($id)) {
	echo <<<EOEFS1
<FORM NAME="editfaq" METHOD="get" ACTION="$PHP_SELF">
Question: <SELECT NAME="id">
EOEFS1;
	$faq = $prefix.'faq';
	$fs = $prefix.'faq_sections';
	$sec_result = mysql_db_query($db_name, "SELECT $fs.name, $faq.question, $faq.id FROM $faq, $fs WHERE $faq.section=$fs.id ORDER BY $fs.after ASC, $faq.after ASC", $db);
	while ($sec = mysql_fetch_array($sec_result)) {
		echo '<OPTION VALUE="' . $sec['id'] . '">' . htmlspecialchars(stripslashes($sec['name'] . ': ' . $sec['question'])) . '</OPTION>';
	}
	echo '</SELECT><BR><BR><INPUT TYPE="submit" VALUE="Edit Question"> <INPUT TYPE="reset"></FORM>';
}
elseif (empty($question)) {
	$s_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix."faq WHERE id=$id", $db);
	$s = mysql_fetch_array($s_result);
	$question = htmlspecialchars(stripslashes($s['question']));
	$answer = htmlspecialchars(stripslashes($s['answer']));
	echo <<<EOAFS1
<FORM NAME="editfs" METHOD="post" ACTION="$PHP_SELF">
<INPUT TYPE="hidden" NAME="id" VALUE="$id">
Question: <INPUT TYPE="text" NAME="question" SIZE="40" VALUE="$question"><BR>
Answer: <TEXTAREA COLS="60" ROWS="5" NAME="answer">$answer</TEXTAREA><BR>
Position: <SELECT NAME="after">
EOAFS1;
	echo '<OPTION VALUE="0"' . ($s['after'] == 0 ? ' SELECTED' : '') . '>At start</OPTION>';
	$sec_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'faq WHERE section=' . $s['section'] . ' ORDER BY after ASC', $db);
	while ($sec = mysql_fetch_array($sec_result)) {
		if ($sec['id'] != $id) {
			echo '<OPTION VALUE="' . $sec['id'] . '"' . ($s['after'] == $sec['id'] ? ' SELECTED' : '') . '>After ' . htmlspecialchars(stripslashes($sec['question'])) . '</OPTION>';
		}
	}
	echo <<<EOAFS2
</SELECT><BR><BR>
<INPUT TYPE="submit" VALUE="Save Question"> <INPUT TYPE="reset">
</FORM>
EOAFS2;
}
else {
	$s_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix."faq WHERE id=$id", $db);
	$oa = mysql_result($s_result, 0, 'after');
	$oa = $oa ? "$oa" : '0';
	$section = mysql_result($s_result, 0, 'section');
	$question = addslashes($question);
	$answer = addslashes($answer);
	if ($after == $id) {
		$after = $oa;
	}
	$after = $after ? "$after" : '0';
	if (mysql_db_query($db_name, 'UPDATE '.$prefix."faq SET question='$question', answer='$answer', after=$after WHERE id=$id", $db)) {
		if ($oa != $after) {
			mysql_db_query($db_name, 'UPDATE '.$prefix."faq SET after=$oa WHERE after=$id AND section=$section", $db);
		}
		echo 'Question saved.';
	}
	else {
		echo 'Error saving question: ' . mysql_error($db);
	}
}

page_footer();
?>
