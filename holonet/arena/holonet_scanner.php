<?php

require_once('../scanner/index.php');

(!empty($_SERVER)) ? $server = $_SERVER : $server = $HTTP_SERVER_VARS;

$scan = new ScanHolonet($server['REQUEST_URI'], $server['SERVER_NAME'], $server['SCRIPT_FILENAME'], $server['HTTP_HOST']);

$scan->SetSVN('https://svn.cernun.net:1200/repos/users/gravant/ham_1.0/objects/');

$scan->MakeOutput($scan->WriteSortedModules());

?>

