<?php
include_once('auth.php');
include_once('sort.php');
include_once('util.php');

include_once('classes/form.php');
include_once('classes/table.php');

include_once('classes/ka.php');
include_once('classes/cg.php');
include_once('classes/event.php');
include_once('classes/signup.php');
include_once('classes/rank.php');

include_once('Numbers/Roman.php');

if (!function_exists('constructlayout')) {
	include_once('../Layout.inc');
}

ini_set('include_path', ini_get('include_path') . ':/home/virtual/site5/fst/usr/share/roster3/include');
include_once('roster.inc');

$db = mysql_connect('localhost', 'thebhg_ka', 'bhgkapass');
mysql_select_db('thebhg_ka', $db);

$global_ka = $ka;
$ka = new CGBase($db);
$roster = new Roster('cg-555-deer');
$mb = new MedalBoard('cg-555-deer');

if (empty($subarray)) {
	$subarray = array(
		'CG List'=>'cg/index.php',
		'Latest CG'=>'cg/cg.php',
		'CG Hall of Fame'=>'cg/hof/index.php',
		'Statistics'=>'cg/stats/index.php',
		'Administration'=>'cg/administration/index.php'
	);
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
	ConstructLayout(iconv('ISO-8859-1', 'UTF-8', $title), CADRES);
}

function add_menu($menu_array) {
	global $subarray;

	$subarray = array_merge(array('<b>Page Links</b>'=>'#'), $menu_array, array('<b>CG Links</b>'=>'#'), $subarray);
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
