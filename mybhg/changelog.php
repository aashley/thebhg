<?php
$title = 'Change Log';
include('header.php');

$log = preg_replace(array('/^-- /m', '/ --$/m', '/^[0-9]+. (.*)$/m', '/^$/m'),
		    array('<b>', '</b><ol>', '<li>\1</li>', '</ol>'),
		    htmlspecialchars(file_get_contents('changelog.txt')));

$table = new Table();
$table->AddRow($log);
$table->EndTable();

$show_blocks = true;
include('footer.php');
?>
