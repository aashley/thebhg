<?php
include_once('header.php');

header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?><rss version="0.92"><channel><title>Recent Reports</title><link>http://holonet.thebhg.org/index.php?module=roster&amp;page=reports</link><language>en</language>';

$reports = mysql_query('SELECT id, position, time FROM hn_reports WHERE position<=9 OR position=29 ORDER BY time DESC LIMIT 5', $roster->roster_db);
if ($reports && mysql_num_rows($reports)) {
	while ($row = mysql_fetch_array($reports)) {
		$pos = $roster->GetPosition($row['position']);
		echo '<item><title>' . $pos->GetName() . ' Report (' . date('j/n/Y', $row['time']) . ')</title><link>http://holonet.thebhg.org/index.php?module=roster&amp;page=report&amp;id=' . $row['id'] . '</link></item>';
	}
}

echo '</channel></rss>';
?>
