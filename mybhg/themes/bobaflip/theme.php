<?php
class Theme_BobaFlip extends Theme {
	function Theme() {
	}

	function GetStyleSheet() {
		return '/themes/bobaflip/style.css';
	}

	function GetHeader($title) {
	}

	function GetAuthors() {
		return array(666);
	}

	function GetName() {
		return 'Boba Flipped';
	}

	function IECompliant() {
		return false;
	}
}
?>
