<?php

include_once('../header.php');
include_once('../../Layout.inc');

$login = new Login_HTTP();

$pos = $login->GetPosition();
$sql = "SELECT `id` FROM `assistant` WHERE `person` = ".$login->getID()." AND `date_deleted` = 0 AND `ladder` = 1";
if ($login->GetID() == 2650 || $pos->GetID() == 3 || mysql_num_rows(mysql_query($sql, $db->ka_db))) {
	$GLOBALS['access'] = true;
	$subarray = array(
		'Process Ladder Awards'=>'ladder/administration/award.php',
		'Process Season Awards'=>'ladder/administration/season.php',
		'Ladder Home'=>'ladder/index.php'
	);
} else {
	$GLOBALS['access'] = false;
	$subarray = array(
		'Ladder Home'=>'ladder/index.php'
	);
}

?>