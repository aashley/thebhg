<?php
include_once 'roster.inc';
include_once 'objects/include.inc';
include_once 'Numbers/Roman.php';
include_once 'auth.php';

if (!function_exists('constructlayout')) {
	include_once('../Layout.inc');
}

$db = mysql_connect('localhost', 'thebhg_ka', 'bhgkapass');
mysql_select_db('thebhg_ka', $db);

$ka = new KA_1('kac-34-fear');
$roster = new Roster('kac-34-fear');
$mb = new MedalBoard('kac-34-fear');

if (empty($subarray)) {
	$subarray = array(
		'KAC List'=>'kac/index.php',
		'Latest KAC'=>'kac/kag.php',
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
?>
