<?php
$menu = true;
$title = "Menu";
include('header.php');
?>
<b>Hermit Stats</b><br>
<a href="main.php">Main Page</a><br>
<a href="info.php">Information</a><br>
<a href="alltime.php">All-Time Stats</a><br>
<a href="month.php">Monthly Stats</a><br>
<?php echo '<a href="month.php?month=' . date('m') . '&amp;year=' . date('Y') . '">This Month</a><br>'; ?>
<a href="overall.php">Overall Stats</a><br>
<a href="person.php">Person-Specific</a><br>
<hr>
<b>PISG Stats</b><br>
<a href="../current.php">Current Stats</a><br>
<?php
$dir = opendir('/home/virtual/anya/var/www/html');
if ($dir) {
	$row = 0;
	while ($file = readdir($dir)) {
		if (substr($file, 0, 5) == 'pisg-' && substr($file, -4) == '.php') {
			$date = mktime(0, 0, 0, substr($file, 9, 2), 1, substr($file, 5, 4));
			$files[$date] = "<A HREF=\"../pisg-" . substr($file, 5, 6) . ".php\">" . date('F Y', $date) . '</A><BR>';
		}
	}
}
closedir($dir);
ksort($files);
$cfiles = count($files);
for ($i = 0; $i < 5; $i++) {
	echo array_pop($files);
}
if ($cfiles > 5) echo "<A HREF=\"oldmonth-menu.php\" TARGET=\"menu\">Older Months</A><BR>";
?>
<hr>
<b>Meetings</b><br>
<?php
$dir = opendir('/home/thebhg/domains/ircstats.thebhg.org/irc/meetings');
if ($dir) {
	$row = 0;
	while ($file = readdir($dir)) {
		if (substr($file, 0, 12) == 'meeting.log.') {
			$date = mktime(0, 0, 0, substr($file, -4, 2), substr($file, -2), substr($file, -8, 4));
			$files[$date] = "<A HREF=\"meeting.php?log=" . substr($file, -8) . "\">" . date('j M Y', $date) . '</A><BR>';
		}
	}
}
closedir($dir);
ksort($files);
for ($i = 0; $i < 5; $i++) {
	echo array_pop($files);
}
echo "<A HREF=\"meeting-menu.php\" TARGET=\"menu\">Older Meetings</A><BR>";
?>
<hr>
<b>Restricted</b><br>
<a href="log-menu.php" target="menu">Log Archive</a><br>
<a href="admin-menu.php" target="menu">Admin</a><br>
<?php include('footer.php'); ?>
