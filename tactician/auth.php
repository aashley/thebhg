<?php
if (strlen($_SERVER['PHP_AUTH_USER'])) {
	$login = new Login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
}
if (empty($_SERVER['PHP_AUTH_USER']) || strlen($_SERVER['PHP_AUTH_USER']) == 0 || !($login->IsValid())) {
	header('WWW-Authenticate: Basic realm="Tactician\'s Lair Admin"');
	header('HTTP/1.1 401 Unauthorized');
	page_header('Administration');
	echo 'You must log in to administer this site.';
	page_footer();
}
?>
