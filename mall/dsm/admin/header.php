<?php
ini_set('include_path', ini_get('include_path').':..');
include('../header.php');

if (!isset($PHP_AUTH_USER) || strlen($PHP_AUTH_USER) == 0) {
	header("WWW-Authenticate: Basic realm=\"$str_abbrev Administration\"");
	header('HTTP/1.0 401 Forbidden');
	page_header();
	echo 'Achtung!';
	page_footer();
	die();
}
else {
	$login = new Login($PHP_AUTH_USER, $PHP_AUTH_PW);
	$pos = $login->GetPosition();
	if (!($login->IsValid() && $pos->GetID() == 3 || $pos->GetID() == 7 || $login->GetID() == 666 || $login->GetID() == 94)) {
		header("WWW-Authenticate: Basic realm=\"$str_abbrev Administration\"");
		header('HTTP/1.0 401 Forbidden');
		page_header();
		echo 'Achtung!';
		page_footer();
		die();
	}
}

?>
