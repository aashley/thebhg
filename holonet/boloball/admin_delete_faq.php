<?php
function title() {
	return 'Delete FAQ';
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
	
	if (empty($_REQUEST['id'])) {
		$form = new Form($page);
		$form->StartSelect('Question:', 'id');
		$faq = $prefix.'faq';
		$fs = $prefix.'faq_sections';
		$sec_result = mysql_query("SELECT $fs.name, $faq.question, $faq.id FROM $faq, $fs WHERE $faq.section=$fs.id ORDER BY $fs.after ASC, $faq.after ASC", $db);
		while ($sec = mysql_fetch_array($sec_result)) {
			$form->AddOption($sec['id'], stripslashes($sec['name'] . ': ' . $sec['question']));
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Delete Question');
		$form->EndForm();
	}
	else {
		$s_result = mysql_query('SELECT * FROM '.$prefix."faq WHERE id=" . $_REQUEST['id'], $db);
		$oa = mysql_result($s_result, 0, 'after');
		$oa = $oa ? "$oa" : '0';
		$section = mysql_result($s_result, 0, 'section');
		if (mysql_query('DELETE FROM '.$prefix."faq WHERE id=" . $_REQUEST['id'], $db)) {
			mysql_query('UPDATE '.$prefix."faq SET after=$oa WHERE after=" . $_REQUEST['id'] . " AND section=$section", $db);
			echo 'Question deleted.';
		}
		else {
			echo 'Error deleting question: ' . mysql_error($db);
		}
	}

	bb_admin_footer($valid);
}
?>
