<?php
$frame = 'main.php';
if ($_GET['frame']) {
	$frame = $_GET['frame'];
	$query = array();
	foreach ($_GET as $key=>$value) {
		if ($key != 'frame' && $key != 'anchor') {
			$query[] = urlencode($key) . '=' . urlencode($value);
		}
	}
	if (count($query)) {
		$frame .= '?' . implode('&amp;', $query);
		if ($_GET['anchor']) {
			$frame .= '#' . htmlspecialchars($_GET['anchor']);
		}
	}
}
?>
