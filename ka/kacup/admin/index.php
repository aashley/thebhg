<? require_once '../../Layout.inc';
include_once 'roster.inc';

$login = new Login_HTTP();


$subarray = array('Add Event'=>'kac/admin/index.php?op=add', 'Start New Seasons'=>'kac/admin/index.php?op=season', 'Grade Season'=>'kac/admin/index.php?op=grade', 'News Admin'=>'kac/admin/index.php?op=news', 'Edit My Signups'=>'kac/admin/index.php?op=editsignups', 'KAC Home'=>'kac/index.php');	

include('../objects/include.inc');
$connine = new KACObj();

if ($op == "add"){
include('../includes/add.inc');
} elseif ($op == "season"){
include('../includes/season.inc');
} elseif ($op == "news"){
include('../news/admin.inc');
} elseif ($op == "editsignups"){
include('../includes/signups.inc');
}

ConstructLayout(); ?>
