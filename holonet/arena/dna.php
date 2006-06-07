<?php

echo 'oh ';

error_reporting(E_ALL);

include_once 'header.php';

echo 'hi';

$character = new Character($_REQUEST['who']); 
$character->DNA();

?>
