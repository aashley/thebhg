<?php
function auth() {
	global $db;
	$login = new Login_HTTP();
	$auth_info = array('user'=>&$login);
	$pos = $login->GetPosition();
	$div = $login->GetDivision();
	$sql = "SELECT `id` FROM `assistant` WHERE `person` = ".$login->getID()." AND `date_deleted` = 0 AND `cg` = 1";
	if ($pos->GetID() == 3 || $login->GetID() == 666 || $login->GetID() == 2650 || mysql_num_rows(mysql_query($sql, $db))) {
		$auth_info['level'] = 3;
	}
	elseif ($login->IsCadreLeader()) {
		$auth_info['level'] = 2;
	}
	else {
		$auth_info['level'] = 0;
	}
	return $auth_info;
}
?>
