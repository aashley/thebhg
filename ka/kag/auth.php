<?php
function auth() {
	$login = new Login_HTTP();
	$auth_info = array('user'=>&$login);
	$pos = $login->GetPosition();
	$div = $login->GetDivision();
	if ($pos->GetID() == 6 || $pos->GetID() == 8 || $login->GetID() == 666 || $login->GetID() == 2650) {
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
