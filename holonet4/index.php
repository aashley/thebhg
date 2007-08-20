<?php

// Start output buffering
if (!extension_loaded('tidy')) {

	$prefix = (PHP_SHLIB_SUFFIX == 'dll') ? 'php_' : '';

	if (@dl($prefix.'tidy.'.PHP_SHLIB_SUFFIX)) {

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

try {
	include_once '/usr/share/bhg/bhg.php';
	include_once 'objects/holonet.php';

	$GLOBALS['gods'] = array(94, 666, 2650);

	$GLOBALS['bhg']->setCodeID('roster-69god');
	$GLOBALS['holonet']->execute();

} catch (Exception $e) {

	print $e->__toString();

}

ob_end_flush();

?>
