<?php
function title() {
	return 'Administration :: Delete Article';
}

function auth($pleb) {
	global $user, $roster;

	$user = $roster->GetPerson($pleb->GetID());
	return is_global_admin($user);
}

function output() {
	global $user, $page, $db;

	admin_header();

	if (isset($_REQUEST['id'])) {
		if (mysql_query('DELETE FROM aq_articles WHERE id=' . $_REQUEST['id'], $db)) {
			echo 'Article deleted successfully.';
		}
		else {
			echo 'Error deleting article: ' . mysql_error($db);
		}
	}
	elseif (isset($_REQUEST['issue'])) {
		$form = new Form($page, 'post');
		$form->StartSelect('Article:', 'id');
		$issue_arr = explode('-', $_REQUEST['issue']);
		$year = $issue_arr[0];
		$week = $issue_arr[1];
		$dates = get_dates($year, $week);
		$result = mysql_query('SELECT id, title FROM aq_articles WHERE time ' . $dates['between'] . ' ORDER BY title ASC', $db);
		if ($result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$form->AddOption($row['id'], html_escape(stripslashes($row['title'])));
			}
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Delete Article');
		$form->EndForm();
	}
	else {
		$form = new Form($page, 'get');
		$form->StartSelect('Issue:', 'issue');
		$start = 1039410000;
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
