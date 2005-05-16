<?php
include_once 'config.php';
include_once 'classes/Base.php';
include_once 'classes/Content.php';
include_once 'classes/Menu.php';

$content = new Scum_Content;

$reqURI = explode('?', $_SERVER['REQUEST_URI'], 2);
$reqURI = $reqURI[0];

$parts = explode('/', trim($reqURI, '/'), 2);
$path = 'default';
if (count($parts) == 2)
	list($module, $path) = $parts;
elseif (count($parts) == 1)
	$module = $parts[0];
else
	$module = 'content';

$modFile = 'modules/'.ucfirst($module).'.php';
if (file_exists($modFile))
	include_once $modFile;
else {
	include_once 'modules/Content.php';
	if ($path == 'default' && strlen($module))
		$path = $module;
	else
		$path = ltrim("$module/$path", '/');
	$module = 'content';
}

$module = 'module_'.ucfirst($module);
$module = new $module($path);
$module->output();
?>
