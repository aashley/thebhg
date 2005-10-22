<?php include('auth.php'); ob_start('ob_gzhandler'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html/loose.dtd">
<HTML>
<HEAD>
<BASE TARGET="main">
<STYLE TYPE="text/css">
<!--
BODY, PRE {
	background: white;
	color: black;
	font-family: Courier New, Courier, Monospace;
	font-size: 10pt;
}
-->
</STYLE>
</HEAD>
<BODY>
<PRE>
<?php
$log = file('/home/thebhg/domains/ircstats.thebhg.org/irc/bhg/' . str_replace('/', '', $name));
foreach ($log as $line) {
	echo htmlspecialchars($line);
}
?>
</PRE>
</BODY>
</HTML>
<?php header('Content-Length: ' . ob_get_length()); ob_end_flush(); exit; ?>
