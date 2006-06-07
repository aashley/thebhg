<?php

include_once('roster.inc');
include_once('citadel.inc');
include_once('library.inc');
include_once('objects/arena.php');

$character = new Character($_REQUEST['who']); 
print_r($character);
$character->DNA();

?>
