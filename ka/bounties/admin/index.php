<?php
ini_set('include_path', '../objects:'.ini_get('include_path'));
require_once('../../Layout.inc');
require_once 'HTML/Table.php';

require_once 'ka.inc';
$ka = new KA('kabals-4ever');

$site = isset($_GET['site']) ? $_GET['site'] : '';
$subarray = array(
    'View Bounties'=>'bounties/',
    'Administration'=> ltrim($_SERVER['PHP_SELF'], "/"),
    'Statistics'=>ltrim($_SERVER['PHP_SELF'], "/").'?site=stats',
    'Post Bounty'=> ltrim($_SERVER['PHP_SELF'], "/").'?site=post_bounty'
    );
$login = new Login_HTTP();
$access = $ka->HasAccess($login->GetID());
if ($access == 0) {
    echo "Error, you are not allowed to access this page. You must be either TACT/U/WARD/CH/CRA to view this page.";
    ConstructLayout();
    exit;
}
if ($access == 2) {
    $subarray['Create New Bounty Type'] = ltrim($_SERVER['PHP_SELF'], "/").'?site=create_bountytype';
    $subarray['Manage Bounty Types'] = ltrim($_SERVER['PHP_SELF'], "/").'?site=manage_bountytype';
}
$login_position = $login->GetPosition();
$login_division = $login->GetDivision();
$login_division = $login_division->GetID();
if (!isset($_REQUEST['division'])) {
    //$division has not been set, setting defaults
    if ($access == 2) $division = -1;
    else $division = $login_division;
} else {
		if ($access == 2)
			$division = $_REQUEST['division'];
		else
			$division = $login_division;
}
$uploaddir = realpath(dirname($_SERVER['SCRIPT_FILENAME']).'/..').'/hunt_images/';
if($site == "") {
    $site = "index";
    include ("index.inc");
} else {
    include($site . ".inc");
}
ConstructLayout(); ?>
