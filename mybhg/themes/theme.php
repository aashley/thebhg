<?php
if (isset($_REQUEST['theme'])) {
	$my_theme = $_REQUEST['theme'];
}
include_once("$my_theme/theme.php");

function get_themes() {
	return array(
		'black'=>'Black Gold',
		'blue'=>'Blue Monday',
		'greyscale'=>'Greyscale',
		'default'=>'Holonet',
		'boba'=>'* Boba',
		'bobaflip'=>'* Boba Flipped',
	);
}
?>
