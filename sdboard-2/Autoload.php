<?php
function __autoload($name) {
	$name = str_replace('_', '/', $name);
	
	if (strtolower(substr($name, 0, 5)) == 'page/' && file_exists('pages/' . substr($name, 5) . '.php'))
		include_once('pages/' . substr($name, 5) . '.php');
	elseif (file_exists("classes/$name.php"))
		include_once("classes/$name.php");
}
?>
