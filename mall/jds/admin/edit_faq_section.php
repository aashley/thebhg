<?php
include('header.php');
page_header();

echo 'Edit FAQ Section<HR>';

if (empty($id)) {
	echo <<<EOEFS1
<FORM NAME="editfs" METHOD="get" ACTION="$PHP_SELF">
Section: <SELECT NAME="id">
EOEFS1;
	$sec_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'faq_sections ORDER BY after ASC', $db);
	while ($sec = mysql_fetch_array($sec_result)) {
		echo '<OPTION VALUE="' . $sec['id'] . '">' . htmlspecialchars(stripslashes($sec['name'])) . '</OPTION>';
	}
	echo '</SELECT><BR><BR><INPUT TYPE="submit" VALUE="Edit Section"> <INPUT TYPE="reset"></FORM>';
}
elseif (empty($name)) {
	$s_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix."faq_sections WHERE id=$id", $db);
	$s = mysql_fetch_array($s_result);
	$name = htmlspecialchars(stripslashes($s['name']));
	echo <<<EOAFS1
<FORM NAME="editfs" METHOD="post" ACTION="$PHP_SELF">
<INPUT TYPE="hidden" NAME="id" VALUE="$id">
Name: <INPUT TYPE="text" NAME="name" SIZE="20" VALUE="$name"><BR>
Position: <SELECT NAME="after">
EOAFS1;
	echo '<OPTION VALUE="0"' . ($s['after'] == 0 ? ' SELECTED' : '') . '>At start</OPTION>';
	$sec_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'faq_sections ORDER BY after ASC', $db);
	while ($sec = mysql_fetch_array($sec_result)) {
		if ($sec['id'] != $id) {
			echo '<OPTION VALUE="' . $sec['id'] . '"' . ($s['after'] == $sec['id'] ? ' SELECTED' : '') . '>After ' . htmlspecialchars(stripslashes($sec['name'])) . '</OPTION>';
		}
	}
	echo <<<EOAFS2
</SELECT><BR><BR>
<INPUT TYPE="submit" VALUE="Save Section"> <INPUT TYPE="reset">
</FORM>
EOAFS2;
}
else {
	$s_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix."faq_sections WHERE id=$id", $db);
	$oa = mysql_result($s_result, 0, 'after');
	$oa = $oa ? "$oa" : '0';
	$name = addslashes($name);
	if ($after == $id) {
		$after = $oa;
	}
	$after = $after ? "$after" : '0';
	if (mysql_db_query($db_name, 'UPDATE '.$prefix."faq_sections SET name='$name', after=$after WHERE id=$id", $db)) {
		if ($oa != $after) {
			mysql_db_query($db_name, 'UPDATE '.$prefix."faq_sections SET after=$oa WHERE after=$id", $db);
		}
		echo 'Section saved.';
	}
	else {
		echo 'Error saving section: ' . mysql_error($db);
	}
}

page_footer();
?>
