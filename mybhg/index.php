<?php
$title = 'Welcome';
include('header.php');

$welcome = $config->GetValue('welcome');
$table = new Table();
$table->AddRow($welcome->GetValue());
$table->EndTable();

include('footer.php');
?>
