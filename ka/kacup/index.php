<? if ($op == "signup"){
include_once 'roster.inc';
$login = new Login_HTTP();
}

require_once '../Layout.inc';
$subarray = array('Events'=>'kac/index.php?op=events', 'Seasons'=>'kac/index.php?op=seasons', 'Signup for Events'=>'kac/index.php?op=signup','Administration'=>'kac/admin/index.php' );	

include('objects/include.inc');

if ($op == "signup"){
include('includes/signup.inc');
} else {
include('news/index.php');
}

ConstructLayout(); ?>
