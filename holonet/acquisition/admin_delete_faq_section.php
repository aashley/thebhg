<?php
function title() {
	return 'Delete FAQ Section';
}

function auth($pleb) {
	global $roster, $user;

	$user = $roster->GetPerson($pleb->GetID());
	return is_global_admin($user);
}

function output() {
	global $db, $page, $prefix, $user;

	admin_header();
	
	if (empty($id)) {
		$form = new Form($page);
		$form->StartSelect('Section:', 'id');
		$sec_result = mysql_query('SELECT * FROM '.$prefix.'faq_sections ORDER BY after ASC', $db);
		while ($sec = mysql_fetch_array($sec_result)) {
			$form->AddOption($sec['id'], stripslashes($sec['name']));
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Delete Section');
		$form->EndForm();
	}
	else {
		$s_result = mysql_query('SELECT * FROM '.$prefix."faq_sections WHERE id=" . $_REQUEST['id'], $db);
		$oa = mysql_result($s_result, 0, 'after');
		$oa = $oa ? "$oa" : '0';
		if (mysql_query('DELETE FROM '.$prefix."faq_sections WHERE id=" . $_REQUEST['id'], $db)) {
			mysql_query('UPDATE '.$prefix."faq_sections SET after=$oa WHERE after=" . $_REQUEST['id'], $db);
			mysql_query('DELETE FROM '.$prefix."faq WHERE section=" . $_REQUEST['id'], $db);
			echo 'Section deleted.';
		}
		else {
			echo 'Error deleting section: ' . mysql_error($db);
		}
	}

	admin_footer($user);
}
?>
