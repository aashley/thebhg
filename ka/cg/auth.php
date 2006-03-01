<?php
function auth() {
	$login = new Login_HTTP();
	$auth_info = array('user'=>&$login);
	$pos = $login->GetPosition();
	$div = $login->GetDivision();
	if ($pos->GetID() == 6 || $pos->GetID() == 8 || $pos->GetID() == 4 || $login->GetID() == 666) {
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
