<?php
header('Content-Type: image/png');

$tn = '/home/virtual/thebhg.org/home/holonet/cache/h3r_' . str_replace('/', '-', $_REQUEST['tn']);
if (!file_exists($tn)) {
	$tmp = file('http://' . $_SERVER['HTTP_HOST'] . '/roster/graphs/' . $_REQUEST['tn'] . '.php');
	unset($tmp);
}

$details = getimagesize($tn);
$img = imagecreatefrompng($tn);

if (isset($_REQUEST['x']) && isset($_REQUEST['y'])) {
	$x = $_REQUEST['x'];
	$y = $_REQUEST['y'];
}
else {
	$x = 120;
	$y = 90;
}
$output = imagecreate($x, $y);

imagecopyresized($output, $img, 0, 0, 0, 0, $x, $y, $details[0], $details[1]);
imagepng($output);
?>
