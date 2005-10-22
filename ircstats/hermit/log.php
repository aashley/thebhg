<?php
import_request_variables('g');
$log = preg_replace('/[^0-9]/', '', $log);

$admin = true;
$date = mktime(0, 0, 0, substr($log, -4, 2), substr($log, -2), substr($log, -8, 4));
$title = '#bhg Log :: ' . date('j F Y', $date);
include('header.php');

echo '<table cellspacing=0 cellpadding=2>';
$meeting = file("/home/thebhg/domains/ircstats.thebhg.org/irc/bhg/bhg.log.$log");
$odd = true;
foreach ($meeting as $line) {
	if (preg_match('/^\[.....\] -/', $line)) continue;
	echo '<tr valign="top"><td';
	if ($odd) {
		$odd = false;
		echo ' class="ODD"';
	}
	else $odd = true;
	echo '><tt>';
	highlight_line($line);
	echo '</tt></td></tr>';
}
echo '</table>';

include('footer.php');
?>
