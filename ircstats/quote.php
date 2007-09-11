<?php
$db = mysql_connect('localhost', 'thebhg', '1IHfHTsAmILMwpP');
mysql_select_db('thebhg_holonet', $db);

if (isset($_GET['id']) && strlen($_GET['id']) > 0)
	$res = mysql_query('SELECT quote FROM irc_quotes WHERE quote_id = '.((int) $_GET['id']), $db);
else {
	do {
		$res = mysql_query('SELECT quote FROM irc_quotes ORDER BY RAND() LIMIT 1');
	} while (substr_count(mysql_result($res, 0, 'quote'), "\n") > 4);
}

header('Content-Type: text/plain');

if (mysql_num_rows($res) > 0)
	echo stripslashes(mysql_result($res, 0, 'quote'));
else
	echo 'Quote not found.';
?>
