<?php
include('roster.inc');
$log = new Login_HTTP();
$login = $log->GetID();
include('layout/header.inc');

if ($op == "add") {
    include('includes/add.inc');
} elseif ($op == "edit") {
    include('includes/edit.inc');
} elseif ($op == "special") {
    include('includes/special.inc');
} else {
    include('includes/menu.inc');

    if ($login == 2650){

        include('includes/admin.inc');

    }

}

include('layout/footer.inc');

?>