<?
ini_set('include_path', './objects:'.ini_get('include_path'));
require_once '../Layout.inc';
require_once 'HTML/Table.php';

require_once 'ka.inc';
$ka = new KA('ka-4-hunt');

$subarray = array(
                    'View Bounties' => 'bounties/index.php?site=index',
                    'View All Old Bounties' => 'bounties/index.php?site=old_bounties',
                    'Administration' => 'bounties/admin/index.php',
                    'Log out' => 'bounties/index.php?site=logout');
if(!isset($_GET['site']) || $_GET['site'] == "") {
  $site = "index";
	include 'index.inc';
} else {
	$site = $_GET['site'];
  include $site . '.inc';
}

ConstructLayout();
?>
