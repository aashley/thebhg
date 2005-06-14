<?php
function title() {
	return 'Administration :: E-Mail Cadre Members';
}

function auth($person) {
	global $auth_data, $cadre, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
  $cadre = $pleb->GetCadre();

  return ($auth_data['cadre-leader']);
}

function output() {
	global $auth_data, $cadre, $pleb, $roster, $page;

	roster_header();
	
	if (empty($_REQUEST['submit'])) {
		$names = array();
		foreach ($cadre->GetMembers() as $member)
			$names[] = htmlspecialchars($member->GetName());
		
		$form = new Form($page);
		$form->table->AddRow('To:', 'Members of '.htmlspecialchars($cadre->GetName()).': '.implode('; ', $names));
		$form->AddTextBox('Subject:', 'subject', '', 40);
  	$form->AddTextArea('Message:', 'message', '', 15, 72);
	  $form->AddSubmitButton('submit', 'Send E-Mail');
		$form->EndForm();
	}
	else {
		foreach ($cadre->GetMembers() as $member) {
			$member->SendEmail($pleb->GetName().' <'.$pleb->GetEmail().'>', $_POST['subject'], $_POST['message']);
		}
		
		echo 'E-mail sent.';
	}
	
	admin_footer($auth_data);
}
?>
