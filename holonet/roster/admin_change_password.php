<?php
function title() {
	return 'Administration :: Change My Password';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return true;
}

function output() {
	global $auth_data, $pleb, $page;

	roster_header();

	if (empty($_REQUEST['submit'])) {
		$form = new Form($page);
		$form->AddPasswordBox('New Password:', 'password');
		$form->AddPasswordBox('Confirm Password:', 'confirm');
		$form->AddSubmitButton('submit', 'Save Password');
		$form->EndForm();
	}
	else {
		if ($_REQUEST['password'] != '') {
			if ($_REQUEST['password'] == $_REQUEST['confirm']) {
				if ($pleb->SetPassword($_REQUEST['password'])) {
					echo 'Password changed.';
				}
				else {
					echo 'Error changing password: ' . $pleb->Error();
				}
			}
			else {
				echo 'The passwords given do not match.';
			}
		}
		else {
			echo 'You cannot set a blank password.';
		}
	}
	
	admin_footer($auth_data);
}
?>
