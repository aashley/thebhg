<?php
include_once('station.php');

$db = mysql_connect('localhost', 'my', 'badn3ws');
mysql_select_db('my', $db);
$station = new Station('YPPH', $db);
echo $station->GetOutput();
?>
