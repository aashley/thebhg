<?php
function title() {
	return 'Administration :: Edit Kabal Details';
}

function auth($person) {
	global $auth_data, $div;

	$auth_data = get_auth_data($person);
	$div = $person->GetDivision();
	return ($auth_data['underlord'] || $auth_data['chief']);
}

function output() {
	global $auth_data, $div, $roster, $page;

	roster_header();

	if ($_REQUEST['submit']) {
		$kabal = $roster->GetKabal($_REQUEST['division']);
		$kabal->SetSlogan($_REQUEST['slogan']);
		$kabal->SetURL($_REQUEST['url']);
		$kabal->SetWelcomeMessage($_REQUEST['welcome']);

		echo 'Kabal details saved.';
	}
	elseif ($_REQUEST['division'] || $div->IsKabal()) {
		if ($_REQUEST['division']) {
			$kabal = $roster->GetKabal($_REQUEST['division']);
		}
		else {
			$kabal = $roster->GetKabal($div->GetID());
		}

		$form = new Form($page);
		$form->AddHidden('division', $kabal->GetID());
		$form->AddTextBox('Slogan:', 'slogan', $kabal->GetSlogan(), 40);
		$form->AddTextBox('Home Page:', 'url', $kabal->GetURL(), 40);
		$form->AddTextArea('Welcome Message:<br>(Read notes below.)', 'welcome', $kabal->GetWelcomeMessage(), 10, 60);
		$form->AddSubmitButton('submit', 'Save Kabal Details');
		$form->EndForm();

		hr();
		
		echo <<<EOH
The following substitutions are available in welcome messages:<br><br>
%hunter_name% : The new hunter's name<br>
%chief_name% : The chief's name<br>
%chief_email% : The chief's e-mail address<br>
%chief_idline% : The chief's ID line<br><br>
The welcome message will be sent to every new kabal member unless left blank, in which case it will be disabled. To use the substitutions, simply put them in the text of the e-mail as they appear here. A sample welcome message might look like the following:<br><br>
<i>Dear %hunter_name%<br><br>
Welcome to Foobar Kabal. I am your chief, %chief_name%, and can be contacted with any questions you may have at %chief_email%. You can find more information on BHG activities at http://www.thebhg.org/.... blah blah welcome-cakes.<br><br>
Yours<br><br>
%chief_idline%</i>
EOH;
	}
	else {
		$form = new Form($page, 'get');
		$form->StartSelect('Select the Kabal to edit:', 'division');
		$kabals = $roster->GetKabals();
		foreach ($kabals as $kabal) {
			$form->AddOption($kabal->GetID(), $kabal->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit Kabal Details');
		$form->EndForm();
	}

	admin_footer($auth_data);
}
?>
