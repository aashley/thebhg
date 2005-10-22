<?php header('Content-Type: text/xml'); ?>
<rss version="0.91">
<channel>
<title>Meeting Logs</title>
<link>http://ircstats.thebhg.org/</link>
<description>Meeting Logs</description>
<language>en-au</language>
<?php
$dir = opendir('/home/thebhg/domains/ircstats.thebhg.org/irc/meetings');
if ($dir) {
	$row = 0;
	while ($file = readdir($dir)) {
		if (substr($file, 0, 12) == 'meeting.log.') {
			$date = mktime(0, 0, 0, substr($file, -4, 2), substr($file, -2), substr($file, -8, 4));
			$files[$date] = '<item><title>' . date('j F Y', $date) . '</title><link>http://ircstats.thebhg.org/hermit/meeting.php?log=' . substr($file, -8) . '</link></item>';
		}
	}
}
closedir($dir);
ksort($files);
for ($i = 0; $i < 5; $i++) {
	echo array_pop($files);
}
?>
</channel>
</rss>
