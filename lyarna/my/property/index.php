<?php

include_once 'roster.inc';

$login = new Login_HTTP();

header("Location: ../../index.php?frame=/buildings/property.php?bhg_id=".$login->getID());

?>