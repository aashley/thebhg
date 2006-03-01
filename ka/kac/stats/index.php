<?php
include_once('header.php');

page_header('Index');

$table = new Table();

echo 'Welcome to the KAC Statistics Centre. Here you can find information on the performance of every kabal and every hunter in every KAC.<br /><br />'
	.'Please select the type of search you would like to conduct from the Navigation box at left.';

$table->EndTable();

page_footer();
?>
