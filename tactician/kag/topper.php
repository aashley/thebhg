<?php
function linkify($matches) {
	$newurl = $matches[1];
	if (strpos($newurl, '/') === false) {
		$newurl = 'topper.php?file=' . $newurl;
	}
	return '<a href="' . $newurl . '">';
}

include_once('header.php');

$file = @file_get_contents('files/' . str_replace('/', '', $_REQUEST['file']));
if (preg_match('/\<title\>(.*)\<\/title\>/i', $file, $titles)) {
	$title = $titles[1];
}
else {
	$title = '';
}

page_header($title);

if (preg_match('/\<body\>(.*)\<\/body\>/i', str_replace(array("\n", "\r"), '', $file), $bodies)) {
	echo preg_replace_callback('/\<a href="(.*)"\>/iU', 'linkify', $bodies[1]);
}
else {
	echo 'Nothing found for that page.';
}

page_footer();
?>
