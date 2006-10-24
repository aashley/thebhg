<?php
function title() {
	return 'Quote Archive :: Administration';
}

function auth($user) {
	$pos = $user->GetPosition();
	return ($user->GetID() == 666 || $pos->GetID() == 4 || $user->GetID() == 2344 || $user->GetID() == 94);
}

function output() {
	global $db, $roster, $page;

	menu_header();

	if ($_REQUEST['submit']) {
		if (mysql_query('INSERT INTO irc_quotes (speaker, quote, time) VALUES (' . $_REQUEST['speaker'] . ', "' . addslashes($_REQUEST['quote']) . '", UNIX_TIMESTAMP())', $db)) {
			echo 'Quote added successfully.';
		}
		else {
			echo 'Error adding quote: ' . mysql_error($db);
		}
	}
	else {
		$form = new Form($page);
		$form->StartSelect('Speaker:', 'speaker');
		$form->AddOption(696969, 'Non-BHG');
		hunter_dropdown($form);
		$form->EndSelect();
		$form->AddTextArea('Quote:', 'quote', '', 5, 50);
		$form->AddSubmitButton('submit', 'Add Quote');
		$form->EndForm();
	}

	quote_footer();
}
?>
