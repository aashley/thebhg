<?php
$title = 'Change Log';
include('header.php');

$table = new Table();
$table->AddRow('<pre>' . file_get_contents('changelog.txt') . '</pre>');
$table->EndTable();

$show_blocks = true;
include('footer.php');
?>
