<?php
function title() {
	return 'Edit FAQ Section';
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
		$form->StartSelect('Section:', 'id');
		$sec_result = mysql_query('SELECT * FROM '.$prefix.'faq_sections ORDER BY after ASC', $db);
		while ($sec = mysql_fetch_array($sec_result)) {
			$form->AddOption($sec['id'], stripslashes($sec['name']));
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit Section');
		$form->EndForm();
	}
	elseif (empty($_REQUEST['name'])) {
		$s_result = mysql_query('SELECT * FROM '.$prefix."faq_sections WHERE id=" . $_REQUEST['id'], $db);
		$s = mysql_fetch_array($s_result);
		$form = new Form($page);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextBox('Name:', 'name', stripslashes($s['name']));
		$form->StartSelect('Position:', 'after', $s['after']);
		$form->AddOption(0, 'At start');
		$sec_result = mysql_query('SELECT * FROM '.$prefix.'faq_sections ORDER BY after ASC', $db);
		while ($sec = mysql_fetch_array($sec_result)) {
			if ($sec['id'] != $_REQUEST['id']) {
				$form->AddOption($sec['id'], 'After ' . stripslashes($sec['name']));
			}
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Save Section');
		$form->EndForm();
	}
	else {
		$s_result = mysql_query('SELECT * FROM '.$prefix."faq_sections WHERE id=" . $_REQUEST['id'], $db);
		$oa = mysql_result($s_result, 0, 'after');
		$oa = $oa ? "$oa" : '0';
		$name = addslashes($_REQUEST['name']);
		if ($after == $_REQUEST['id']) {
			$after = $oa;
		}
		$after = $_REQUEST['after'] ? $_REQUEST['after'] : '0';
		if (mysql_query('UPDATE '.$prefix."faq_sections SET name='$name', after=$after WHERE id=" . $_REQUEST['id'], $db)) {
			if ($oa != $after) {
				mysql_query('UPDATE '.$prefix."faq_sections SET after=$oa WHERE after=" . $_REQUEST['id'], $db);
			}
			echo 'Section saved.';
		}
		else {
			echo 'Error saving section: ' . mysql_error($db);
		}
	}

	admin_footer($user);
}
?>
