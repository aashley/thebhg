<?php
class Theme_FoldOut extends Theme {
	function Theme() {
	}

	function GetStyleSheet() {
		return '/themes/foldout/style.css';
	}

	function GetAuthors() {
		return array(666);
	}

	function GetName() {
		return 'Fold Out';
	}

	function IECompliant() {
		return false;
	}
}
?>
