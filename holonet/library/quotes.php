<?php
if (isset($_REQUEST['id']) && $_REQUEST['id'] != 696969) {
	$user = $roster->GetPerson($_REQUEST['id']);
}

function title() {
	global $user;

	$title = 'Quote Archive';
	if (isset($user)) {
		$title .= ' :: ' . $user->GetName();
	}
	elseif (isset($_REQUEST['all'])) {
		$title .= ' :: All';
	}
	elseif (isset($_REQUEST['new'])) {
		$title .= ' :: New Quotes :: Last ' . number_format($_REQUEST['new']) . ' Days';
	}
	elseif ($_REQUEST['id'] == 696969) {
		$title .= ' :: Non-BHG';
	}
	return $title;
}

function output() {
	global $user, $db, $page;

	menu_header();
	$sql = 'SELECT * FROM irc_quotes';

	if (isset($_REQUEST['id'])) {
		$sql .= ' WHERE speaker=' . $_REQUEST['id'] . ' ORDER BY quote_id ASC';
	}
	elseif (isset($_REQUEST['new'])) {
		$sql .= ' WHERE time>=' . (time() - (int) $_REQUEST['new'] * 86400) . ' ORDER BY quote_id ASC';
	}
	elseif (isset($_REQUEST['all'])) {
		$sql .= ' ORDER BY quote_id ASC';
	}
	else {
		echo 'Please select a speaker from the menu at right.';
		hr();
		$sql .= ' ORDER BY RAND()';
	}
	$result = mysql_query($sql, $db);

	if ($result && mysql_num_rows($result)) {
		$table = new Table('', true);
		$row = mysql_fetch_array($result);
		do {
			$table->AddRow('#' . $row['quote_id'], nl2br(htmlspecialchars(stripslashes($row['quote']))));
		} while (($row = mysql_fetch_array($result)) && (isset($_REQUEST['id']) || isset($_REQUEST['all']) || isset($_REQUEST['new'])));
		$table->EndTable();
	}

	if (isset($_REQUEST['new'])) {
		hr();
		$form = new Form($page, 'get');
		$form->AddTextBox('Days to Show:', 'new', (int) $_REQUEST['new'], 3);
		$form->AddSubmitButton('', 'Go');
		$form->EndForm();
	}

	quote_footer();
}
?>
