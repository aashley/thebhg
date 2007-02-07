<?
require_once '../Layout.inc';
require_once 'HTML/Table.php';
$site = $_GET['site'];
$subarray = array(
                    'View Bounties' => 'bounties/index.php?site=index',
                    'View All Old Bounties' => 'bounties/index.php?site=old_bounties',
                    'Administration' => 'bounties/admin/index.php',
                    'Log out' => 'bounties/index.php?site=logout');
if($site == "")
{
    $site = "index";
include ("index.inc");
}else{
    Include("" . $site . ".inc");
}

ConstructLayout();
?>
