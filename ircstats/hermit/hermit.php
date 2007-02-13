<?php
import_request_variables('g');
set_time_limit(0);
header('Content-Type: text/plain');
include 'do-import.php';
import($file);
?>
