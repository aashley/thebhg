<?php
ini_set('include_path', ini_get('include_path') . ':/var/www/html/include');
include('roster.inc');

if (empty($PHP_AUTH_USER)) {
	header('WWW-Authenticate: Basic Realm="#bhg logs"');
	header('HTTP/1.1 401 Unauthorized');
	echo 'You are not authorised to play with this.';
	exit;
}

$login = new Login($PHP_AUTH_USER, $PHP_AUTH_PW);
if (!$login->IsValid()) {
	header('WWW-Authenticate: Basic Realm="#bhg logs"');
	header('HTTP/1.1 401 Unauthorized');
	echo 'You are not authorised to play with this.';
	exit;
}
else {
	$div = $login->GetDivision();
	if ($div->GetID() != 10 && $div->GetID() != 9 && $login->GetID() != 666 && $login->GetID() != 11) {
		echo 'You are not authorised to play with this.';
		exit;
	}
}
?>
