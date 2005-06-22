<?php
function title() {
	return 'Administration :: Edit Hunter Details';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return $auth_data['underlord'];
}

function output() {
	global $auth_data, $pleb, $page, $roster;

	roster_header();
	if (isset($_REQUEST['id'])) {
		$hunter = $roster->GetPerson($_REQUEST['id']);
		
		if (empty($_REQUEST['name'])) {
			$form = new Form($page);
			$form->AddHidden('id', $hunter->GetID());
			$form->AddSectionTitle('Person Details');
			$form->AddTextBox('Name:', 'name', $hunter->GetName());
			$form->AddTextBox('Home Page:', 'homepage', $hunter->GetHomePage(), 40);
			$form->AddSectionTitle('Contact Details');
			$form->AddTextBox('E-Mail Address:', 'email', $hunter->GetEmail());
			$form->AddTextBox('AIM Screen Name:', 'aim', $hunter->GetAIM());
			$form->AddTextBox('ICQ Number:', 'icq', $hunter->GetICQ());
			$form->AddTextBox('IRC Nicknames:', 'nicks', $hunter->GetIRCNicks());
			$form->AddTextBox('Jabber ID:', 'jabber', $hunter->GetJabber());
			$form->AddTextBox('MSN Passport Name:', 'msn', $hunter->GetMSN());
			$form->AddTextBox('Yahoo Messager ID:', 'yahoo', $hunter->GetYahoo());
			$form->AddSectionTitle('Other Details');
			$form->AddTextArea('Quote:', 'quote', $hunter->GetQuote());
			$form->AddSectionTitle('Password');
			$form->AddTextBox('New Password:', 'password');
			$form->AddTextBox('Confirm Password:', 'confirm');
			$form->AddSubmitButton('', 'Save Details');
			$form->EndForm();

			hr();

			echo 'Note: There is a 40 character limit on names. Characters beyond the 40 character limit will be ignored.';
		}
		else {
			if ($hunter->GetName() != $_REQUEST['name']) {
				if ($hunter->SetName(substr($_REQUEST['name'], 0, 40))) {
					echo 'Name saved.<br>';
				}
				else {
					echo 'Error saving name: ' . $hunter->Error() . '<br>';
				}
			}
			if ($hunter->GetEmail() != $_REQUEST['email']) {
				if ($hunter->SetEmail($_REQUEST['email'])) {
					echo 'E-mail address saved.<br>';
				}
				else {
					echo 'Error saving e-mail address: ' . $hunter->Error() . '<br>';
				}
			}
			if ($hunter->GetHomePage() != $_REQUEST['homepage']) {
				if ($hunter->SetHomePage($_REQUEST['homepage'])) {
					echo 'Home page saved.<br>';
				}
				else {
					echo 'Error saving home page: ' . $hunter->Error() . '<br>';
				}
			}
			if ($hunter->GetIRCNicks() != $_REQUEST['nicks']) {
				if ($hunter->SetIRCNicks($_REQUEST['nicks'])) {
					echo 'IRC nicks saved.<br>';
				}
				else {
					echo 'Error saving IRC nicks: ' . $hunter->Error() . '<br>';
				}
			}
			if ($hunter->GetQuote() != $_REQUEST['quote']) {
				if ($hunter->SetQuote($_REQUEST['quote'])) {
					echo 'Quote saved.<br>';
				}
				else {
					echo 'Error saving quote: ' . $hunter->Error() . '<br>';
				}
			}
			if ($hunter->GetAIM() != $_REQUEST['aim']) {
				if ($hunter->SetAIM($_REQUEST['aim'])) {
					echo 'AIM saved.<br>';
				}
				else {
					echo 'Error saving AIM: ' . $hunter->Error() . '<br>';
				}
			}
			if ($hunter->GetICQ() != $_REQUEST['icq']) {
				if ($hunter->SetICQ($_REQUEST['icq'])) {
					echo 'ICQ saved.<br>';
				}
				else {
					echo 'Error saving ICQ: ' . $hunter->Error() . '<br>';
				}
			}
			if ($hunter->GetJabber() != $_REQUEST['jabber']) {
				if ($hunter->SetJabber($_REQUEST['jabber'])) {
					echo 'Jabber saved.<br>';
				}
				else {
					echo 'Error saving Jabber: ' . $hunter->Error() . '<br>';
				}
			}
			if ($hunter->GetMSN() != $_REQUEST['msn']) {
				if ($hunter->SetMSN($_REQUEST['msn'])) {
					echo 'MSN saved.<br>';
				}
				else {
					echo 'Error saving MSN: ' . $hunter->Error() . '<br>';
				}
			}
			if ($hunter->GetYahoo() != $_REQUEST['yahoo']) {
				if ($hunter->SetYahoo($_REQUEST['yahoo'])) {
					echo 'Yahoo saved.<br>';
				}
				else {
					echo 'Error saving Yahoo: ' . $hunter->Error() . '<br>';
				}
			}
			if (strlen($_POST['password']) > 0) {
				if ($_POST['password'] == $_POST['confirm']) {
					if ($hunter->SetPassword($_POST['password']))
						echo 'Password changed.<br>';
					else
						echo 'Error saving password: ' . $hunter->Error() . '<br>';
				}
				else
					echo 'Passwords do not match.<br>';
			}
		}
	}
	elseif (isset($_GET['division'])) {
		$div = $roster->GetDivision($_GET['division']);
		
		$form = new Form($page);
		$form->AddSectionTitle('Select Hunter');
		$form->StartSelect('Hunter:', 'id');
		foreach ($div->GetMembers('name') as $hunter)
			$form->AddOption($hunter->GetID(), $hunter->GetName());
		$form->EndSelect();
		$form->AddSubmitButton('', 'Next >>');
		$form->EndForm();
	}
	else {
		$form = new Form($page, 'get');
		$form->AddSectionTitle('Select Division');
		$form->StartSelect('Division:', 'division');
		foreach ($roster->GetDivisions() as $div)
			$form->AddOption($div->GetID(), $div->GetName());
		$form->EndSelect();
		$form->AddSubmitButton('', 'Next >>');
		$form->EndForm();
	}
	
	admin_footer($auth_data);
}
?>
