<?php
include_once('auth.php');
include_once('sort.php');
include_once('util.php');

include_once('classes/form.php');
include_once('classes/table.php');

include_once('classes/ka.php');
include_once('classes/kag.php');
include_once('classes/event.php');
include_once('classes/signup.php');
include_once('classes/rank.php');
include_once('classes/type.php');

include_once('Numbers/Roman.php');

if (!function_exists('constructlayout')) {
	include_once('../Layout.inc');
}

ini_set('include_path', ini_get('include_path') . ':/var/www/html/include');
include_once('roster.inc');

$db = mysql_connect('localhost', 'tactician', 'thidrithow');
mysql_select_db('tactician', $db);

$global_ka = $ka;
$ka = new KAGBase($db);
$roster = new Roster('kag-73-comp');
$mb = new MedalBoard('kag-73-comp');

if (empty($subarray)) {
	$subarray = array(
		'KAG List'=>'kag/index.php',
		'Latest KAG'=>'kag/kag.php',
		'KAG Hall of Fame'=>'kag/hof/index.php',
		'Statistics'=>'kag/stats/index.php',
		'Administration'=>'kag/administration/index.php'
	);
}

function hr(){
	echo '<hr>';
}

function page_header($ltitle) {
	global $title;

	$title = $ltitle;
}

function page_footer() {
	global $title, $ka, $global_ka;

	$ka = $global_ka;
	$new_output = iconv('ISO-8859-1', 'UTF-8', ob_get_contents());
	ob_clean();
	echo $new_output;
	ConstructLayout(iconv('ISO-8859-1', 'UTF-8', $title), KABALS);
}

function add_menu($menu_array) {
	global $subarray;

	$subarray = array_merge(array('<b>Page Links</b>'=>'#'), $menu_array, array('<b>KAG Links</b>'=>'#'), $subarray);
}

function roman($number) {
	if ($number > 0) {
		return Numbers_Roman::toNumeral($number);
	}
	else {
		return number_format($number);
	}
}
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
	if ($points <= 0)
		return $points;

	return ($points + ($events * (GetScaledMaximum() - $maximum)));
}

function SortEventsAsc($a, $b) {
	return -1 * SortEventsDesc($a, $b);
}

function SortEventsDesc($a, $b) {
	if ($a['events'] < $b['events'])
		return 1;
	elseif ($a['events'] == $b['events'])
		return 0;
	return -1;
}

function SortNameAsc($a, $b) {
	return -1 * SortNameDesc($a, $b);
}

function SortNameDesc($a, $b) {
	if ($a['name'] < $b['name'])
		return 1;
	elseif ($a['name'] == $b['name'])
		return 0;
	return -1;
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

function SortWinsAsc($a, $b) {
	return -1 * SortWinsDesc($a, $b);
}

function SortWinsDesc($a, $b) {
	if ($a['wins'] < $b['wins'])
		return 1;
	elseif ($a['wins'] == $b['wins'])
		return 0;
	return -1;
}
?>
