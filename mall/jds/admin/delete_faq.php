<?php
include('header.php');
page_header();

echo 'Delete FAQ<HR>';

if (empty($id)) {
	echo <<<EOEFS1
<FORM NAME="delfaq" METHOD="get" ACTION="$PHP_SELF">
Question: <SELECT NAME="id">
EOEFS1;
	$faq = $prefix.'faq';
	$fs = $prefix.'faq_sections';
	$sec_result = mysql_db_query($db_name, "SELECT $fs.name, $faq.question, $faq.id FROM $faq, $fs WHERE $faq.section=$fs.id ORDER BY $fs.after ASC, $faq.after ASC", $db);
	while ($sec = mysql_fetch_array($sec_result)) {
		echo '<OPTION VALUE="' . $sec['id'] . '">' . htmlspecialchars(stripslashes($sec['name'] . ': ' . $sec['question'])) . '</OPTION>';
	}
	echo '</SELECT><BR><BR><INPUT TYPE="submit" VALUE="Delete Question"> <INPUT TYPE="reset"></FORM>';
}
else {
	$s_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix."faq WHERE id=$id", $db);
	$oa = mysql_result($s_result, 0, 'after');
	$oa = $oa ? "$oa" : '0';
	$section = mysql_result($s_result, 0, 'section');
	if (mysql_db_query($db_name, 'DELETE FROM '.$prefix."faq WHERE id=$id", $db)) {
		mysql_db_query($db_name, 'UPDATE '.$prefix."faq SET after=$oa WHERE after=$id AND section=$section", $db);
		echo 'Question deleted.';
	}
	else {
		echo 'Error deleting question: ' . mysql_error($db);
	}
}

page_footer();
?>
