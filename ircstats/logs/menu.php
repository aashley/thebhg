<?php include('auth.php'); ?>
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
<U>Search</U><BR>
<A HREF="searchtime.php">Search by Time</A><BR><BR>
<U>Complete Logs</U><BR>
<?php
$dir = opendir('/home/anya/eggdrop/logs/bhg');
if ($dir) {
	while ($file = readdir($dir)) {
		if (substr($file, 0, 8) == 'bhg.log.') {
			$date = mktime(0, 0, 0, substr($file, -4, 2), substr($file, -2), substr($file, -8, 4));
			$files[$date] = "<A HREF=\"log.php?name=$file\">" . date('j M Y', $date) . '</A><BR>';
		}
	}
}
closedir($dir);
krsort($files);
echo implode('', $files);
?>
</BODY>
</HTML>
<?php exit; ?>
