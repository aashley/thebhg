<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html/loose.dtd">
<HTML>
<HEAD>
<BASE TARGET="main">
<STYLE TYPE="text/css">
<!--
BODY {
	background: #bcd2ee;
	color: black;
	font-family: Verdana, Arial, Helvetica, Sans-Serif;
	font-size: 10pt;
}
A {
	text-decoration: none;
	color: black;
}
A:HOVER {
	text-decoration: underline;
}
-->
</STYLE>
</HEAD>
<BODY>
<?php
$yesterday = strtotime('yesterday');
$yest = date('Ymd', $yesterday);
$dir = opendir('/home/anya/eggdrop/logs/bhg');
if ($dir) {
	while ($file = readdir($dir)) {
		if (substr($file, 0, 16) == "bhg.log.$yest") {
			$date = mktime(0, 0, 0, substr($file, -4, 2), substr($file, -2), substr($file, -8, 4));
			echo '<PRE>';
			readfile('http://ircstats.thebhg.org/hermit/hermit.php?file=' . urlencode('/home/anya/eggdrop/logs/bhg/' . $file) . '&input=1&date=' . $date);
			echo '</PRE><HR>';
		}
	}
}
closedir($dir);
?>
</BODY>
</HTML>
<?php exit; ?>
