<?php
$login = new Login_HTTP();
$login_position = $login->GetPosition();
if (($login_position->GetID() != 6) && ($login_position->GetID() != 8)) {
    echo 'You are not allowed to view this page.';
    ConstructLayout();
    exit();
}
?>






Put your stuff here...
