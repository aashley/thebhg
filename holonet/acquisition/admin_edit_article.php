<?php
function title() {
	return 'Administration :: Edit Article';
}

function auth($pleb) {
	global $user, $roster;

	$user = $roster->GetPerson($pleb->GetID());
	return (is_global_admin($user) || get_columns($user));
}

function output() {
	global $user, $page, $db;

	admin_header();

	if (isset($_REQUEST['content'])) {
		$result = mysql_query('SELECT * FROM aq_articles WHERE id=' . $_REQUEST['id'], $db);
		$row = mysql_fetch_array($result);
		$columns = get_columns($user);
		if (is_global_admin($user) || in_array($row['column'], array_keys($columns))) {
			if (mysql_query('UPDATE aq_articles SET cover=' . ($_REQUEST['cover'] == 'on' ? '1' : '0') . ', title="' . addslashes($_REQUEST['title']) . '", content="' . addslashes($_REQUEST['content']) . '" WHERE id=' . $_REQUEST['id'], $db)) {
				echo 'Article saved successfully.';
			}
			else {
				echo 'Error saving article: ' . mysql_error($db);
			}
		}
		else {
			echo 'You are not authorised to edit an article in this column.';
		}
	}
	elseif ($_REQUEST['id']) {
		$result = mysql_query('SELECT * FROM aq_articles WHERE id=' . $_REQUEST['id'], $db);
		$row = mysql_fetch_array($result);

		if (!is_global_admin($user) && !in_array($row['column'], array_keys(get_columns($user)))) {
			echo 'You are not authorised to edit this article.';
			admin_footer($user);
			return;
		}
		
		$form = new Form($page, 'post');
		$form->AddHidden('id', $_REQUEST['id']);
		if (is_global_admin($user)) {
			$form->AddCheckBox('Cover Article:', 'cover', 'on', $row['cover'] == 1);
		}
		$form->AddTextBox('Title:', 'title', stripslashes($row['title']), 40);
		$form->AddTextArea('Article:', 'content', stripslashes($row['content']), 10, 60);
		$form->AddSubmitButton('', 'Save Article');
		$form->EndForm();
	}
	elseif (!is_global_admin($user) || $_REQUEST['issue']) {
		$form = new Form($page, 'get');
		$form->StartSelect('Article:', 'id');
		if (is_global_admin($user)) {
			$issue_arr = explode('-', $_REQUEST['issue']);
			$year = $issue_arr[0];
			$week = $issue_arr[1];
			$dates = get_dates($year, $week);
			$result = mysql_query('SELECT id, title FROM aq_articles WHERE time ' . $dates['between'] . ' ORDER BY title ASC', $db);
		}
		else {
			$result = mysql_query('SELECT id, title FROM aq_articles WHERE `column` IN (' . implode(',', array_keys(get_columns($user))) . ') ORDER BY title ASC', $db);
		}
		if ($result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$form->AddOption($row['id'], html_escape(stripslashes($row['title'])));
			}
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit Article');
		$form->EndForm();
	}
	else {
		$form = new Form($page, 'get');
		$form->StartSelect('Issue:', 'issue');
		$start = 1076860800;
		$current = get_dates(date('Y'), date('W'));
		for ($ts = $current['end'] + 1; $ts >= $start; $ts -= 604800) {
			$year = date('Y', $ts);
			$week = date('W', $ts) - 1;
			$issue = "$year-$week";
			$dates = get_dates($year, $week);
			$form->AddOption($issue, $issue . ' (' . date('j/n/Y', $dates['start']) . ' - ' . date('j/n/Y', $dates['end']) . ')');
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Select Issue');
		$form->EndForm();
	}

	admin_footer($user);
}
?>
