<?php
$title = 'Log Out';
include('header.php');

if ($_COOKIE['rid']) {
	setcookie('rid');
	setcookie('key');
}

echo 'You are now logged out.';

include('footer.php');
?>
