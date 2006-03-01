<?
require_once '../Layout.inc';
require_once 'HTML/Table.php';
$site = $_GET['site'];
$subarray = array(
                    'View hunts' => 'hunts/index.php?site=index',
                    'View All Old Hunts' => 'hunts/index.php?site=old_hunts',
                    'Hunt Administration' => 'hunts/admin/index.php',
                    'Log out' => 'hunts/index.php?site=logout');
if($site == "")
{
    $site = "index";
include ("index.inc");
}else{
    Include("" . $site . ".inc");
}
ConstructLayout();
?>
