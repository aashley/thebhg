<?php
$title = 'Log Out';
include('header.php');

if ($_COOKIE['mybhg_rid']) {
	setcookie('mybhg_rid');
	setcookie('mybhg_key');
}

header('Location: /news.php');
echo 'You are now logged out.';

include('footer.php');
?>
