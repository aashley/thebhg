<?php
// Dummy Changes: abcdefggggg
// Make the other includes required.
include_once('table.php');
include_once('form.php');
include_once('link.php');
include_once('hr.php');
include_once('hunter-dropdown.php');
include_once('util.php');
include_once('holonet-2.php');

include_once('roster.inc');
$roster = new Roster();
$mb = new MedalBoard();

function reject_auth() {
        header('WWW-Authenticate: Basic realm="BHG Roster"');
        header('HTTP/1.1 401 Unauthorized');
	echo 'You have either provided no user name and password, an incorrect password, or are not permitted to access this page. I suggest going back and trying again.';
	die();
}

// Establish the Holonet database connection.
$db = mysql_connect('localhost', 'thebhg_holonet', 'w0rdy');
mysql_select_db('thebhg_holonet', $db);

// Handle Path Info
if (   isset($_SERVER['PATH_INFO'])
    && $_SERVER['PATH_INFO'] > '') {

  $path = explode('/', strtolower($_SERVER['PATH_INFO']));

  if (   isset($path[1])
      && $path[1] > '') {

    $_REQUEST['module'] = $path[1];

    if (   isset($path[2])
        && $path[2] > '') {

      $_REQUEST['page'] = $path[2];

    }

  }

}

// Sort out the $module variable.
if (isset($_REQUEST['module'])) {
	$module = $_REQUEST['module'];
}
else {
	$module = 'holonet';
}

// Now sort out the $page variable.
if (isset($_REQUEST['page'])) {
	$page = str_replace('/', '', $_REQUEST['page']);
}
else {
	$page = 'index';
}

// Set the Holonet title.
$holonet_title = 'Holonet';

// Get the directory the module resides in.
$mdir = $module;
$path = $mdir . '/' . $page . '.php';
if (file_exists($mdir . '/header.php')) {
	include_once($mdir . '/header.php');
}
if (file_exists($path)) {
	// Note that the include_onced file must have two functions: output,
	// which generates the output, and title, which returns the
	// title of the page only.
	include_once($path);
	if (function_exists('auth')) {
		if (empty($_SERVER['PHP_AUTH_USER']) || strlen($_SERVER['PHP_AUTH_USER']) == 0) {
			reject_auth();
		}
		else {
			$login = new Login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
			if ($login->IsValid()) {
				if (!auth($login)) {
					reject_auth();
				}
			}
			else {
				reject_auth();
			}
		}
	}
}
else {
	include_once('error.php');
}

$modules = array();
if (PHP5) {
	include_once 'header.php5.inc';
} else {
	$modxml = domxml_open_file('modules.xml');
	$modtag = current($modxml->get_elements_by_tagname('modules'));
	$modules = $modtag->child_nodes();
	foreach ($modules as $mod) {
		if ($mod->node_name() == 'module') {
			$dir = current($mod->get_elements_by_tagname('directory'));
			if ($dir->get_content() == $module) {
				$name = current($mod->get_elements_by_tagname('name'));
				$title = $name->get_content() . ' :: ' . title();
				break;
			}
		}
	}
}
?>
