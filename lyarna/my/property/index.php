<?php

include_once 'roster.inc';

$login = new Login_HTTP();

header("Location: ../../index.php?frame=/buildings/property?bhg_id=".$login->getID());

?>