<?php
include('header.php');
page_header();

echo '<H1>' . $ship_cat_title . "</H1><HR NOSHADE SIZE=2>\n";

$st_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'shiptypes ORDER BY name ASC', $db);
if ($st_result && mysql_num_rows($st_result)) {
	echo '<TABLE CELLSPACING=1 CELLPADDING=2><TR><TH>Name</TH><TH>' . ucwords($str_plural) . '</TH><TH>&nbsp;</TH></TR>';
	while ($shiptype = mysql_fetch_array($st_result)) {
		$items_result = mysql_db_query($db_name, 'SELECT COUNT(DISTINCT id) AS ships FROM '.$prefix.'ships WHERE type='.$shiptype['id'], $db);
		$items = mysql_result($items_result, 0, 'ships');
		echo '<TR><TD><A HREF="ships.php?id='.$shiptype['id'].'">'.stripslashes($shiptype['name'])."</A></TD><TD>$items ".($items != 1 ? $str_plural : $str_singular)."</TD><TD WIDTH=\"50%\">&nbsp;</TD></TR>\n";
		echo '<TR><TD COLSPAN=3><SMALL>' . stripslashes($shiptype['description']) . "</SMALL></TD></TR>\n";
	}
	echo '</TABLE>';
}

page_footer();
?>
