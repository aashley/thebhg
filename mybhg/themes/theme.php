<?php
if (isset($_REQUEST['theme'])) {
	$my_theme = $_REQUEST['theme'];
}

include_once('default/theme.php');
include_once('black/theme.php');
include_once('blue/theme.php');
include_once('boba/theme.php');
include_once('bobaflip/theme.php');
include_once('foldout/theme.php');

function get_themes() {
	return array(
		'default' => new Theme_Holonet(),
		'black' => new Theme_BlackGold(),
		'blue' => new Theme_BlueMonday(),
		'boba' => new Theme_Boba(),
		'bobaflip' => new Theme_BobaFlip(),
		'foldout' => new Theme_FoldOut(),
	);
}

class Theme {
	function Theme() {}

	function GetStylesheet() {}
	function GetAuthors() {}
	
	function GetName() {
		return 'Theme Base';
	}
	
	function IECompliant() {
		return true;
	}
}
?>
