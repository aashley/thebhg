<?php
include('header.php');
page_header();

echo '<H1>Delete FAQ Section</H1><HR>';

if (empty($id)) {
	echo <<<EOEFS1
<FORM NAME="delfs" METHOD="post" ACTION="$PHP_SELF">
Section: <SELECT NAME="id">
EOEFS1;
	$sec_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'faq_sections ORDER BY after ASC', $db);
	while ($sec = mysql_fetch_array($sec_result)) {
		echo '<OPTION VALUE="' . $sec['id'] . '">' . htmlspecialchars(stripslashes($sec['name'])) . '</OPTION>';
	}
	echo '</SELECT><BR><BR><INPUT TYPE="submit" VALUE="Delete Section"> <INPUT TYPE="reset"></FORM>';
}
else {
	$s_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix."faq_sections WHERE id=$id", $db);
	$oa = mysql_result($s_result, 0, 'after');
	$oa = $oa ? "$oa" : '0';
	if (mysql_db_query($db_name, 'DELETE FROM '.$prefix."faq_sections WHERE id=$id", $db)) {
		mysql_db_query($db_name, 'UPDATE '.$prefix."faq_sections SET after=$oa WHERE after=$id", $db);
		mysql_db_query($db_name, 'DELETE FROM '.$prefix."faq WHERE section=$id", $db);
		echo 'Section deleted.';
	}
	else {
		echo 'Error deleting section: ' . mysql_error($db);
	}
}

page_footer();
?>
