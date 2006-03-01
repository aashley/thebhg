<?php
include_once('header.php');
page_header('Test');

$cg = $ka->GetCG(7);
print_r($cg->GetCadreSignups(9));

page_footer();
?>
