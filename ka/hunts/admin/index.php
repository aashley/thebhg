<?php
require_once('../../Layout.inc');
require_once 'HTML/Table.php';
$site = $_GET['site'];
$subarray = array(
    'View Hunts'=>'hunts/',
    'Hunt Administration'=> ltrim($_SERVER['PHP_SELF'], "/"),
    'Hunt Statistics'=>ltrim($_SERVER['PHP_SELF'], "/").'?site=stats',
    'Create New Hunt'=> ltrim($_SERVER['PHP_SELF'], "/").'?site=create_hunt'
    );
$login = new Login_HTTP();
$access = $ka->HasAccess($login->GetID());
if ($access == 0) {
    echo "Error, you are not allowed to access this page. You must be either SP/X/JUD/PR/U/WARD/CH/CRA to view this page.";
    ConstructLayout();
    exit;
}
if ($access == 2) {
    $subarray['Create New Hunt Type'] = ltrim($_SERVER['PHP_SELF'], "/").'?site=create_hunttype';
    $subarray['Manage Hunt Types'] = ltrim($_SERVER['PHP_SELF'], "/").'?site=manage_hunttype';
}
$login_position = $login->GetPosition();
$login_division = $login->GetDivision();
$login_division = $login_division->GetID();
if (!$_POST['division']) {
    //$division has not been set, setting defaults
    if ($access == 2) $division = -1;
    else $division = $login_division;
} else {
    $division = $_POST['division'];
}
$uploaddir = realpath(dirname($_SERVER['SCRIPT_FILENAME']).'/..').'/hunt_images/';
if($site == "") {
    $site = "index";
    include ("index.inc");
} else {
    include($site . ".inc");
}
ConstructLayout(); ?>
