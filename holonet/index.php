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
	<!-- compliance patch for microsoft browsers -->
	<!--[if lt IE 7]>
	<script src="/ie7/ie7-standard.js" type="text/javascript">
	</script>
	<![endif]-->
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
				$modtext = '<a href="' . internal_link('index', array(), $dir->get_content()) . '">' . str_replace(' ', '&nbsp;', htmlspecialchars($name->get_content())) . '</a>';
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
echo '<p>Site code &copy; 2001-05 <a href="mailto:' . $jer->GetEmail() . '">' . 'Adam Harvey</a>, and licensed for use by the Bounty Hunters Guild.<br>Page coded by ';
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
echo implode(', ', $cnames) . '.<br>Bugs should be reported in <a href="https://svn.cernun.net/">Trac</a>.</p';
?>
		<p>All rights reserved 1995-2005; original contents are protected by the United States (US) Copyright Act in accordance with the Bounty Hunters Guild <a href="http://www.thebhg.org/disclaimer">Disclaimers and Copyrights</a> detailed herein. This site abides by the Bounty Hunters Guild <a href="http://www.thebhg.org/privacy">Privacy Policy</a>.</p>
		<p>I hope he tells us to burn our pants.. these things are driving me nuts!</p>
		<div id="footer_banner">
		<script language='JavaScript' type='text/javascript'>
		<!--
		// Insert click tracking URL here
		document.phpAds_ct0 ='Insert_Clicktrack_URL_Here'

		var awrz_rnd = Math.floor(Math.random()*99999999999);
		var awrz_protocol = location.protocol.indexOf('https')>-1?'https:':'http:';
		if (!document.phpAds_used) document.phpAds_used = ',';
		document.write ("<" + "script language='JavaScript' type='text/javascript' src='");
		document.write (awrz_protocol+"//banner.thebhg.org/adjs.php?n=a6ae4dab");
		document.write ("&zoneid=3");
		document.write ("&exclude=" + document.phpAds_used);
		document.write ("&loc=" + escape(window.location));
		if (document.referrer)
		  document.write ("&referer=" + escape(document.referrer));
		document.write ('&r=' + awrz_rnd);
		document.write ("&ct0=" + escape(document.phpAds_ct0));
		document.write ("'><" + "/script>");
		//-->
		</script><noscript><a href='http://banner.thebhg.org/adclick.php?n=a6ae4dab' target='_blank'><img src='http://banner.thebhg.org/adview.php?zoneid=3&n=a6ae4dab' border='0' alt=''></a></noscript></td></tr></table>
		</div>
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
