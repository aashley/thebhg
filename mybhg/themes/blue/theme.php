<?php
class Theme_BlueMonday extends Theme {
	function Theme() {
	}

	function GetStyleSheet() {
		return '/themes/blue/style.css';
	}

	function GetAuthors() {
		return array(666);
	}

	function GetName() {
		return 'Blue Monday';
	}

	function IECompliant() {
		return true;
	}
}
?>
