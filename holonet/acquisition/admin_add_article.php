<?php
function title() {
	return 'Administration :: Add Article';
}

function auth($pleb) {
	global $user, $roster;

	$user = $roster->GetPerson($pleb->GetID());
	return (is_global_admin($user) || get_columns($user));
}

function output() {
	global $user, $page, $db;

	admin_header();

	if (isset($_REQUEST['column'])) {
		$columns = get_columns($user);
		if (is_global_admin($user) || in_array($_REQUEST['column'], array_keys($columns))) {
			if (mysql_query('INSERT INTO aq_articles (`column`, author, time, cover, title, content) VALUES (' . $_REQUEST['column'] . ', ' . $user->GetID() . ', UNIX_TIMESTAMP(), ' . ($_REQUEST['cover'] == 'on' ? '1' : '0') . ', "' . addslashes($_REQUEST['title']) . '", "' . addslashes($_REQUEST['content']) . '")', $db)) {
				echo 'Article added successfully.';
			}
			else {
				echo 'Error adding article: ' . mysql_error($db);
			}
		}
		else {
			echo 'You are not authorised to add an article to this column.';
		}
	}
	else {
		$form = new Form($page, 'post');
		$form->StartSelect('Column:', 'column');
		if (is_global_admin($user)) {
			$form->AddOption(0, 'General Article');
		}
		if ($columns = get_columns($user)) {
			foreach ($columns as $cid=>$name) {
				$form->AddOption($cid, $name);
			}
		}
		$form->EndSelect();
		if (is_global_admin($user)) {
			$form->AddCheckBox('Cover Article:', 'cover', 'on');
		}
		$form->AddTextBox('Title:', 'title', '', 40);
		$form->AddTextArea('Article:', 'content', '', 10, 60);
		$form->AddSubmitButton('', 'Add Article');
		$form->EndForm();
	}

	admin_footer($user);
}
?>
