<?php
function append_mail(&$message, $text) {
	$message .= wordwrap($text, 72) . "\n\n";
}
?>
