<?php

include_once('../header.php');
include_once('../../Layout.inc');

$pos = $login->GetPosition();
$sql = "SELECT `id` FROM `assistant` WHERE `person` = ".$login->getID()." AND `date_deleted` = 0 AND `om` = 1";
if ($login->GetID() == 666 || $login->GetID() == 2650 || $pos->GetID() == 3 || mysql_num_rows(mysql_query($sql, $kadb))) {
	$subarray = array(
		'New Mission'=>'om/administration/?op=add',
		'Delete Mission'=>'om/administration/?op=del',
		'Edit A Mission'=>'om/administration/?op=choose',
		'Conceal Set'=>'om/administration/?op=hide',
		'Release Set'=>'om/administration/?op=unhide',
		'View Concealed Missions'=>'om/administration/concealed.php',
		'Mark a Mission'=>'om/administration/?op=choosemark',
		'Process Awards'=>'om/administration/?op=selectom',
		'Online Mission Home'=>'om/index.php'
	);
} else {
	$subarray = array(
		'Online Mission Home'=>'om/index.php'
	);
}

?>