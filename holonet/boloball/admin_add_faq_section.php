<?php
function title() {
	return 'Add FAQ Section';
}

function auth($pleb) {
	global $valid, $user, $roster;

	$valid = bb_get_sports($pleb);
	$user = $roster->GetPerson($pleb->GetID());
	return $valid['global'];
}

function output() {
	global $db, $page, $prefix, $user, $valid;

	bb_header();

	if (empty($_REQUEST['name'])) {
		$form = new Form($page, 'post');
		$form->AddTextBox('Name:', 'name');
		$form->StartSelect('Position:', 'after');
		$form->AddOption(0, 'At start');
		$sec_result = mysql_query('SELECT * FROM '.$prefix.'faq_sections ORDER BY after ASC', $db);
		while ($sec = mysql_fetch_array($sec_result)) {
			$form->AddOption($sec['id'], stripslashes($sec['name']));
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Add Section');
		$form->EndForm();

	}
	else {
		$name = addslashes($_REQUEST['name']);
		$after = $_REQUEST['after'] ? $_REQUEST['after'] : '0';
		if (mysql_query('INSERT INTO '.$prefix."faq_sections (name, after) VALUES ('$name', $after)", $db)) {
			if ($after == '0') {
				$ns_id = mysql_insert_id($db);
				mysql_query('UPDATE '.$prefix."faq_sections SET after=$ns_id WHERE after=0 AND id<>$ns_id", $db);
			}
			echo 'Section added.';
		}
		else {
			echo 'Error adding section: ' . mysql_error($db);
		}
	}

	bb_admin_footer($valid);
}
?>
