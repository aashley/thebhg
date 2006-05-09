<?php
// Database table prefix.
$prefix = 'bb_';
$roster = new Roster('roster-69god');

function bb_header() {
}

function bb_footer() {
	global $prefix, $db;

	$sports_result = mysql_query("SELECT * FROM {$prefix}sports ORDER BY name ASC", $db);
	if ($sports_result && mysql_num_rows($sports_result)) {
		$items = array();
		while ($sport_row = mysql_fetch_array($sports_result)) {
			$items[stripslashes($sport_row['name'])] = internal_link('sport', array('id'=>$sport_row['id']));
		}
		addMenu('Sports', $items);
	}

}

function bb_admin_footer($valid) {

	$pages = array('admin_add_comp'=>'Add Competition', /*'admin_edit_comp'=>'Edit Competition', */'admin_del_comp'=>'Delete Competition', 'admin_set_winner'=>'Set Competition Winner', 'admin_league_wizard'=>'League Wizard');
	$items = array();
	foreach ($pages as $page=>$title) {
		$items[$title] = internal_link($page, array());
	}
	addMenu('Sport Options', $items);

	if ($valid['global']) {
		$pages = array('admin_add_sport'=>'Add Sport', 'admin_edit_sport'=>'Edit Sport', /*'admin_del_sport'=>'Delete Sport', */'admin_users'=>'Edit User List');
		$items = array();
		foreach ($pages as $page=>$title) {
			$items[$title] = internal_link($page, array());
		}
		addMenu('Global Options', $items);

		$pages = array('admin_add_faq_section'=>'Add FAQ Section', 'admin_edit_faq_section'=>'Edit FAQ Section', 'admin_delete_faq_section'=>'Delete FAQ Section');
		$items = array();
		foreach ($pages as $page=>$title) {
			$items[$title] = internal_link($page, array());
		}
		addMenu('FAQ Section Options', $items);

		$pages = array('admin_add_faq'=>'Add FAQ ', 'admin_edit_faq'=>'Edit FAQ ', 'admin_delete_faq'=>'Delete FAQ ');
		$items = array();
		foreach ($pages as $page=>$title) {
			$items[$title] = internal_link($page, array());
		}
		addMenu('FAQ Options', $items);
	}
	
}

function bb_get_sports($user) {
	global $prefix, $db;

	$pos = $user->GetPosition();
	if ($user->GetID() == 666 || $user->GetID() == 94 || $pos->GetID() == 2 || $pos->GetID() == 5 || $pos->GetID() == 4 | $user->getID() == 2650) {
		$sports_result = mysql_query("SELECT * FROM {$prefix}sports", $db);
		if ($sports_result && mysql_num_rows($sports_result)) {
			while ($sport_row = mysql_fetch_array($sports_result)) {
				$valid[] = $sport_row['id'];
			}
		}
		$valid['global'] = true;
	}
	else {
		$sports_result = mysql_query("SELECT * FROM {$prefix}users WHERE user=" . $user->GetID(), $db);
		if ($sports_result && mysql_num_rows($sports_result)) {
			while ($sport_row = mysql_fetch_array($sports_result)) {
				$valid[] = $sport_row['sport'];
			}
		}
		else {
			return false;
		}
	}

	return $valid;
}

function calculate_odds($decimal) {
	$decimal -= 1;
	if (floor($decimal) == $decimal) {
		return $decimal . '/1';
	}
	else {
		for ($d = 2; $d < 100; $d++) {
			$numerator = $d * $decimal;
			if (abs($numerator - floor($numerator)) < 0.01) {
				return $numerator . '/' . $d;
			}
		}
		return number_format($decimal * 100) . '/100';
	}
}

function parse_odds($odds) {
	if (strchr($odds, '/')) {
		$odds = explode('/', $odds);
		return ($odds[0] / $odds[1]) + 1.0;
	}
	else {
		return $odds;
	}
}
?>
