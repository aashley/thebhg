<?php
function title() {
	return 'Administration :: Edit My Details';
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
	if (empty($_REQUEST['name'])) {
		$form = new Form($page);
    $form->AddSectionTitle('Person Details');
		$form->AddTextBox('Name:', 'name', $pleb->GetName());
		$form->AddTextBox('Home Page:', 'homepage', $pleb->GetHomePage(), 40);
    $form->AddSectionTitle('Contact Details');
		$form->AddTextBox('E-Mail Address:', 'email', $pleb->GetEmail());
    $form->AddTextBox('AIM Screen Name:', 'aim', $pleb->GetAIM());
    $form->AddTextBox('ICQ Number:', 'icq', $pleb->GetICQ());
		$form->AddTextBox('IRC Nicknames:', 'nicks', $pleb->GetIRCNicks());
    $form->AddTextBox('Jabber ID:', 'jabber', $pleb->GetJabber());
    $form->AddTextBox('MSN Passport Name:', 'msn', $pleb->GetMSN());
    $form->AddTextBox('Yahoo Messager ID:', 'yahoo', $pleb->GetYahoo());
    $form->AddSectionTitle('Other Details');
		$form->AddTextArea('Quote:', 'quote', $pleb->GetQuote());
		$form->AddSubmitButton('', 'Save Details');
		$form->EndForm();

		hr();

		echo 'Note: There is a 40 character limit on names. Characters beyond the 40 character limit will be ignored.';
	}
	else {
		if ($pleb->GetName() != $_REQUEST['name']) {
			if ($pleb->SetName(substr($_REQUEST['name'], 0, 40))) {
				echo 'Name saved.<br>';
			}
			else {
				echo 'Error saving name: ' . $pleb->Error() . '<br>';
			}
		}
		if ($pleb->GetEmail() != $_REQUEST['email']) {
			if ($pleb->SetEmail($_REQUEST['email'])) {
				echo 'E-mail address saved.<br>';
			}
			else {
				echo 'Error saving e-mail address: ' . $pleb->Error() . '<br>';
			}
		}
		if ($pleb->GetHomePage() != $_REQUEST['homepage']) {
			if ($pleb->SetHomePage($_REQUEST['homepage'])) {
				echo 'Home page saved.<br>';
			}
			else {
				echo 'Error saving home page: ' . $pleb->Error() . '<br>';
			}
		}
		if ($pleb->GetIRCNicks() != $_REQUEST['nicks']) {
			if ($pleb->SetIRCNicks($_REQUEST['nicks'])) {
				echo 'IRC nicks saved.<br>';
			}
			else {
				echo 'Error saving IRC nicks: ' . $pleb->Error() . '<br>';
			}
		}
		if ($pleb->GetQuote() != $_REQUEST['quote']) {
			if ($pleb->SetQuote($_REQUEST['quote'])) {
				echo 'Quote saved.<br>';
			}
			else {
				echo 'Error saving quote: ' . $pleb->Error() . '<br>';
			}
		}
		if ($pleb->GetAIM() != $_REQUEST['aim']) {
			if ($pleb->SetAIM($_REQUEST['aim'])) {
				echo 'AIM saved.<br>';
			}
			else {
				echo 'Error saving AIM: ' . $pleb->Error() . '<br>';
			}
		}
		if ($pleb->GetICQ() != $_REQUEST['icq']) {
			if ($pleb->SetICQ($_REQUEST['icq'])) {
				echo 'ICQ saved.<br>';
			}
			else {
				echo 'Error saving ICQ: ' . $pleb->Error() . '<br>';
			}
		}
		if ($pleb->GetJabber() != $_REQUEST['jabber']) {
			if ($pleb->SetJabber($_REQUEST['jabber'])) {
				echo 'Jabber saved.<br>';
			}
			else {
				echo 'Error saving Jabber: ' . $pleb->Error() . '<br>';
			}
		}
		if ($pleb->GetMSN() != $_REQUEST['msn']) {
			if ($pleb->SetMSN($_REQUEST['msn'])) {
				echo 'MSN saved.<br>';
			}
			else {
				echo 'Error saving MSN: ' . $pleb->Error() . '<br>';
			}
		}
		if ($pleb->GetYahoo() != $_REQUEST['yahoo']) {
			if ($pleb->SetYahoo($_REQUEST['yahoo'])) {
				echo 'Yahoo saved.<br>';
			}
			else {
				echo 'Error saving Yahoo: ' . $pleb->Error() . '<br>';
			}
		}
	}
	admin_footer($auth_data);
}
?>
