<?php
require_once 'Autoload.php';
require_once 'Config.php';
require_once 'ErrorHandler.php';

if (strlen($_SERVER['REDIRECT_URL'])) {
	$url = str_replace('//', '/', str_replace('.', '', trim($_SERVER['REDIRECT_URL'], " \t\n\r\x00\x0b/")));
	if (strlen($url) == 0)
		$url = 'index';
}
else
	$url = 'index';

if (($pos = strpos($url, '?')) !== false) {
	$url = substr($url, 0, $pos);
}

$parts = explode('/', $url);
$pageClass = 'Page_' . ucfirst(array_shift($parts));
try {
	$page = new $pageClass($parts);

	$page->Render();
}
catch (Exception $e) {
	echo 'Caught exception:<br />' . $e->getMessage();
}
?>
