<?php
include_once('Text/Password.php');

function title() {
	return 'Lost Password';
}

function output() {
	global $roster, $page;

	roster_header();

	if (isset($_POST['id'])) {
		$pleb = $roster->GetPerson($_POST['id']);
		
		if (isset($_POST['confirm'])) {
			$password = Text_Password::create();
			$pleb->SetPassword($password);
			echo 'The password has been changed successfully.';
		}
		else {
			echo 'Are you sure you wish to reset the password for ' . $pleb->GetName() . '?';
			$form = new Form($page, 'post');
			$form->AddHidden('id', $_POST['id']);
			$form->AddSubmitButton('confirm', 'Yes');
			$form->EndForm();
		}
	}
	else {
		echo 'This page will reset the password for the given roster ID and e-mail a new password to the address listed on the Holonet for that person. If the e-mail address on the Holonet is incorrect and you need a password reset, please contact the Underlord.';

		hr();
		
		$form = new Form($page, 'post');
		$form->AddTextBox('Roster ID:', 'id', '', 5);
		$form->AddSubmitButton('', 'Reset Password');
		$form->EndForm();
	}
}
?>
