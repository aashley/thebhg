<?php
function lookup_auth_level($user) {
	$pos = $user->GetPosition();
	$div = $user->GetDivision();

	// Does the user hold one of the positions required for global access?
	if ($div->GetID() == 10 || $div->GetID() == 9) {
		$auth_level = 2;
	}
	// How about being a special user?
	elseif ($user->GetID() == 94 || $user->GetID() == 666) {
		$auth_level = 2;
	}
	// OK, if not, is this person able to post news?
	elseif ($pos->GetID() == 10 || $pos->GetID() == 11 || $pos->GetID() == 12) {
		$auth_level = 1;
	}
	// Well then, I guess this person can't do anything, and we should
	// probably kick them out.
	else {
		$auth_level = 0;
	}

	return $auth_level;
}

function check_auth($user, $required) {
	return (lookup_auth_level($user) >= $required);
}
?>
