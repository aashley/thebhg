<?php
include 'do-import.php';

foreach (array_slice($argv, 1) as $file) {
	$date = mktime(0, 0, 0, substr($file, -4, 2), substr($file, -2), substr($file, -8, 4));
	echo date('j F Y', $date).': ';
	import($file, $date);
	echo "done\n";
}
?>
