<?php
class Theme_Holonet extends Theme {
	function Theme() {
	}

	function GetStyleSheet() {
		return '/themes/default/style.css';
	}

	function GetAuthors() {
		return array(666, 1699);
	}

	function GetName() {
		return 'Holonet';
	}

	function IECompliant() {
		return true;
	}
}
?>
