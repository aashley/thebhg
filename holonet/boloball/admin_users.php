<?php
if ($_REQUEST['id']) {
	$result = mysql_query("SELECT * FROM {$prefix}sports WHERE id=" . $_REQUEST['id'], $db);
	$row = mysql_fetch_array($result);
}

function title() {
	global $row;
	
	$title = 'Administration :: Edit User List';
	if (isset($row)) {
		$title .= ' :: ' . stripslashes($row['name']);
	}
	return $title;
}

function auth($user) {
	global $valid;

	$valid = bb_get_sports($user);
	return $valid;
}

function output() {
	global $prefix, $db, $valid, $row, $page;

	bb_header();

	if (isset($row)) {
		if ($_REQUEST['user']) {
			mysql_query("DELETE FROM {$prefix}users WHERE sport=" . $_REQUEST['id'], $db);
			foreach ($_REQUEST['user'] as $pleb) {
				mysql_query("INSERT INTO {$prefix}users (user, sport) VALUES ($pleb, " . $_REQUEST['id'] . ')', $db);
			}
			echo 'User list saved.';
		}
		else {
			$user_result = mysql_query("SELECT * FROM {$prefix}users WHERE sport=" . $_REQUEST['id'], $db);
			if ($user_result && mysql_num_rows($user_result)) {
				while ($user_row = mysql_fetch_array($user_result)) {
					$select[] = $user_row['user'];
				}
			}
			else {
				$select = false;
			}
			
			$form = new Form($page);
			$form->AddHidden('id', $_REQUEST['id']);
			$form->StartSelect('Add User(s):', 'user[]', $select, 10, true);
			hunter_dropdown($form);
			$form->EndSelect();
			$form->AddSubmitButton('', 'Save User List');
			$form->EndForm();
		}
	}
	else {
		$form = new Form($page, 'get');
		$form->StartSelect('Sport:', 'id');
		$sports_result = mysql_query("SELECT * FROM {$prefix}sports ORDER BY name ASC", $db);
		if ($sports_result && mysql_num_rows($sports_result)) {
			while ($sport_row = mysql_fetch_array($sports_result)) {
				$form->AddOption($sport_row['id'], stripslashes($sport_row['name']));
			}
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit User List');
		$form->EndForm();
	}

	bb_admin_footer($valid);
}
?>
