<?php
$title = 'Log Out';
include('header.php');

if ($_COOKIE['mybhg_rid']) {
	setcookie('mybhg_rid');
	setcookie('mybhg_key');
}

echo 'You are now logged out.';

include('footer.php');
?>
