<?php
class Theme_BlackGold extends Theme {
	function Theme() {
	}

	function GetStyleSheet() {
		return '/themes/black/style.css';
	}

	function GetAuthors() {
		return array(666);
	}

	function GetName() {
		return 'Black Gold';
	}

	function IECompliant() {
		return true;
	}
}
?>
