<?php
ob_start();
if (version_compare(phpversion(), '5.0.0', '>=')) {
	define('PHP5', true);
} else {
	define('PHP5', false);
}
define('DEBUG', false);
if (DEBUG) include_once 'debug.php';
//header('Content-Type: text/html; charset=UTF-8');
header('Content-Type: text/html; charset=ISO-8859-1');
include('header.php');
echo '<?xml version="1.0" encoding="iso-8859-1"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<title><?php echo $title; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-style-type" content="text/css" />
	<link rel="stylesheet" href="/undohtml.css" type="text/css" />
	<link rel="stylesheet" href="/holonet.css" type="text/css" />
</head>
<body>
	<div id="header">
		<h1><?php echo $holonet_title; ?></h1>
		<div id="bhg"><a href="http://www.thebhg.org/">BHG</a></div>
		<ul>
<?php
$modarray = array();
$before = 0;
$found = false;
if (PHP5) {
	include_once 'index.php5.inc';
} else {
	
	foreach ($modules as $mod) {
		$modtext = false;
		if ($mod->node_name() == 'link') {
			$url = current($mod->get_elements_by_tagname('url'));
			$name = current($mod->get_elements_by_tagname('name'));
			$modtext = '<a href="' . $url->get_content() . '">' . str_replace(' ', '&nbsp;', htmlspecialchars($name->get_content())) . '</a>';
		}
		elseif ($mod->node_name() == 'module' && !$mod->has_attribute('hidden')) {
			$dir = current($mod->get_elements_by_tagname('directory'));
			$name = current($mod->get_elements_by_tagname('name'));
			if ($dir->get_content() == $module) {
				$found = true;
				$modtext = '<a href="' . $dir->get_content() . '">' . str_replace(' ', '&nbsp;', htmlspecialchars($name->get_content())) . '</a>';
			}
			else {
				if (!$found) {
					$before += 2;
				}
				$modtext = '<a href="' . internal_link('index', array(), $dir->get_content()) . '">' . str_replace(' ', '&nbsp;', htmlspecialchars($name->get_content())) . '</a>';
			}
		}

		if ($modtext) {
			$modarray[] = '<li>' . $modtext . '</li>';
		}
	}
}
$after = (2 * count($modarray)) - $before;
echo implode("\n", $modarray);
?>
		</ul>
	</div>
	<div id="footer">
		<ul>
<?php

if (PHP5) {
	include_once 'index.php5.menu.inc';
} else {
	if (file_exists($mdir . '/menu.xml')) {
		$menuxml = domxml_open_file($mdir . '/menu.xml');
		$items = $menuxml->get_elements_by_tagname('item');
	}
	else {
		$items = false;
	}

	if (count($items) && $items) {
		$menuarray = array();
		foreach ($items as $item) {
			if (!$item->has_attribute('hidden')) {
				$name = current($item->get_elements_by_tagname('name'));
				$pg = current($item->get_elements_by_tagname('page'));
				$menuarray[] = '<li><a href="' . internal_link($pg->get_content()) . '">' . str_replace(' ', '&nbsp;', htmlspecialchars($name->get_content())) . '</a></li>';
			}
		}
		echo implode("\n", $menuarray);
	}
}
?>
		</ul>
	</div>
	%%sidemenu%%
	<div id="content">
		<h2><?php echo $title; ?></h2>
<?php output(); ?>
	</div>
	<div id="pagefooter">
<?php
$jer = $roster->GetPerson(666);
echo '<p>Site code &copy; 2001-05 <a href="mailto:' . $jer->GetEmail() . '">' . 'Adam Harvey</a>, and licensed for use by the Emperor\'s Hammer.<br>Page coded by ';
if (function_exists('coders')) {
	$coders = coders();
}
else {
	$coders = array(666);
}
$cnames = array();
foreach ($coders as $coder) {
	$coder = $roster->GetPerson($coder);
	$cnames[$coder->GetName()] = '<a href="mailto:' . $coder->GetEmail() . '">' . html_escape($coder->GetName()) . '</a>';
}
ksort($cnames);
echo implode(', ', $cnames) . '.<br>Bugs should be reported at the <a href="http://bugs.thebhg.org/">Bug Tracker</a>.</p';
?>
		<p>All rights reserved 1995-2003; original contents are protected by the United States (US) Copyright Act in accordance with the Emperor's Hammer <a href="http://www.emperorshammer.org/disclaim.htm">Disclaimers and Copyrights</a> detailed herein. This site abides by the Emperor's Hammer <a href="http://www.emperorshammer.org/privacy.htm">Privacy Policy</a>.</p>
		<p>I hope he tells us to burn our pants.. these things are driving me nuts!</p>
	</div>
</body>
</html>
<?php
$output = ob_get_contents();

ob_end_clean();

$output = str_replace('%%sidemenu%%', '<div id="sidemenu">'.renderMenu().'</div>', $output);

print $output;

exit;

?>
