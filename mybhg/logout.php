<?php
$title = 'Log Out';
include('header.php');

if ($_COOKIE['mybhg_rid']) {
	setcookie('mybhg_rid');
	setcookie('mybhg_key');
}

if (isset($_GET['lastpage']))
	$lastPage = $_GET['lastpage'];
else
	$lastPage = '/index.php';

header('Location: '.$lastPage);
echo 'You are now logged out.';

include('footer.php');
?>
