<?php
include('header.php');
page_header();

echo '<H1>Add FAQ Section</H1><HR>';

if (empty($name)) {
	echo <<<EOAFS1
<FORM NAME="addfs" METHOD="post" ACTION="$PHP_SELF">
Name: <INPUT TYPE="text" NAME="name" SIZE="20"><BR>
Position: <SELECT NAME="after"><OPTION VALUE="0">At start</OPTION>
EOAFS1;
	$sec_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'faq_sections ORDER BY after ASC', $db);
	while ($sec = mysql_fetch_array($sec_result)) {
		echo '<OPTION VALUE="' . $sec['id'] . '">After ' . htmlspecialchars(stripslashes($sec['name'])) . '</OPTION>';
	}
	echo <<<EOAFS2
</SELECT><BR><BR>
<INPUT TYPE="submit" VALUE="Add Section"> <INPUT TYPE="reset">
</FORM>
EOAFS2;
}
else {
	$name = addslashes($name);
	$after = $after ? "$after" : '0';
	if (mysql_db_query($db_name, 'INSERT INTO '.$prefix."faq_sections (name, after) VALUES ('$name', $after)", $db)) {
		if ($after == '0') {
			$ns_id = mysql_insert_id($db);
			mysql_db_query($db_name, 'UPDATE '.$prefix."faq_sections SET after=$ns_id WHERE after=0 AND id<>$ns_id", $db);
		}
		echo 'Section added.';
	}
	else {
		echo 'Error adding section: ' . mysql_error($db);
	}
}

page_footer();
?>
