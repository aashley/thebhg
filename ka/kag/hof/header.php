<?php
$subarray = array(
	'Most Points (All-Time)'=>'kag/hof/points-alltime.php',
	'Most Points (Single KAG)'=>'kag/hof/points-single.php',
	'Most Master\'s Shields (All-Time)'=>'kag/hof/ms-alltime.php',
	'Most Master\'s Shields (Single KAG)'=>'kag/hof/ms-single.php',
	'Highest Point Average'=>'kag/hof/point-average-alltime.php',
	'Most DNPs'=>'kag/hof/dnp.php',
	'Highest DNP Rate'=>'kag/hof/dnp-rate.php',
	'<b>Hall of Fame Home</b>'=>'kag/hof/index.php',
	'<b>KAG Archive Home</b>'=>'kag/index.php'
);

include_once('../../Layout.inc');
include_once('../header.php');

function GetKAGMaxima() {
	global $db;
	
	$result = mysql_query('SELECT id, maximum FROM kags ORDER BY id ASC', $db);
	$kags = array();
	while ($row = mysql_fetch_array($result))
		$kags[$row['id']] = $row['maximum'];
	return $kags;
}

function GetScaledMaximum() {
	global $db;

	$result = mysql_query('SELECT MAX(maximum) FROM kags', $db);
	return mysql_result($result, 0, 0);
}

function ScalePoints($kag, $points, $events = 1) {
	global $db;
	
	$result = mysql_query('SELECT maximum FROM kags WHERE id = "'.mysql_escape_string($kag).'"', $db);
	return ScalePointsWithMaximum(mysql_result($result, 0, 'maximum'), $points, $events);
}

function ScalePointsWithMaximum($maximum, $points, $events = 1) {
	return ($points + ($events * (GetScaledMaximum() - $maximum)));
}

function SortPEAsc($a, $b) {
	return -1 * SortPEDesc($a, $b);
}

function SortPEDesc($a, $b) {
	if ($a['pe'] < $b['pe'])
		return 1;
	elseif ($a['pe'] == $b['pe'])
		return 0;
	return -1;
}

function SortPointsAsc($a, $b) {
	return -1 * SortPointsDesc($a, $b);
}

function SortPointsDesc($a, $b) {
	if ($a['points'] < $b['points'])
		return 1;
	elseif ($a['points'] == $b['points'])
		return 0;
	return -1;
}
?>
