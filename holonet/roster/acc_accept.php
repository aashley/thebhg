<?php
function title() {
	return 'Arena Challenge Centre :: Accept Challenge';
}

function auth($pleb) {
	global $user, $roster;
	$user = $pleb;
	$div = $pleb->GetDivision();
	return ($div->GetID() != 0 && $div->GetID() != 16);
}

function output() {
	global $db, $page, $email_headers, $user, $roster, $lyarna_db;
	
	$cres = mysql_query('SELECT * FROM arena WHERE id=' . $_REQUEST['id'], $db);
	$crow = mysql_fetch_array($cres);

	$num_weapons = $crow['num_weapons'];
	$type_weapon = $crow['type_weapon'];
	$location = stripslashes($crow['location']);
	$post_count = $crow['post_count'];
	$rules = $crow['rules'];
	
	$weapon_result = mysql_fetch_array(mysql_query('SELECT weapon FROM arena_weapons WHERE id=' . $type_weapon, $db));
	$rule_result = mysql_fetch_array(mysql_query('SELECT * FROM arena_rules WHERE id=' . $rules, $db));

	$weapon_final = stripslashes($weapon_result['weapon']);
	$rule_final = stripslashes($rule_result['rule']);
	$rule_desc = stripslashes($rule_result['definition']);

	$pleb = $roster->GetPerson($crow['challenger']);

	mysql_query('UPDATE arena SET status=1 WHERE id=' . $_REQUEST['id'], $db);
	
	$message = $pleb->GetName() . ', your challenge to ' . $user->GetName() . " has been accepted. Here are the settings for the match:\n\nNumber of Weapons: $num_weapons\nWeapon Type: $weapon_final\nLocation: $location\nPost Count: $post_count\nRules: $rule_final - $rule_desc\n\nThe Overseer or Adjunct will contact you when all is in readiness for the fight.\n\nArena Challenge Centre";
	
	$mail[] = $pleb->GetEmail();
	if ($ov = $roster->SearchPosition(29)) {
		$mail[] = $ov[0]->GetEmail();
	}
	if ($aj = $roster->SearchPosition(9)) {
		$mail[] = $aj[0]->GetEmail();
	}
	mail(implode(', ', $mail), 'Your challenge has been accepted', $message, $email_headers);

	echo 'Your challenger has been informed of your decision. The Overseer or Adjunct will contact you when all is in readiness for your fight.';
}
?>
