<?php
class Theme_Boba extends Theme {
	function Theme() {
	}

	function GetStyleSheet() {
		return '/themes/boba/style.css';
	}

	function GetHeader($title) {
	}

	function GetAuthors() {
		return array(666);
	}

	function GetName() {
		return 'Boba';
	}

	function IECompliant() {
		return false;
	}
}
?>
