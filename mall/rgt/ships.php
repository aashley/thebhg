<?php
include('header.php');

page_header();

$st_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix."shiptypes WHERE id=$id", $db);
echo '<H1>' . stripslashes(mysql_result($st_result, 0, 'name')) . "</H1><BR>\n";
echo stripslashes(mysql_result($st_result, 0, 'description')) . "<HR NOSHADE SIZE=2>\n";

$items_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix."ships WHERE type=$id ORDER BY price ASC", $db);
if ($items_result && mysql_num_rows($items_result)) {
	echo '<TABLE CELLSPACING=1 CELLPADDING=2><TR><TH>Name</TH><TH>Value</TH></TR>';
	while ($item = mysql_fetch_array($items_result)) {
		echo '<TR><TD><A HREF="ship.php?id=' . $item['id'] . '">' . stripslashes($item['name']) . '</A></TD><TD>' . number_format($item['price']) . ' ICs</TD></TR>';
	}
	echo "</TABLE><HR NOSHADE SIZE=2>\n";
}

page_footer();
?>
