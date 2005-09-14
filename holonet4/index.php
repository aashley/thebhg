<?php

// Start output buffering
if (!extension_loaded('tidy')) {

	$prefix = (PHP_SHLIB_SUFFIX == 'dll') ? 'php_' : '';

	if (dl($prefix.'tidy.'.PHP_SHLIB_SUFFIX)) {

		ob_start('ob_tidyhandler');
		$tidy = true;

	} else {

		ob_start();
		$tidy = false;

	}

} else {

	ob_start('ob_tidyhandler');
	$tidy = true;

}

include_once 'objects/holonet.php';

$GLOBALS['holonet']->execute();

ob_end_flush();

?>
