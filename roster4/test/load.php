<?php

ini_set('include_path', '.:../src:'.ini_get('include_path'));

include_once 'bhg.php';

print $GLOBALS['bhg']->roster->getPerson(94)->getName()."\n";

print_r($GLOBALS['bhg']->roster->getPerson(94)->getPasswd());

print_r($GLOBALS['bhg']->roster->getPerson(94)->getDateCreated());

?>
