<?php

include_once 'header.php';
	
$character = new Character($_REQUEST['who']); 
$character->DNA();

?>
