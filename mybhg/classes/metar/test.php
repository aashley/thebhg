<?php
include_once('station.php');

$db = mysql_connect('localhost', 'thebhg_my', 'badn3ws');
mysql_select_db('thebhg_my', $db);
$station = new Station('YPPH', $db);
echo $station->GetOutput();
?>
