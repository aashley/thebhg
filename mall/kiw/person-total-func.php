<?php
function get_total($id) {
	include('config.php');
	$db_kiw = mysql_connect($db_host, $db_user, $db_pass);
	if (!$db_kiw) die("Error connecting to database.");

	$result = mysql_db_query($db_name, "select sum({$prefix}sales.quantity * {$prefix}items.price) as total from {$prefix}sales, {$prefix}items where {$prefix}sales.item={$prefix}items.id and {$prefix}sales.owner=$id", $db_kiw);
	return mysql_result($result, 0, 'total');
}
?>
