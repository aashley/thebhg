<?php
class Theme_GoodText extends Theme {
	function Theme() {
	}

	function GetStyleSheet() {
		return '/themes/goodtext/style.css';
	}

	function GetAuthors() {
		return array(666);
	}

	function GetName() {
		return 'Good Text';
	}

	function IECompliant() {
		return false;
	}
}
?>
