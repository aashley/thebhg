<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Bounty Hunter's Guild: Scum of the Universe - <?php echo $GLOBALS['module']->title(); ?></title>
	<link rel="stylesheet" href="/static/main.css" type="text/css" />
</head>
<body>

<table class="main">
<tr><td id="top" colspan="3"><a href="/"><img src="/static/top.jpg"></a></td></tr>
<tr><td id="side" valign="top" rowspan="3"><img src="/static/side.jpg"></td>
<td class="main" valign="top"><table class="navbar"><tr>

<?php
$menu = new Scum_Menu;
foreach ($menu->getItems() as $item)
	echo '<td class="nav"><a href="'.htmlspecialchars($item->getLink()).'">'.htmlspecialchars($item->getName()).'</a></td>';
?>

</tr></table></td></tr>
<tr><td class="main"><table class="body">
<tr><td id="body" valign="top">
