<?php
ob_start('ob_gzhandler');
//header('Content-Type: text/html; charset=UTF-8');
header('Content-Type: text/html; charset=ISO-8859-1');
include('header.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html/loose.dtd">
<html>
<head>
<!--<meta http-equiv="Content-Type" content="charset=UTF-8">-->
<title><?php echo $title; ?></title>
<style type="text/css">
<!--
BODY {
	background: #dddddd;
	color: black;
	font-family: Verdana, Arial, Helvetica, Sans-Serif;
	font-size: 10pt;
	margin: 0;
	padding: 0;
}
TD {
	font-family: Verdana, Arial, Helvetica, Sans-Serif;
	font-size: 10pt;
}
SMALL {
	font-size: 8pt;
}
TABLE {
	border: 0;
}
TABLE.OUTER {
	margin: 0;
	padding: 0;
}
TABLE.MENU {
	margin-top: 8px;
}
TD.HEADER {
	border-bottom: solid 1px black;
	margin: 0;
	padding: 2px;
}
TD.FOOTER {
	border-top: solid 1px black;
	margin: 0;
	padding: 0;
	text-align: center;
	font-size: 8pt;
}
TD.MODULE {
	font-weight: bold;
	margin: 0;
	padding: 0;
}
SPAN.SELECTED {
	background: #c0c0c0;
}
SPAN.SUBMENU {
	background: #dddddd;
}
SPAN.TITLE {
	font-size: 20pt;
	font-weight: bold;
}
SPAN.PAGE-TITLE {
	font-size: 14pt;
	font-weight: bold;
}
TD.CONTENT {
	padding: 4px;
	background: white;
}
TH {
	text-align: left;
	background: #dddddd;
	font-family: Verdana, Arial, Helvetica, Sans-Serif;
	font-size: 10pt;
	font-weight: bold;
}
A {
	text-decoration: none;
	color: #000030;
}
A:HOVER {
	text-decoration: underline;
}
-->
</style>
</head>
<body>
<table width="100%" class="OUTER" cellspacing=0 cellpadding=0>
<tr>
<td class="HEADER">

<span class="TITLE"><?php echo $holonet_title; ?></span><br>
<table class="MENU" cellspacing=0 cellpadding=0>
<tr>
<?php
$modarray = array();
$before = 0;
$found = false;
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
			$modtext = '<span class="SELECTED">' . str_replace(' ', '&nbsp;', htmlspecialchars($name->get_content())) . '</span>';
		}
		else {
			if (!$found) {
				$before += 2;
			}
			$modtext = '<a href="' . internal_link('index', array(), $dir->get_content()) . '">' . str_replace(' ', '&nbsp;', htmlspecialchars($name->get_content())) . '</a>';
		}
	}

	if ($modtext) {
		$modarray[] = '<td class="MODULE">' . $modtext . '</td>';
	}
}
$after = (2 * count($modarray)) - $before;
echo implode('<td class="MODULE">&nbsp;|&nbsp;</td>', $modarray) . '<td class="MODULE" width="100%">&nbsp;</td></tr>';

if (file_exists($mdir . '/menu.xml')) {
	$menuxml = domxml_open_file($mdir . '/menu.xml');
	$items = $menuxml->get_elements_by_tagname('item');
}
else {
	$items = false;
}

if (count($items) && $items) {
	echo '<tr>';
	if ($before) {
		echo '<td colspan=' . $before . ' class="MODULE">&nbsp;</td>';
	}
	echo '<td colspan=' . $after . '><span class="SUBMENU">';
	$menuarray = array();
	foreach ($items as $item) {
		if (!$item->has_attribute('hidden')) {
			$name = current($item->get_elements_by_tagname('name'));
			$pg = current($item->get_elements_by_tagname('page'));
			$menuarray[] = '<a href="' . internal_link($pg->get_content()) . '">' . str_replace(' ', '&nbsp;', htmlspecialchars($name->get_content())) . '</a>';
		}
	}
	echo implode(' | ', $menuarray) . '</span></td></tr>';
}
?>
</tr>
</table>

</td>
</tr>
<tr>
<td class="CONTENT">
<span class="PAGE-TITLE"><?php echo $title; ?></span><br><br>
<?php output(); ?>
<br>
</td>
</tr>
<tr>
<td class="FOOTER">
<table width="100%" border=0 class="OUTER" cellspacing=0 cellpadding=0><tr><td><center>
<table width="50%" border=0>
<tr><td><center><small>
<?php
$jer = $roster->GetPerson(666);
echo 'Site code &copy; 2001-03 <a href="mailto:' . $jer->GetEmail() . '">' . 'Adam Harvey</a>, and licensed for use by the Emperor\'s Hammer.<br>Page coded by ';
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
echo implode(', ', $cnames) . '.<br>Bugs should be reported at the <a href="http://bugs.thebhg.org/">Bug Tracker</a>.<br><br>';
?>
All rights reserved 1995-2003; original contents are protected by the United States (US) Copyright Act in accordance with the Emperor's Hammer <a href="http://www.emperorshammer.org/disclaim.htm">Disclaimers and Copyrights</a> detailed herein. This site abides by the Emperor's Hammer <a href="http://www.emperorshammer.org/privacy.htm">Privacy Policy</a>.<br><br>
I hope he tells us to burn our pants.. these things are driving me nuts!
</small></center></td></tr>
</table>
</center></td></tr></table>
</td>
</tr>
</table>
</body>
</html>
<?php
ob_end_flush();
exit;

?>
