<?php
header('Content-Type: image/png');

$banners = file('banners.txt');
if (isset($_REQUEST['line'])) {
	$line = (int) $_REQUEST['line'];
}
else {
	$line = mt_rand(0, count($banners) - 1);
}
$text = $banners[$line];

if (!file_exists("banners/$line.png") || filemtime("banners/$line.png") <= filemtime('banners.txt')) {
	// We need to create the image. Some variables are defined up top.
	$px_size = 13;
	$angle = 0;
	$right = 463;
	$top = 53;
	$font_file = realpath('./banner.ttf');
	
	$img = imagecreatefrompng('banner.png');
	$col = imagecolorclosest($img, 2, 178, 2);
	$box = imageftbbox($px_size, $angle, $font_file, $text, array());
	imagefttext($img, $px_size, $angle, $right - $box[2] - $box[0], $top + $box[1] - $box[5], $col, $font_file, $text, array());
	
	imagepng($img, "banners/$line.png");
}

readfile("banners/$line.png");
?>
