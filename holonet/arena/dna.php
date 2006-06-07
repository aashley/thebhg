<?php

echo 'oh ';

include_once 'header.php';

echo 'hi';

$character = new Character($_REQUEST['who']); 
$character->DNA();

?>
