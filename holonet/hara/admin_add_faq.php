<?php
function title() {
	return 'Add FAQ';
}

function auth($pleb) {
	global $roster, $user;

	$user = $roster->GetPerson($pleb->GetID());
	return is_global_admin($user);
}

function output() {
	global $db, $page, $prefix, $user;

	admin_header();
	
	if (empty($_REQUEST['section'])) {
		$form = new Form($page, 'post');
		$form->StartSelect('Section:', 'section');
		$form->AddOption(0, 'At start');
		$sec_result = mysql_query('SELECT * FROM '.$prefix.'faq_sections ORDER BY after ASC', $db);
		while ($sec = mysql_fetch_array($sec_result)) {
			$form->AddOption($sec['id'], stripslashes($sec['name']));
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Add FAQ');
		$form->EndForm();
	}
	elseif (empty($_REQUEST['question'])) {
		$form = new Form($page, 'post');
		$form->AddHidden('section', $_REQUEST['section']);
		$form->AddTextBox('Question:', 'question', '', 40);
		$form->AddTextArea('Answer:', 'answer', '', 5, 60);
		$form->StartSelect('Position:', 'after');
		$sec_result = mysql_query('SELECT * FROM '.$prefix."faq WHERE section=" . $_REQUEST['section'] . " ORDER BY after ASC", $db);
		while ($sec = mysql_fetch_array($sec_result)) {
			$form->AddOption($sec['id'], 'After ' . stripslashes($sec['question']));
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Add Question');
		$form->EndForm();
	}
	else {
		$question = addslashes($_REQUEST['question']);
		$answer = addslashes($_REQUEST['answer']);
		$after = $_REQUEST['after'] ? $_REQUEST['after'] : '0';
		$section = $_REQUEST['section'];
		if (mysql_query('INSERT INTO '.$prefix."faq (section, question, answer, after) VALUES ($section, '$question', '$answer', $after)", $db)) {
			if ($after == '0') {
				$ns_id = mysql_insert_id($db);
				mysql_query('UPDATE '.$prefix."faq SET after=$ns_id WHERE after=0 AND id<>$ns_id AND section=$section", $db);
			}
			echo 'Question added.';
		}
		else {
			echo 'Error adding question: ' . mysql_error($db);
		}
	}

	admin_footer($user);
}
?>
