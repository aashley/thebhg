<?php
function title() {
	return 'Edit FAQ';
}

function auth($pleb) {
	global $roster, $user;

	$user = $roster->GetPerson($pleb->GetID());
	return is_global_admin($user);
}

function output() {
	global $db, $page, $prefix, $user;

	admin_header();
	
	if (empty($_REQUEST['id'])) {
		$form = new Form($page, 'get');
		$form->StartSelect('Question:', 'id');
		$faq = $prefix.'faq';
		$fs = $prefix.'faq_sections';
		$sec_result = mysql_query("SELECT $fs.name, $faq.question, $faq.id FROM $faq, $fs WHERE $faq.section=$fs.id ORDER BY $fs.after ASC, $faq.after ASC", $db);
		while ($sec = mysql_fetch_array($sec_result)) {
			$form->AddOption($sec['id'], stripslashes($sec['name']));
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit Question');
		$form->EndForm();
	}
	elseif (empty($_REQUEST['question'])) {
		$s_result = mysql_query('SELECT * FROM '.$prefix."faq WHERE id=" . $_REQUEST['id'], $db);
		$s = mysql_fetch_array($s_result);
		$form = new Form($page);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextBox('Question:', 'question', stripslashes($s['question']), 40);
		$form->AddTextArea('Answer:', 'answer', stripslashes($s['answer']), 5, 60);
		$form->StartSelect('Position:', 'after', $s['after']);
		$form->AddOption(0, 'At start');
		$sec_result = mysql_query('SELECT * FROM '.$prefix.'faq WHERE section=' . $s['section'] . ' ORDER BY after ASC', $db);
		while ($sec = mysql_fetch_array($sec_result)) {
			if ($sec['id'] != $_REQUEST['id']) {
				$form->AddOption($sec['id'], 'After ' . stripslashes($sec['question']));
			}
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Save Question');
		$form->EndForm();
	}
	else {
		$s_result = mysql_query('SELECT * FROM '.$prefix."faq WHERE id=" . $_REQUEST['id'], $db);
		$oa = mysql_result($s_result, 0, 'after');
		$oa = $oa ? "$oa" : '0';
		$section = mysql_result($s_result, 0, 'section');
		$question = addslashes($_REQUEST['question']);
		$answer = addslashes($_REQUEST['answer']);
		if ($_REQUEST['after'] == $_REQUEST['id']) {
			$after = $oa;
		}
		$after = $_REQUEST['after'] ? $_REQUEST['after'] : '0';
		if (mysql_query('UPDATE '.$prefix."faq SET question='$question', answer='$answer', after=$after WHERE id=" . $_REQUEST['id'], $db)) {
			if ($oa != $after) {
				mysql_query('UPDATE '.$prefix."faq SET after=$oa WHERE after=" . $_REQUEST['id'] . " AND section=$section", $db);
			}
			echo 'Question saved.';
		}
		else {
			echo 'Error saving question: ' . mysql_error($db);
		}
	}

	admin_footer($user);
}
?>
