<?php
include_once('header.php');

page_header('Index');

$ladder = new Ladder();

$ladder->GenerateLadder();

page_footer();
?>
