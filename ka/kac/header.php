<?php
include_once 'roster.inc';
include_once 'objects/include.inc';
include_once 'Numbers/Roman.php';
include_once 'auth.php';
include_once 'sort.inc';

if (!function_exists('constructlayout')) {
	include_once('../Layout.inc');
}

$db = mysql_connect('localhost', 'ka', 'habecrimes');
mysql_select_db('ka', $db);

$ka = new KA_1('kac-34-fear');
$roster = new Roster('kac-34-fear');
$mb = new MedalBoard('kac-34-fear');

if (!empty($subarray)) { //When fixed, remove the !
	$subarray = array(
		'KAC List'=>'kac/index.php',
		'Latest KAC'=>'kac/stats.php?flag=kac',
		'KAC Hall of Fame'=>'kac/hof/index.php',
		'Statistics'=>'kac/stats/index.php',
		'Administration'=>'kac/administration/index.php'
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
	global $title, $ka;

	$ka = $global_ka;
	$new_output = iconv('ISO-8859-1', 'UTF-8', ob_get_contents());
	ob_clean();
	echo $new_output;
	ConstructLayout(iconv('ISO-8859-1', 'UTF-8', $title));
}

function add_menu($menu_array) {
	global $subarray;

	$subarray = array_merge(array('<b>Page Links</b>'=>'#'), $menu_array, array('<b>KAC Links</b>'=>'#'), $subarray);
}

function roman($number) {
	if ($number > 0) {
		return Numbers_Roman::toNumeral($number);
	}
	else {
		return number_format($number);
	}
}
?>
