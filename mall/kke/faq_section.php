<?php
include('header.php');
page_header();

$sec_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix."faq_sections WHERE id=$id", $db);
$sec = mysql_fetch_array($sec_result);

echo "<H1>$str_name FAQ - " . htmlspecialchars(stripslashes($sec['name'])) . '</H1>';

$q_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix."faq WHERE section=$id ORDER BY after ASC", $db);
$row = 0;
if ($q_result && mysql_num_rows($q_result)) {
	while ($q = mysql_fetch_array($q_result)) {
		echo '<HR NOSHADE SIZE=2><OL TYPE="a" START="' . ++$row . '"><LI><A NAME="' . $q['id'] . '">' . htmlspecialchars(stripslashes($q['question'])) . '</A><BR><SMALL>' . nl2br(stripslashes($q['answer'])) . '</SMALL></OL>';
	}
}
else {
	echo 'There are no questions in this section.';
}

page_footer();
?>
