<?php
require_once 'classes/BoardException.php';

function ErrorHandler($errno, $errstr, $errfile, $errline) {
	if ($errno != 2048)
		echo "<b>Error</b>: $errstr ($errno) at $errfile:$errline<br /><b>Debug Backtrace</b>: ".BoardException::FormatBacktrace();
}

set_error_handler('ErrorHandler');
?>
