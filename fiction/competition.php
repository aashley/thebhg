<?php
include('roster.inc');
$log = new Login_HTTP();
$login = $log->GetID();
include('layout/header.inc');
$write = new Competition();

$canpost = $write->CanPost($login, 1);

if ($canpost){

    $output = $write->Output("http://fiction.thebhg.org/layout");

    print_r($output);

} else {

    print_r($canpost);

}

include('layout/footer.inc');
?>