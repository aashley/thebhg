<?php
include_once('header.php');
page_header('Test');

$form = new Form($_SERVER['PHP_SELF']);
$form->AddDateBox('Test:', 'test', 0, true, true);
$form->EndForm();

page_footer();
?>
