<?php

include_once('roster.inc');
include_once('citadel.inc');
include_once('library.inc');
include_once('objects/arena.php');

echo 'hi';

$character = new Character($_REQUEST['who']); 
$character->DNA();

?>
