<?php
include('header.php');

page_header();

$result = mysql_db_query($db_name, "SELECT owner FROM {$prefix}sales GROUP BY owner", $db);
while ($row = mysql_fetch_array($result)) {
	$pleb = $roster->GetPerson($row['owner']);
	$pleb->SetHasShip();
	echo $pleb->GetName() . ': done.<br>';
}

page_footer();
?>
