<?php
function title() {
	return 'Arena Challenge Centre :: Confirm Challenge';
}

function auth($pleb) {
	global $user, $roster;
	$user = $pleb;
	$div = $pleb->GetDivision();
	return ($div->GetID() != 0 && $div->GetID() != 16);
}

function output() {
	global $db, $page, $email_headers, $user, $roster, $lyarna_db;
	
	if ($_REQUEST['challengee'] != $user->GetID()) {
		$pleb = $roster->GetPerson($_REQUEST['challengee']);
		$num_weapons = (int) $_REQUEST['num_weapons'];
		$type_weapon = (int) $_REQUEST['type_weapon'];
		$location = $_REQUEST['location'];
		$post_count = (int) $_REQUEST['post_count'];
		$rules = (int) $_REQUEST['rules'];

		$get_weapon_type = mysql_query('SELECT weapon FROM arena_weapons WHERE id=' . $type_weapon, $db);
		$weapon_result = mysql_fetch_array($get_weapon_type);

		$get_rule_type = mysql_query('SELECT * FROM arena_rules WHERE id=' . $rules, $db);
		$rule_result = mysql_fetch_array($get_rule_type);

		$weapon_final = stripslashes($weapon_result['weapon']);
		$rule_final = stripslashes($rule_result['rule']);
		$rule_desc = stripslashes($rule_result['definition']);

		if (mysql_query('INSERT INTO arena (challenger, challengee, challenge_time, num_weapons, type_weapon, location, post_count, rules) VALUES (' . $user->GetID() . ', ' . $pleb->GetID() . ', UNIX_TIMESTAMP(), ' . $num_weapons . ', ' . $type_weapon . ', "' . addslashes($location) . '", ' . $post_count . ', ' . $rules . ')', $db)) {
			$message = $pleb->GetName() . ', you have been challenged to a fight at the Arena by ' . $user->GetName() . " with the following settings:\n\nNumber of Weapons: $num_weapons\nWeapon Type: $weapon_final\nLocation: $location\nPost Count: $post_count\nRules: $rule_final - $rule_desc\n\nYou may accept or decline this challenge at the Arena Challenge Centre, which you can find at http://" . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . "\n\nArena Challenge Centre";
			mail($pleb->GetEmail(), 'You have been challenged!', $message, $email_headers);
			echo $pleb->GetName() . ' has been informed of your challenge via e-mail. You will be notified with they accept or decline your challenge.<br><br><a href="' . internal_link('acc') . '">Return to the Arena Challenge Centre</a>';
		}
		else {
			echo 'There was an error making the challenge: ' . mysql_error($db);
		}
	}
	else {
		echo 'You want to challenge yourself to a fight? How... interesting.';
	}
}
?>
