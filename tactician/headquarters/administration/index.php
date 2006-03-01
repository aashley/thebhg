<?php
include_once('header.php');

page_header('Administration');

echo 'Welcome to Tactician Administration.';
if ($GLOBALS['approve'])
	echo ' You have been logged in as the Tactician.';
else
	echo ' Now get out of here.';

page_footer();
?>
