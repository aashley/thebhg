<?php
function auth() {
	global $db;
	$login = new Login_HTTP();
	$auth_info = array('user'=>&$login);
	$pos = $login->GetPosition();
	$div = $login->GetDivision();
	$sql = "SELECT `id` FROM `assistant` WHERE `person` = ".$login->getID()." AND `date_deleted` = 0 AND `kg` = 1";
	if ($pos->getID() == 3 || $login->GetID() == 666 || $login->GetID() == 2650 || mysql_num_rows(mysql_query($sql, $db))) {
		$auth_info['level'] = 3;
	}
	elseif ($pos->GetID() == 11 || $pos->GetID() == 12) {
		$auth_info['level'] = 2;
	}
	elseif ($div->IsKabal()) {
		$auth_info['level'] = 1;
	}
	else {
		$auth_info['level'] = 0;
	}
	return $auth_info;
}
?>
